@extends('admin.layouts.admin')
@section('plugincss')
    <link href="{{asset('resources/assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-editable/inputs-ext/address/address.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!-- BEGIN CONTENT BODY -->
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
                    <a href="javascript:;">角色管理</a>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <div>
                <h1 class="page-title" style="display: inline-block;"> 角色管理</h1>
                <a href="{{url('admin/role/create')}}"><button type="button" class="btn btn-info btn-primary" style="float:right; margin: 20px 0;"><i class="fa fa-plus"></i> 添加角色</button></a>
        </div>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">按钮组</span>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="sample">
                            <thead>
                            <tr>
                                <th class="dt-center">ID</th>
                                <th class="dt-center">名称</th>
                                <th class="dt-center">描述</th>
                                <th class="dt-center">创建时间</th>
                                <th class="dt-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $v)
                                    <tr>
                                        <td class="dt-center">{{$v['role_id']}}</td>
                                        <td class="dt-center">{{$v['role_name']}}</td>
                                        <td class="dt-center">{{$v['role_desc']}}</td>
                                        <td class="dt-center">{{$v['role_addtime']}}</td>
                                        <td class="dt-center">
                                            <a href="{{url('admin/role')}}/{{$v['role_id']}}/edit"><i title="修改" class="fa fa-edit"></i></a>&nbsp;
                                            <a href="javascript:;" id="delete_confirm" onclick="doDelete({{$v['role_id']}})"><i title="删除" class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
@endsection
@section('pluginjs')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{asset('resources/assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>

    <script src="{{asset('resources/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-typeahead/bootstrap3-typeahead.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('js')
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script type="text/javascript">
        //        定义token
        var token = "{{csrf_token()}}";

        function doDelete(role_id) {
            //删除管理员
            bootbox.confirm("是否确定删除该条记录?", function (result) {
                if (result) {
                    $.post("{{url('admin/role/')}}/" + role_id, {
                        '_method': 'delete',
                        '_token': token
                    }, function (data) {
                        var data = JSON.parse(data);
                        if (data.code == 1) {
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
    <script src="{{asset('resources/assets/pages/scripts/table-datatables-buttons.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/jquery.form.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endsection