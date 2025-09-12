<!DOCTYPE html>
<html>
@include('dashboard.layout.head')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('dashboard.layout.navbar')
        @include('dashboard.layout.sidpar')
        @include('dashboard.layout.header')
        
        @yield(section: 'content')

        <!-- /.content -->
        @include('dashboard.layout.footer')
        @include('dashboard.layout.scripts')
    </div>
</body>

</html>
