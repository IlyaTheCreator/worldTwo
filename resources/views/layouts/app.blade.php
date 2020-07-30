<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>App name - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div id="app">
        @yield('content')
    </div>

    <script>
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}",
            baseURL: "{{ URL::to('/') }}",
            storagePath: "{{ storage_path() }}",
            publicPath: "{{ public_path() }}"
        }
    </script>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
