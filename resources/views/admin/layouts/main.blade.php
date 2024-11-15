<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- include header -->
        @include('admin.layouts.header')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">    
        <div class="wrapper">
            <!-- include navbar -->
            @include('admin.layouts.navbar')
            
            <!-- include sidebar -->
            @include('admin.layouts.sidebar')
            
            <!-- content -->
            <div class="content-wrapper">
                {{--  @include('admin.layouts.breadcrumb')  --}}
                @yield('content')
            </div>  
            
            <footer class="main-footer">
                <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/')}}">Invezza</a>.</strong>
                All rights reserved.
            </footer>
            
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
              <!-- Control sidebar content goes here -->
            </aside>
        </div>
        @include('admin.layouts.footerjs')
        @yield('pagejs')
        
    </body>
</html>
    