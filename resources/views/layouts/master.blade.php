@include('layouts.__header')

<div id="app">
    @include('layouts.__sidebar')
    @yield('content')
</div>
@include('layouts.__footer')