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
    
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <link rel="shortcut icon" type="image/png" href="https://cdn1.medicalnewstoday.com/content/images/hero/284/284378/284378_1100.jpg">

    
</head>
<body>
    <div id="app">
        <main class="">
           <div class="container-fluid">
           <div class="row">
           <div class="col-md-3">
               <div class="panel">
                    <p class="panel-heading">
                        <i class="fab fa-the-red-yeti"></i> DreamEvent</p> 
                <ul class="panel-list">
                  @if(Auth::user())
                   <router-link to="/dashboard" class="panel-list_item">
                       <p><i class="fas fa-desktop desktop"></i><span> Dashboard</span></p>
                </router-link>
                 <router-link to="/users" class="panel-list_item">
                     <p><i class="fas fa-users-cog cog"></i><span> User Managment</span></p>
                </router-link>
                 <router-link to="/topics" class="panel-list_item">
                  <p><i class="fas fa-globe-europe globe"></i><span> Topics</span></p>
                </router-link>
                @endif
                </ul>
               </div>
              </div>
           <div class="col-md-9 main-bg">
           @if(Auth::user())
           <dropdown class="float-right">
                      <template v-slot:trigger>
                               <a class="vue-dropdown-menu"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSPAouyEwHdnMabUP14SJ6aNlTpPgANrn2QeRd5pjC_oldKHHkV" alt="{{Auth::user()->name}}'s avatar" class="dropdown-img">
                               
                                <span class="vue-dropdown-menu_name" href="#" role="button"  aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                   </span></a>
                              </template>
                            <div class="vue-dropdown_up">
                            <a class="vue-dropdown_item_list"><i class="fab fa-dashcube"></i> Dashboard</a>
                            <a class="vue-dropdown_item_list"><i class="fas fa-user"></i> My Profile</a>
                            <a class="vue-dropdown_item_list"><i class="fas fa-cogs"></i> Settings</a>
                              <a class="vue-dropdown_item_list" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                      <i class="fas fa-sign-out-alt"></i>  {{ __('Logout') }}
                                    </a>
                              
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
               </div>
           </dropdown>
           @endif
           @if(Auth::user())
           <router-view>
               
           </router-view>
            @else
            @yield('content')
            @endif
           </div>    
           </div>
           </div>
           
        </main>
    </div>
</body>
</html>
