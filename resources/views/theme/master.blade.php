<!DOCTYPE html>
<html lang="en">

@include('theme.layout.head')

<body>
    @include('theme.layout.header')

    @yield('content')

    @include('theme.layout.footer')
    @include('theme.layout.scripts')
</body>

</html>
