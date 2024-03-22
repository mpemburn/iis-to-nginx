<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    @livewireStyles

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Convert IIS web.config to Nginx Format</h3>
                    </div>
                    <div class="card-body no-margin">
                        <livewire:convert/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@livewireScripts

</body>
</html>
