<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link href="{{ theme('css/error.css')}}"  rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="code">
                @yield('code')
            </div>

            <div class="message p-5">
                @yield('message')
            </div>
        </div>
    </body>
</html>
