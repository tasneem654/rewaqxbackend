<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title> <!-- Dynamic Title -->

    <!-- Include Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Include CSS Styles (from individual pages like login.blade.php) -->
    @yield('styles')
</head>
<body>
    <div class="container">
        <!-- Content from the child view -->
        @yield('content')
    </div>
</body>
</html>
