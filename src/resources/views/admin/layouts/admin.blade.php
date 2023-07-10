<!doctype html>
<html lang="en" data-color-mode="dark" data-dark-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    >
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite(['resources/scss/admin.scss', 'resources/ts/admin.ts'])
</head>
<body>
    @include('admin.partials.header')

    @include('admin.partials.notification')

    <div class="d-flex p-4">
        @auth
            <div class="pr-4" style="max-width: 360px; flex-basis: 20%">
                @include('admin.partials.sidenave')
            </div>
        @endauth

        <div class="flex-auto">
            @yield('content')
        </div>
    </div>
</body>
</html>
