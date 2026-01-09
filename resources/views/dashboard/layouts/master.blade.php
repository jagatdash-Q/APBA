<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    @include('dashboard.layouts.head')
</head>

<body>
    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <div class="app" id="app">

        <div id="content" class="app-content box-shadow-z0" role="main">
            
            @include('dashboard.layouts.header')
            
            @include('dashboard.layouts.menu')
            <div ui-view class="app-body" id="view">
                @include('dashboard.layouts.errors')
                @yield('content')
                @yield('modals')
            </div>
        </div>
    </div>
    @include('dashboard.layouts.foot')
    @include('dashboard.layouts.footer')
    @include('dashboard.layouts.loader')
</body>

</html>
