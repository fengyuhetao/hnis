@extends('admin.layouts.admin')
@section('plugincss')
    <link href="{{asset('resources/assets/global/plugins/jstree/dist/themes/default/style.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section("content")
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>系统管理</span>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>权限管理</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> 权限管理
        </h1>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-6">
                <div class="portlet yellow-lemon box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>权限列表</div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                            <a href="javascript:;" class="reload" onclick="UITree.refresh()"></a>
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="tree_3" class="tree-demo"> </div>
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-speech font-green"></i>
                            <span class="caption-subject bold font-green uppercase">权限信息</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form role="form">
                            {{csrf_field()}}
                            <input type="hidden" name="pri_id" value=""/>
                            <div class="form-group">
                                <label class="control-label">权限名称</label>
                                <input type="text" name="pri_name" placeholder="权限名称" class="form-control" /> </div>
                            <div class="form-group">
                                <label class="control-label">url地址</label>
                                <input type="email" name="pri_url" placeholder="admin/index" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">icon图标</label>
                                <input type="email" name="pri_icon" placeholder="fa fa-folder icon-state-warning" class="form-control" />
                            </div>
                            <div class="margin-top-10">
                                <a href="javascript:;" class="btn green" onclick="save_pri()">保存</a>
                                <a href="javascript:;" class="btn default">取消 </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
@endsection
@section("pluginjs")
    <script src="{{asset('resources/assets/global/plugins/jstree/dist/jstree.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/jquery-repeater/jquery.repeater.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js')}}" type="text/javascript"></script>
@endsection
@section("js")
    <script>
        var token = "{{csrf_token()}}";
        function save_pri() {
            var data = $("form").serialize();
            $.ajax({
                "type": "put",
                "url": "{{url('admin/privilege')}}" + "/" + $("input[name=pri_id]")[0].value,
                "dataType": "json",
                'data': $("form").serialize(),
                success: function(data) {
                    if(data.code == 1) {
                        sweetAlert("恭喜您", "保存成功", "success");
                        UITree.refresh();
                    } else {
                        sweetAlert("很遗憾", data.result, "error");
                        UITree.refresh();
                    }
                }
            })
        }
    </script>
    <script src="{{asset('resources/assets/pages/scripts/ui-tree.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/pages/scripts/form-repeater.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/pages/scripts/components-date-time-pickers.min.js')}}" type="text/javascript"></script>
@endsection