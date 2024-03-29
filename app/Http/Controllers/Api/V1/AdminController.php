<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FoodCommonCategoryCollection;
use App\Http\Resources\V1\ReviewResource;
use App\Http\Resources\V1\RiderResource;
use App\Http\Resources\V1\UserResource;
use App\Models\FCategorySubCategory;
use App\Models\FoodCommonCategory;
use App\Models\FooSubCategory;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Payout;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Rider;
use App\Models\User;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\UpdatedRestaurantStatus;
use Spatie\Activitylog\Models\Activity;
use App\Jobs\SendNotification;

class AdminController extends Controller
{
    use HttpResponses;

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
            ]);

            if(!Auth::attempt($request->only(['email', 'password']))){
                return $this->error(['email' => 'Invalid Credentials'], 'Invalid Credentials', 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user->hasRole('admin')) {
                return $this->error(['email' => 'You do not have permission to login.'], 'You do not have permission to login.', 401);
            }

            $token = $user->createToken($request->email);

            $user = new UserResource($user);

            return $this->success([
                'user' => $user,
                'token' => $token->plainTextToken,

            ]);
        } catch (\Throwable $th) {
            info($th->getMessage());
            return $this->error('', $th->getMessage(), 403);
        }
    }

    public function dashboard()
    {
        $users = User::whereHasRole('orderer')->count();
        $restaurants = User::whereHasRole('restaurant')->count();
        $riders = User::whereHasRole('rider')->count();
        $orders = Order::where('status', 2)->count();

        $months = [];
        // Get past 12 months
        for ($i = 12; $i >= 0; $i--) {
            $month = Carbon::today()->startOfMonth()->subMonth($i);
            $year = Carbon::today()->startOfMonth()->subMonth($i)->format('Y');
            array_push($months, $month);
        }

        // Format months
        $months_formatted = [];
        foreach ($months as $key => $month) {
            array_push($months_formatted, Carbon::parse($month)->format('M'));
        }
        // Orders
        $total_monthly_orders = [];
        $total_orders = 0;

        $index = 0;
        foreach ($months as $month) {
            $order = Order::where('status', 2)->whereBetween('created_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])->count();
            array_push($total_monthly_orders, $order);
            $total_orders += $order;
            $index++;
        }

        // Get current months earning
        $current_month_orders = Order::where('status', 2)->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();

        // Previous months orders
        $prev_month = now()->subMonths(1);
        $prev_month_orders = Order::where('status', 2)->whereBetween('created_at', [Carbon::parse($prev_month)->startOfMonth(), Carbon::parse($prev_month)->endOfMonth()])->count();

        // Compare current months orders to previous month
        if ($prev_month_orders != 0) {
            $orders_difference = ceil(($current_month_orders / $prev_month_orders) * 100);
        } else {
            $orders_difference = ceil($current_month_orders / 100);
        }

        $orders_direction = '';

        if ($orders_difference < 0) {
            $orders_direction = 'less';
        } else if ($orders_difference > 0) {
            $orders_direction = 'more';
        }

        $orders_made_monthly = array(
            'labels' => $months_formatted,
            'name' => 'Orders',
            'data' => $total_monthly_orders,
            'orders_direction' => $orders_direction,
            'orders_difference' => $orders_difference,
            'total_orders' => $total_orders,
        );
        // End Orders

        // Payments
        $total_monthly_payments = [];
        $total_payments = 0;

        $index = 0;
        foreach ($months as $month) {
            $order = Payment::whereBetween('created_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])->count();
            array_push($total_monthly_payments, $order);
            $total_payments += $order;
            $index++;
        }

        // Get current months payments
        $current_month_payments = Payment::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();

        // Previous months payments
        $prev_month = now()->subMonths(1);
        $prev_month_payments = Payment::whereBetween('created_at', [Carbon::parse($prev_month)->startOfMonth(), Carbon::parse($prev_month)->endOfMonth()])->count();

        // Compare current months orders to previous month
        if ($prev_month_payments != 0) {
            $payments_difference = ($current_month_payments / $prev_month_payments) * 100;
        } else {
            $payments_difference = $current_month_payments / 100;
        }

        $payments_direction = '';

        if ($payments_difference < 0) {
            $payments_direction = 'less';
        } else if ($payments_difference > 0) {
            $payments_direction = 'more';
        }

        $payments_made_monthly = array(
            'labels' => $months_formatted,
            'name' => 'Payments',
            'data' => $total_monthly_payments,
            'payments_direction' => $payments_direction,
            'payments_difference' => $payments_difference,
            'total_payments' => $total_payments,
        );

        // Top Restaurants
        $top_restaurants = Restaurant::withCount('orders')->with('user', 'orders')->whereHas('orders')->orderBy('orders_count', 'DESC')->get()->take(5);

        // Top Menu Items
        $top_menu_items = Menu::withCount('orderItems')->with('restaurant')->whereHas('orderItems')->orderBy('order_items_count', 'DESC')->get()->take(5);

        $top_menu_items_series = [];
        $top_menu_items_names = [];
        $total_orders_count = 0;
        foreach($top_menu_items as $item) {
            $total_orders_count += $item->order_items_count;
        }

        foreach ($top_menu_items as $key => $item) {
            array_push($top_menu_items_names, $item->title);
            array_push($top_menu_items_series, ceil(($item->order_items_count / $total_orders_count) * 100));
        }

        $top_menu_series = [
            'top_menu_items_names' => $top_menu_items_names,
            'top_menu_items_series' => $top_menu_items_series
        ];

        return $this->success([
            'users' => $users,
            'restaurants' => $restaurants,
            'riders' => $riders,
            'orders' => $orders,
            'orders_series' => $orders_made_monthly,
            'payments_series' => $payments_made_monthly,
            'top_restaurants' => $top_restaurants,
            'top_menu_series' => $top_menu_series,
        ]);
    }

    public function categories()
    {
        $categories = FoodCommonCategory::with('food_sub_categories')->where('title', '!=', 'groceries')->orderBy('created_at', 'DESC')->paginate(7);

        return $this->success($categories);
    }

    public function subCategories(Request $request)
    {
        $search = $request->query('search');

        $category = FoodCommonCategory::where('title', $search)->first();

        $sub_category_ids = FCategorySubCategory::where('category_id', $category->id)->get()->pluck('sub_category_id');

        $sub_categories = FooSubCategory::whereIn('id', $sub_category_ids)
                                        ->orderBy('created_at', 'DESC')
                                        ->paginate(7);

        return $this->success($sub_categories);
    }

    public function addSubCategory(Request $request)
    {
        $request->validate([
            // 'category_id' => ['required'],
            'title' => ['required'],
            'status' => ['required', 'integer'],
        ]);

        $groceries = FoodCommonCategory::where('title', 'groceries')->first();

        $subcategory = FooSubCategory::create([
            'category_id' => $groceries->id,
            'title' => $request->title,
            'description' => $request->has('description') && $request->description != '' ? $request->description : NULL,
            'status' => $request->status,
            'image' => pathinfo($request->image->store('subcategory', 'category'), PATHINFO_BASENAME),
            'created_by' => auth()->user()->email,
        ]);

        FCategorySubCategory::create([
            'sub_category_id' => $subcategory->id,
            'category_id' => $groceries->id,
            'created_by' => auth()->user()->email,
        ]);

        return $this->success($subcategory, 'Subcategory successfully created');
    }

    public function updateSubcategory(Request $request, $id)
    {
        $request->validate([
            'title' => ['required'],
        ]);

        $subcategory = FooSubCategory::find($id);

        $subcategory->update([
            'title' => $request->title,
            'description' => $request->has('description') && $request->description != '' ? $request->description : $subcategory->description,
            'status' => $request->status,
            'image' => pathinfo($request->image->store('subcategory', 'category'), PATHINFO_BASENAME),
            'updated_by' => auth()->user()->email,
        ]);

        return $this->success($subcategory, 'Subcategory successfully created');
    }

    public function users(Request $request, $role)
    {
        $search = $request->query('search');

        $users = User::with('orders', 'restaurants.orders', 'restaurants.menus', 'restaurants.users', 'rider.tips', 'deliveries')
                        ->whereHas('roles', function ($query) use ($role) { $query->where('name', $role); })
                        ->when($search && $search != '', function($query) use ($search) {
                            $query->where(function ($query) use ($search) {
                                $query->where('name', 'LIKE', '%'.$search.'%')
                                        ->orWhere('email', 'LIKE', '%'.$search.'%');
                            });
                        })
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);

        return $this->success($users);
    }

    public function user($id)
    {
        $user = User::withCount('orders', 'restaurants')->with(['roles'])->find($id);

        $restaurants = Restaurant::where('user_id', $user->id)->with('orders')->paginate(5);

        $orders = Order::where('user_id', $user->id)->with('restaurant')->paginate(5);

        return $this->success(['user' => $user, 'orders' => $orders, 'restaurants' => $restaurants]);
    }

    public function restaurantAdmin($id)
    {
        $user = User::withCount('orders', 'restaurants')->with(['roles'])->find($id);

        $restaurants = Restaurant::where('user_id', $user->id)->with('orders')->paginate(5);

        return $this->success(['restaurants' => $restaurants, 'user' => $user]);
    }

    public function rider($id)
    {
        $user = User::with('deliveries.restaurant', 'deliveries.user', 'roles')->find($id);

        $rider_profile = null;
        if ($user->rider) {
            $rider_profile = new RiderResource(Rider::where('user_id', $user->id)->first());
        }

        $deliveries = Order::where('rider_id', $id)->orderBy('created_at', 'DESC')->paginate(5);

        return $this->success(['user' => $user, 'deliveries' => $deliveries, 'rider_profile' => $rider_profile]);
    }

    public function updateRiderStatus(Request $request, Rider $rider)
    {
        $request->validate([
            'status' => ['required', 'in:approved,denied']
        ]);

        $rider->update([
            'status' => $request->status == 'approved' ? '2' : '3',
            'rejection_reason' => $request->has('rejection_reason') && !empty($request->rejection_reason) ? $request->rejection_reason : NULL,
        ]);

        if ($rider->user->device_token) {
            // Send Notification to user
            SendNotification::dispatchAfterResponse($rider->user->device_token, 'Your profile has been '.$request->status, ['rejection_reason' => $request->has('rejection_reason') && !empty($request->rejection_reason) ? $request->rejection_reason : NULL]);
        }

        return $this->success(['message' => 'Rider profile updated successfully']);
    }

    public function restaurants(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $restaurants = Restaurant::with('user', 'orders', 'menus')
                                ->when($search && $search != '', function($query) use ($search) {
                                    $query->where('name', 'LIKE', '%'.$search.'%')
                                        ->orWhereHas('user', function ($query) use ($search) {
                                            $query->where('name', 'LIKE', '%'.$search.'%');
                                        });
                                })
                                ->when($status && $status != '', function ($query) use ($status) {
                                    $query->where(function ($query) use ($status) {
                                        $query->where('status', $status);
                                    });
                                })
                                ->orderBy('created_at', 'DESC')
                                ->paginate(10);

        return $this->success($restaurants);
    }

    public function restaurant($id)
    {
        $restaurant = Restaurant::with('user', 'users', 'orders.payment', 'orders.user', 'menus', 'operatingHours', 'documents', 'reviews')
                            ->withCount('orders', 'menus')
                            ->orWhere('uuid', $id)
                            ->first();

        return $this->success(['restaurant' => $restaurant, 'average_rating' => $restaurant->averageRating()]);
    }

    public function restaurantReviews(Restaurant $restaurant)
    {
        $review = Review::where('reviewable_type', Restaurant::class)->where('reviewable_id', $restaurant->id)->get();

        return ReviewResource::collection($review);
    }

    public function restaurantPayments(Request $request, Restaurant $restaurant)
    {
        $search = $request->query('search');

        $payments = Payment::with('order.restaurant', 'order.user')
                            ->where('transaction_id', '!=', NULL)
                            ->whereHas('order', function ($query) use ($restaurant) {
                                $query->whereHas('restaurant', function ($query) use ($restaurant) {
                                    $query->where('id', '=', $restaurant->id);
                                });
                            })
                            ->when($search && $search != '', function ($query) use ($search) {
                                $query->whereHas('order', function ($query) use ($search) {
                                    $query->where(function ($query) use ($search) {
                                        $query->where('uuid', 'LIKE', '%'.$search.'%')
                                            ->orWhereHas('user', function ($query) use ($search) {
                                                $query->where('name', 'LIKE', '%'.$search.'%');
                                            });
                                    });
                                });
                            })
                            ->orderBy('created_at', 'DESC')
                            ->paginate(5);

        return $this->success($payments);
    }

    public function updateRestaurantStatus(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'status' => ['required', 'in:2,3'],
            'reason' => ['nullable', 'string', 'required_if:status,3'],
        ]);

        $restaurant->update([
            'status' => $request->status,
            'denied_reason' => $request->has('reason') && $request->reason != '' && $request->status == '3' ? $request->reason : NULL
        ]);

        $restaurant->notify(new UpdatedRestaurantStatus($restaurant->status, $request->has('reason') && $request->reason != '' ? $request->reason : ''));

        return $this->success('Restaurants updated successfully');
    }

    public function updateServiceChargeAgreement(Restaurant $restaurant, Request $request)
    {
        if ($request->has('groceries')) {
            $restaurant->update([
                'groceries_service_charge_agreement' => $request->service_charge_agreement
            ]);
        } else {
            $restaurant->update([
                'service_charge_agreement' => $request->service_charge_agreement
            ]);
        }

        return $this->success('Restaurant updated successfully');
    }

    public function restaurantOrders(Request $request, Restaurant $restaurant)
    {
        $search = $request->query('search');

        $orders = Order::with('user')
                        ->where('restaurant_id', $restaurant->id)
                        ->when($search && $search != '', function ($query) use ($search) {
                            $query->where('uuid', 'LIKE', '%' . $search . '%')
                                ->where(function ($query) use ($search) {
                                    $query->orWhereHas('user', function ($query) use ($search) {
                                        $query->where('name', 'LIKE', '%' . $query . '%');
                                    });
                                });
                        })
                        ->orderBy('created_at', 'DESC')
                        ->paginate(5);

        return $this->success($orders);
    }

    public function restaurantMenu(Request $request, Restaurant $restaurant)
    {
        $search = $request->query('search');

        $menu = Menu::with('images', 'menuPrices', 'subCategories', 'categories.food_sub_categories', 'discount')
                    ->withCount('orderItems')
                    ->where('restaurant_id', $restaurant->id)
                    ->when($search && $search != '', function ($query) use ($search) {
                        $query->where(function ($query) use ($search) {
                            $query->where('title', 'LIKE', '%' . $search . '%')
                                    ->orWhere('description', 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->orderBy('created_at', 'DESC')
                    ->paginate(9);

        $categories = FoodCommonCategory::where('restaurant_id', NULL)->orWhere('restaurant_id', $restaurant->id)->get();

        return $this->success(['menu' => $menu, 'categories' => new FoodCommonCategoryCollection($categories)]);
    }

    public function restaurantCategories($id)
    {
        $restaurant = Restaurant::where('uuid', $id)->first();

        $categories = FoodCommonCategory::where('restaurant_id', $restaurant->id)->paginate(8);

        return $this->success(['categories' => $categories]);
    }

    public function orders(Request $request)
    {
        $search = $request->query('search');
        $per_page = $request->query('per_page');

        $orders = Order::with('user', 'restaurant')
                        ->when($search && $search != '', function($query) use ($search) {
                            $query->whereHas('user', function ($query) use ($search) {
                                $query->where('name', 'LIKE', '%'.$search.'%');
                            })
                            ->orWhereHas('restaurant', function ($query) use ($search) {
                                $query->where('name', 'LIKE', '%'.$search.'%')
                                        ->orWhere('about', 'LIKE', '%'.$search.'%');
                            });
                        })
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);

        return $this->success($orders);
    }

    public function order(Order $order)
    {
        $order = $order->load('restaurant', 'rider', 'orderItems.menu', 'user');

        return $this->success($order);
    }

    public function payments(Request $request)
    {
        $search = $request->query('search');

        $total_amount = 0;
        $total_service_charges = 0;
        $paid_amount = 0;
        $unpaid_amount = 0;
        $restaurant_earnings = 0;
        $rider_earnings = 0;
        $restaurant_amount_paid_out = 0;
        $rider_amount_paid_out = 0;

        $orders = Order::where('delivery_status', 'delivered')->get();

        $total_amount = Payment::where('transaction_id', $orders->pluck('id'))->sum('amount');
        $total_service_charges = $orders->where('delivery_status', 'delivered')->sum('service_charge');
        $total_amount = $total_amount - $total_service_charges;
        $restaurant_earnings = $total_amount;
        $rider_earnings = $orders->where('delivery_status', 'delivered')->where('delivery', true)->sum('total_amount');

        $paid_amount = Payout::sum('amount');
        $restaurant_amount_paid_out = Payout::where('payable_type', Restaurant::class)->sum('amount');
        $rider_amount_paid_out = Payout::where('payable_type', User::class)->sum('amount');

        $unpaid_amount = (int) $total_amount - (int) $paid_amount;

        $payments = Payment::with('order.user', 'order.restaurant')
                            ->where('transaction_id', '!=', NULL)
                            ->when($search && $search != null, function ($query) use ($search) {
                                $query->whereHas('order', function ($query) use ($search) {
                                    $query->whereHas('user', function ($query) use ($search) {
                                        $query->where('name', 'LIKE', '%'.$search.'%')->orWhere('email', 'LIKE', '%'.$search.'%');
                                    });
                                })
                                ->orWhereHas('order', function ($query) use ($search) {
                                    $query->whereHas('restaurant', function ($query) use ($search) {
                                        $query->where('amount', 'LIKE', '%'.$search.'%')->orWhere('about', 'LIKE', '%'.$search.'%');
                                    });
                                });
                            })
                            ->orderBy('created_at', 'DESC')
                            ->paginate(10);

        return $this->success([
            'payments' => $payments,
            'total_amount' => $total_amount,
            'paid_out_amount' => $paid_amount,
            'unpaid_amount' => $unpaid_amount,
            'restaurant_earnings' => $restaurant_earnings,
            'rider_earnings' => $rider_earnings,
            'total_service_charges' => $total_service_charges,
            'restaurant_amount_paid_out' => $restaurant_amount_paid_out,
            'rider_amount_paid_out' => $rider_amount_paid_out,
        ]);
    }

    public function logs(Request $request)
    {
        $search = $request->query('search');

        $logs = Activity::with('causer', 'subject')
                                ->paginate(10);

        return $this->success($logs);
    }

    public function discounts(Request $request)
    {
        $search = $request->query('search');

        $menu = Menu::with('discount', 'restaurant')
                    ->whereHas('discount')
                    ->when($search && $search != '', function ($query) use ($search) {
                        $query->where('title', 'LIKE', '%'.$search.'%');
                    })
                    ->paginate(6);

        return $this->success([
            'discounts' => $menu,
        ]);
    }
}
