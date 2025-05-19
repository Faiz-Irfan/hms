<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hasta MS</title>
    @include('layouts.partials.head')

</head>

<body>
    @include('layouts.partials.nav')
    @include('layouts.partials.header')
    <main id="main" class="main">
        @yield('content')
    </main>
    {{-- <div class="app">
    </div> --}}
    @include('layouts.partials.footer')
    @include('layouts.partials.scripts')
    @yield('script')
</body>

</html>
