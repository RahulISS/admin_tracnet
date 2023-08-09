<!doctype html>

<html lang="en" class="semi-dark">

<head>

   @include('includes.head')
   <style>
    .topbar {
        background: #00719e9e;
    }
    .remove-ps .ps {
        overflow: unset!important;
    }

   </style>
</head>

<body onload="info_noti()">

    <div class="wrapper">
        
        @if(Route::currentRouteName() != 'adminLogin')
            @include('includes.sidemenu')
        @endif
        @if(Route::currentRouteName() != 'adminLogin')
       
            @include('includes.header')
    
        @endif
        
        @yield('content')
    
    </div>
    @if(Route::currentRouteName() != 'adminLogin')
        
        @include('includes.footer')
    
    @endif
    @yield('scripts')
    
</body>
    
</html>