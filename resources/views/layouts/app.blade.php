<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('extra-css')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <div><img src="/png/GamerStreetIcon.png" style="height: 60px; border-right: 1px solid #333;"
                            class="pr-3"></div>
                    <div class="pl-3">Gamer Street</div>

                </a>
                @if (\Auth::check())
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-center pl-3">
                            <a href="{{ route('post.create') }}" class="btn btn-primary">
                                + Create Post
                            </a>
                        </div>
                        <div class="ui-widget ml-5 w-auto">
                            <input type='text' id="search">
                        </div>
                    </div>

                @endif
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item"
                                        href="{{ route('profile.show', ["user" => Auth::user()->id]) }}">
                                        {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                                                                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>

                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // let debounceTimer;
        // var suggestion = [];

        // $('#search').on('input', function () {
        //     clearTimeout(debounceTimer);

        //     let query = $(this).val();

        //     debounceTimer = setTimeout(() => {
        //         console.log('Search this:', query);
        //         console.log(query.length);
        //         // perform AJAX call here
        //         if (query.length > 2) {
        //             $.ajax({
        //                 url: '/search',
        //                 type: 'GET',
        //                 data: { search: query },
        //                 success: function (data) {

        //                     $.each(data, function (index, value) {
        //                         suggestion.push(value);
        //                     });
        //                     console.log(suggestion)
        //                 },
        //                 error: function (xhr) {
        //                     console.log('AJAX Error:', xhr.responseText);
        //                 }
        //             });
        //         } else {
        //             suggestion = [];
        //         }
        //     }, 1000); // 1000ms delay
        // });

        $("#search").autocomplete({
            minLength: 2, // only trigger after 2 characters
            source: function (request, response) {
                $.ajax({
                    url: "/search",
                    type: "GET",
                    data: { search: request.term },
                    success: function (data) {
                        // let array = []
                        // $.each(data, function (index, value) {
                        //     if (!array.includes(value.username)) array.push(value.username);
                        // });
                        // console.log(array)
                        // pass the result to the autocomplete
                        response(data);
                    },
                    error: function () {
                        response([]);
                    }
                });
            },
            focus: function (event, ui) {
                // Prevent value from being inserted on focus
                event.preventDefault();
            },
            select: function (event, ui) {
                console.log("User selected:", ui.item);
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                .append(`
            <a href="/profile/${item.id}" style="display: flex; align-items: center; gap: 10px; padding: 5px;">
                <span>${item.username}</span>
            </a>
        `)
                .appendTo(ul);
        };
        @if (session()->has('status') && session()->has('message'))
            window.flash = {
                message: @json(session('message')),
                status: @json(session('status'))
            };

            if (window.flash.message && window.flash.status) {
                console.log(window.flash.status); // 'success'
                console.log(window.flash.message); // 'Post has been deleted successfully'

                // Example with SweetAlert2:
                Swal.fire({
                    icon: window.flash.status,  // 'success', 'error', etc.
                    text: window.flash.message,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        @endif

        

    });
</script>
@stack('scripts')

</html>