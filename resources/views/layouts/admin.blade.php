<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Styles -->
    <link href="{{ elixir('css/all.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons Icons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-blue">
    <div class="wrapper">

        <!-- Header -->
        @include('admin.includes.header')

        <!-- Sidebar -->
        @include('admin.includes.sidebar.index')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    {{ $page_title or "Page Title" }}
                    <small>{{ $page_description or null }}</small>
                </h1>

                <!-- You can dynamically generate breadcrumbs here -->
                @if(isset($breadcrums))
                    <ol class="breadcrumb">
                        @foreach($breadcrums as $item)
                            @if(array_key_exists('active', $item))
                                <li class="active">{{ $item['name'] }}</li>
                            @else
                                <li>
                                    <a href="{{ $item['url'] }}">
                                        @if(array_key_exists('icon', $item))
                                            <i class="{{ $item['icon'] }}"></i>&nbsp;
                                        @endif
                                        {{ $item['name'] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                @endif

                @include('admin.includes.alert')
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                @yield('content')
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <!-- Footer -->
        @include('admin.includes.footer')

    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
    <script src="{{ elixir('js/all.js') }}"></script>


    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience -->
</body>
</html>