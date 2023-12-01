@extends(Auth::user()->is_admin == 0 ? 'layouts.layout' : (Auth::user()->is_admin == 1 ? 'layouts.adminlayout' : 'layouts.guidancelayout'))
@section('content')
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-csrf="{{ csrf_token() }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>

    <body class="antialiased">

        @if (session()->has('error'))
            <div class="absolute top-20 left-0 right-0 flex items-center justify-center w-full p-4 md:p-6" id="alert">
                <div class="bg-red-300 rounded-lg text-red-700 font-semibold shadow-md p-2 md:p-4 md:text-base">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        <div
            class="min-h-screen xl:min-h-full flex justify-center items-center bg-gradient-to-b from-slate-200 via-slate-100 to-slate-300">

            <div class="w-[90%] md:w-[50%] xl:max-w-full max-w-screen-md bg-white rounded-xl shadow-lg p-8 space-y-8">

                <div class="flex flex-col sm:flex-row items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">MindScape Video Call</h1>

                    <!-- Notification Icon -->
                    <div class="relative cursor-pointer" onclick="toggleNotifications()">
                        <i class="fa-solid fa-bell fa-2x text-gray-800"></i>
                        <span id="notificationCount"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-4 h-4 text-xs flex items-center justify-center">
                            {{ $unreadNotificationCount }}
                        </span>

                        <!-- Notifications Container -->
                        <div id="notificationsContainer"
                            class="hidden absolute w-[390px] right-[-175px] md:top-0 md:right-0 md:mt-8 bg-white border border-gray-200 rounded-md shadow-md max-w-sm overflow-hidden md:w-96 z-10">
                            <div class="p-4">
                                @forelse ($notifications as $notification)
                                    <div class="notification mb-2">
                                        {{ $notification->data['message'] }}
                                        <button onclick="copyToClipboard('{{ $notification->data['meeting_code'] }}')"
                                            class=" px-2 py-1 rounded-md hover:bg-gray-300 focus:outline-none focus:ring focus:border-blue-300 absolute right-3">
                                            <i class="fa-solid fa-copy text-maroon"></i>
                                        </button>
                                    </div>
                                    <hr class="my-2">
                                @empty
                                    <p class="text-gray-500">No notifications</p>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>

                <div>
                    <form method="post" action="{{ route('validateMeeting') }}">
                        {{ csrf_field() }}
                        <div class="mt-4 flex rounded-md shadow-sm items-center justify-center">
                            <div class="relative flex items-stretch flex-grow mb-2 md:mb-0 md:mr-2">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                    </svg>
                                </div>
                                <input type="text" name="meetingId" id="meetingId"
                                    class="block w-full rounded-none rounded-l-md pl-10 sm:text-sm border-gray-300"
                                    placeholder="Meeting ID" autocomplete="off" required>
                            </div>
                            <button type="submit"
                                class="mt-2 md:mt-0 md:w-auto relative inline-flex items-center space-x-2 px-4 py-2 border border-red-800 text-sm font-medium rounded-md text-white bg-maroon hover:bg-red-800 focus:outline-none focus:ring-1 focus:ring-red-800 focus:border-red-800">
                                <span>Join Meeting</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/notification.js') }}" defer></script>
    </body>

    </html>
@endsection
