@extends('admin.layouts.admin')
@section('plugincss')
    <link href="{{asset('resources/assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{url('admin/index')}}">首页</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{url('admin/doctor')}}">医生管理</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>医生列表</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> 医生管理
            <small>医生列表</small>
        </h1>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> 医生列表</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="{{url('admin/doctor/create')}}" id="sample_editable" class="btn sbold green"> 添加
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="btn-group pull-right">
                                        <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">工具
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                            <tr>
                                <th> 编号 </th>
                                <th> 姓名 </th>
                                <th> 昵称 </th>
                                <th> 头像 </th>
                                <th> 电话号码</th>
                                <th> 注册时间 </th>
                                <th> 邮箱 </th>
                                <th> 是否删除 </th>
                                <th> 操作 </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
@endsection
@section('pluginjs')
    <script src="{{asset('resources/assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js')}}" type="text/javascript"></script>
@endsection
@section('js')
    <script src="{{asset('resources/assets/pages/scripts/table-patient-datatables-managed.js')}}" type="text/javascript"></script>
    <script>
        var token = "{{csrf_token()}}";

        function doDelete(pat_id) {
            console.log(pat_id);
            //删除管理员
            bootbox.confirm("是否确定删除该条记录?", function (result) {
                if (result) {
                    $.post("{{url('admin/patient/')}}/" + pat_id, {
                        '_method': 'delete',
                        '_token': token
                    }, function (data) {
                        data = JSON.parse(data);
                        if (data.code === 1) {
                            location.href = location.href;
                            sweetAlert("恭喜您", "删除成功", "success");
                        } else {
                            sweetAlert("很遗憾", "本次删除失败", "error");
                        }
                    });
                }
            });
        }
    </script>
@endsection