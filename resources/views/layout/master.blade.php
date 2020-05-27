<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="https://news.ycombinator.com/favicon.ico">
        <link rel="alternate" type="application/rss+xml" title="RSS" href="rss">
        <title>Hacker News Clone</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app2.css') }}" rel="stylesheet">
        <link href="{{ asset('css/jquery-confirm/jquery-confirm.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="{{ asset('js/jquery.min.js')}}"></script>
        <script src="{{ asset('js/jquery-confirm.js')}}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
        <script src="{{ asset('js/custom.js') }}" defer></script>
        <script src="{{ asset('js/popper.js') }}" defer></script>
    </head>
    <body>
    <main id="content" class="p-4 p-md-5 pt-5">
        <div class="display-messages">
            @if (count($errors ?? '') > 0)
                <div class="alert alert-danger">
                    <span class="fa fa-times-circle fa-2x" ></span><strong> - Ooops !</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors ?? ''->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (\Session::has('success'))
                <div class="alert alert-success"><span class="fa fa-check-circle fa-2x"></span><em style="vertical-align: text-bottom;"> {!! \Session::get('success'); !!}</em></div>
            @endif
            @if (\Session::has('warning'))
                <div class="alert alert-warning"><span class="fa fa-info-circle fa-2x"></span><em style="vertical-align: text-bottom;"> {!! \Session::get('warning'); !!}</em></div>
            @endif
            @if (\Session::has('info'))
                <div class="alert alert-info"><span class="fa fa-info-circle fa-2x"></span><em style="vertical-align: text-bottom;"> {!! \Session::get('info'); !!}</em></div>
            @endif

        </div>


        <div id="app">
            @yield('content')
        </div>


    </main>
    <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
