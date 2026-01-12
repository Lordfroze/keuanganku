<div id="app">
    <div id="main">
        @include('layouts.__header')
        @include('layouts.__sidebar')
        @yield('content')
        @include('layouts.__footer')
    </div>
</div>