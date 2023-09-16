<?php

namespace App\Helpers;

use App\Jobs\SendNotification;
use App\Models\AssignedOrder;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class AssignOrder
{
    public static function assignOrder($order_id)
    {
        $rider = NULL;
        $success = true;
        $order = Order::with('user')->find($order_id);
        $rider = self::getRider($order_id);

        if($rider) {
            $pickup_address = NULL;
            if ($order->restaurant->latitude && $order->restaurant->longitude) {
                $pickup_address = [$order->restaurant->latitude, $order->restaurant->longitude];
            }

            $delivery_address = NULL;
            if ($order->user->latitude && $order->user->longitude) {
                $delivery_address = [$order->user->latitude, $order->user->longitude];
            }

            $notification_response = false;
            $response = SendNotification::dispatchSync(User::find($rider->id), 'You have been assigned delivery.', ['pickup_address' => $pickup_address, 'delivery_address' => $delivery_address, 'order_code' => $order->id]);
            $notification_response = json_decode($response)->success == 1 ? true : false;
            while (!$notification_response) {
                AssignedOrder::create([
                    'user_id' => $rider->id,
                    'order_id' => $order->id,
                    'status' => 'rejected'
                ]);
                $response = SendNotification::dispatchSync(User::find($rider->id), 'You have been assigned delivery.', ['pickup_address' => $pickup_address, 'delivery_address' => $delivery_address, 'order_code' => $order->id]);
                $notification_response = json_decode($response)->success == 1 ? true : false;
                $rider = self::getRider($order_id);
            }

            return $success;
        }

        $success = false;
        return $success;
    }

    private static function getRider($order)
    {
        $order = Order::find($order);
        // Get Unassigned Couriers and order by closest
        $rider = User::where('device_token', '!=', NULL)
                        ->whereHas('roles', function($query) {
                            $query->where('name', 'rider');
                        })
                        // ->where('status', 'Active')
                        ->where(function($query) use ($order) {
                            $assigned_riders = Order::where('rider_id', '!=', NULL)->get()->pluck('rider_id');
                            $rejected_orders = AssignedOrder::where('order_id', $order->id)->where('status', 'rejected')->pluck('user_id');
                            $query->whereNotIn('id', $assigned_riders)
                                    ->whereNotIn('id', $rejected_orders);
                        })
                        ->get()
                        // Filter by distance to restaurant
                        ->each(function($rider, $key) use ($order) {
                            if ($rider->latitude != NULL && $rider->lognitude != NULL) {
                                $business_location = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$rider->latitude.','.$rider->longitude.'&destinations='.$order->restaurant->latitude.','.$order->restaurant->longitude.'&key='.config('services.map.key'));

                                if (json_decode($business_location)->rows[0]->elements[0]->status != "NOT_FOUND") {
                                    $distance = json_decode($business_location)->rows[0]->elements[0]->distance->text;
                                    $time = json_decode($business_location)->rows[0]->elements[0]->duration->text;
                                    $rider['distance'] = $distance;
                                    $rider['time_away'] = $time;
                                }
                            } else {
                                $rider['distance'] = NULL;
                                $rider['time_away'] = NULL;
                            }
                        })
                        // Order by distance and time
                        ->sortBy([
                            fn($a, $b) => (double) explode(' ', $a['distance'])[0] >= (double) explode(' ',$b['distance'])[0],
                        ])
                        // Get the first courier
                        ->first();

        return $rider;
    }
}