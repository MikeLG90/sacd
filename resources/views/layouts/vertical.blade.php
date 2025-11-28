<!DOCTYPE html>
<html lang="en" @yield('html') data-bs-theme="light" data-topbar-color="light" data-menu-color="dark" data-menu-size="default">

<head>
    @include('layouts.partials/title-meta', ['title' => $title])

    @yield('css')

    @include('layouts.partials/head-css')
</head>

<body @yield('body')>

    <div class="wrapper">

        @include('layouts.partials/menu')

        <!-- ==================================================== -->
        <!-- Start Page Content here -->
        <!-- ==================================================== -->
        <div class="page-content">

            <!-- Start Content-->
            <div class="container-fluid">

                @yield('content')

            </div>

            @include('layouts.partials/footer')

        </div>

    </div>

    @include('layouts.partials/right-sidebar')
    @include('layouts.partials/vendor-scripts')

    @vite(['resources/js/app.js', 'resources/js/layout.js'])

    @yield('script')

</body>

</html>
