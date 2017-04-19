<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>{{trans('admin.businessName')}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="#1 selling multi-purpose bootstrap admin theme sold in themeforest marketplace packed with angularjs, material design, rtl support with over thausands of templates and ui elements and plugins to power any type of web applications including saas and admin dashboards. Preview page of Theme #1 for "
          name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{asset('resources/assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{asset('resources/assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{asset('resources/assets/pages/css/lock-2.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> </head>
<!-- END HEAD -->

<body class="">
<div class="page-lock">
    <div class="page-logo">
        <a class="brand" href="index.html">
            <img src="{{asset('resources/assets/pages/img/logo-big.png')}}" alt="logo" /> </a>
    </div>
    <div class="page-body">
        <img class="page-lock-img" src="{{asset('resources/assets/pages/media/profile/profile.jpg')}}" alt="">
        <div class="page-lock-info">
            <h1>{{$username}}</h1>
            <span class="email"> {{null !== $email ? $email : ''}} </span>
            <span class="locked"> 锁屏 </span>
            <form class="form-inline" action="{{url('admin/login')}}">
                @if(session('msg'))
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        {{session('msg')}}
                    </div>
                @endif
                <div class="input-group input-medium">
                    <input hidden name="username" value="{{$username}}" />
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <span class="input-group-btn">
                                <button type="submit" class="btn green icn-only">
                                    <i class="m-icon-swapright m-icon-white"></i>
                                </button>
                            </span>
                </div>
                <!-- /input-group -->
                <div class="relogin">
                    <a href="{{url('admin/login')}}"> 你不是 {{$username}} ? </a>
                </div>
            </form>
        </div>
    </div>
    <div class="page-footer-custom"> 2017 &copy; HT. {{trans('admin.businessName')}}. </div>
</div>
<script type="text/javascript">
//    定义轮播图的路径
    var pics = [];
    pics.push("http://localhost/hnis/resources/assets/pages/media/bg/1.jpg");
    pics.push("http://localhost/hnis/resources/assets/pages/media/bg/2.jpg");
    pics.push("http://localhost/hnis/resources/assets/pages/media/bg/3.jpg");
    pics.push("http://localhost/hnis/resources/assets/pages/media/bg/4.jpg");
</script>

<!--[if lt IE 9]>
<script src="{{asset('resources/assets/global/plugins/respond.min.js')}}"></script>
<script src="{{asset('resources/assets/global/plugins/excanvas.min.js')}}"></script>
<script src="{{asset('resources/assets/global/plugins/ie8.fix.min.js')}}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{asset('resources/assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('resources/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('resources/assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('resources/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('resources/assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('resources/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{asset('resources/assets/global/plugins/backstretch/jquery.backstretch.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{asset('resources/assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset('resources/assets/pages/scripts/lock-2.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>