<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Mobo Eats') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-comfortaa">
        <div class="bg-white">
            @include('layouts.navigation')

            <section
                class="relative bg-home-hero bg-cover bg-center bg-no-repeat"
            >
                <div
                    class="absolute inset-0"
                ></div>
                    <div
                        class="relative lg:px-24 4xl:px-48 px-4 pb-32 sm:px-6 lg:flex lg:h-[390px] lg:items-center"
                    >
                </div>
            </section>

            <div class="block lg:flex lg:gap-6 px-2 lg:px-44 mt-4">
                <div class="lg:basis-1/2 py-2">
                    <div class="flex flex-col gap-4">
                        <div class="border-2 border-primary-one p-2 rounded-md">
                            <h4 class="font-extrabold text-xl">Customer Support</h4>
                            <h5 class="font-bold">For assistance with orders, deliveries, or any other inquiries, our dedicated customer support is here to help.</h5>
                            <div class="flex flex-col">
                                <span class="font-bold">Email: <a href="mailto:support@moboeats.com" class="underline">support@moboeats.com</a></span>
                                {{-- <span class="font-bold">Phone: <a href="tel:+44345454556" class="">+44 345 454 5565</a></span> --}}
                            </div>
                        </div>
                        <div class="border-2 border-primary-one p-2 rounded-md">
                            <h4 class="font-extrabold text-xl">Business Inquiries</h4>
                            <h5 class="font-bold">Interested in partnering with us or have questions about our services for restaurants? Get in touch with our business development team</h5>
                            <div class="flex flex-col">
                                <span class="font-bold">Email: <a href="mailto:support@moboeats.com" class="underline">sales@moboeats.com</a></span>
                                {{-- <span class="font-bold">Phone: <a href="tel:+44345454556" class="">+44 345 454 5565</a></span> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:basis-1/2 py-1">
                    <h3 class="text-black text-3xl font-extrabold py-1">Get in Touch</h3>
                    <form action="{{ route('submit.contact-us') }}" method="post">
                        @csrf
                        <div class="flex flex-col">
                            <label class="text-black text-md font-bold">Full Name</label>
                            <input name="name" class="border-2 px-2 border-gray-300 dark:border-gray-300 dark:text-dark bg-slate-200 focus:border-gray-400 dark:focus:border-gray-400 focus:ring-gray-400 dark:focus:ring-gray-400 rounded-md shadow-sm h-10" />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-black text-md font-bold">Email Address</label>
                            <input name="email" class="border-2 px-2 border-gray-300 dark:border-gray-300 dark:text-dark bg-slate-200 focus:border-gray-400 dark:focus:border-gray-400 focus:ring-gray-400 dark:focus:ring-gray-400 rounded-md shadow-sm h-10" />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-black text-md font-bold">Message</label>
                            <textarea name="message" id="" class="w-full px-2 bg-gray-200 border-0 rounded-md" rows="5"></textarea>
                            <span class="text-red-600 font-semibold">{{ $errors->first('message') }}</span>
                        </div>
                        <div class="flex justify-end py-2">
                            <button type="submit" class="bg-primary-one mb-8 rounded-lg text-white px-4 py-1 font-bold tracking-wider w-full lg:w-1/2">Send</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="block lg:flex lg:gap-6 px-2 lg:px-44 mt-4 lg:items-center lg:justify-between pb-8">
                <div class="flex flex-col gap-4 items-center">
                    <i class="fas fa-envelope text-white text-4xl py-8 px-9 w-fit rounded-full bg-primary-one"></i>
                    <span class="font-semibold text-center">Email Address</span>
                    <a href="mailto:info@moboeats.co.uk" class="font-bold text-slate-600 text-center">info@moboeats.co.uk</a>
                </div>
                <div class="flex flex-col gap-4 items-center">
                    <i class="fas fa-map-marker text-white text-4xl mb-2 py-7 px-9 w-fit rounded-full bg-primary-one"></i>
                    <span class="font-semibold text-center">Find Us here</span>
                    <span class="font-bold text-slate-600 text-center">128 City Road, London, United Kingdom, EC1V 2NX</span>
                </div>
                <div class="flex flex-col gap-4 items-center">
                    <i class="fas fa-share-alt text-white text-4xl mb-2 py-8 px-9 w-fit rounded-full bg-primary-one"></i>
                    <span class="font-semibold text-center">Connect with us</span>
                    <a href="https://www.linkedin.com/company/mobo-eats" target="_blank" class="font-bold text-slate-600 text-center">Click Here</a>
                </div>
            </div>
            @include('layouts.footer')
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.0/flowbite.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        @if (config('app.env') == 'production')
            <!--Start of Tawk.to Script-->
            <script type="text/javascript">
                var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
                (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/6612d15e1ec1082f04dfc429/1hqso3mv2';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
                })();
            </script>
        @endif
        <script>
            $(window).scroll(function () {
                const scroll = $(window).scrollTop();

                let scrollThreshold = 0.5;

                if (scroll > scrollThreshold) {
                    // Apply the background color to the body element
                    $('#main-header').css('border-bottom', '4px solid #F7C410');
                } else {
                    $('#main-header').css('border-bottom', 'none');
                }
            });
        </script>
    </body>
</html>
