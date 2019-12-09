<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dream</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="shortcut icon" type="image/png" >


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
          

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAorsjtV7VJRlduybX8UoWYrD9SaRKWX7A&libraries=places"></script>


           <script>
    window.App={!! json_encode([
                'csrfToken'=>csrf_token(),
                'user'=>Auth::user(),
                'signedIn'=>Auth::check()
                ]) !!};
    </script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" type="text/javascript"></script>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        
    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <link rel="shortcut icon" type="image/png" href="https://cdn1.medicalnewstoday.com/content/images/hero/284/284378/284378_1100.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
         
         
        <!-- Styles -->
        <style>
            html, body {

                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #ffffff;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
       <div id="app">
          <vue-progress-bar></vue-progress-bar>
           <div class="main-navbar">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                            <dropdown class="float-right">
                      <template v-slot:trigger>
                               <a class="vue-dropdown-menu"><img src="{{Auth::user()->profile}}" alt="{{Auth::user()->name}}'s avatar" class="dropdown-img">
                               
                                <span class="vue-dropdown-menu_name" href="#" role="button"  aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                   </span></a>
                              </template>
                            <div class="vue-dropdown_up">
                            <a class="vue-dropdown_item_list" href="/dashboard"><i class="fab fa-dashcube"></i> Dashboard</a>
                            <a class="vue-dropdown_item_list" href="/profile/{{ Auth::user()->id }}"><i class="fas fa-user"></i> My Profile</a>
                            <a class="vue-dropdown_item_list"><i class="fas fa-cogs"></i>My Events</a>
                              <a class="vue-dropdown_item_list" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                      <i class="fas fa-sign-out-alt"></i>  {{ __('Logout') }}
                                    </a>
                              
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
               </div>
           </dropdown>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            </div>
        