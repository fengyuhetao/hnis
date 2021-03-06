@extends('admin.layouts.admin')
@section('plugincss')
    <link href="{{asset('resources/assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
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
                    <span>患者管理</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> 添加患者
        </h1>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_0">
                        <div class="portlet box blue-hoki">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i>患者管理</div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"> </a>
                                    <a href="javascript:;" class="reload"> </a>
                                    <a href="javascript:;" class="remove"> </a>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                @if(count($errors)>0)
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button>
                                        <span>请检查表单后重新提交</span>
                                    </div>
                            @endif
                            <!-- BEGIN FORM-->
                                <form action="{{url('admin/patient')}}/{{$patient->pat_id}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">姓名</label>
                                            <div class="col-md-4">
                                                <input type="text" name="pat_name" value="{{$patient->pat_name}}" class="form-control" placeholder="请输入姓名">
                                                {{--<span class="help-block"> A block of help text. </span>--}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">昵称</label>
                                            <div class="col-md-4">
                                                <input type="text" name="pat_nickname" value="{{$patient->pat_nickname}}"  class="form-control" placeholder="请输入昵称">
                                                {{--<span class="help-block"> A block of help text. </span>--}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">邮箱</label>
                                            <div class="col-md-4">
                                                <input type="email" name="pat_email" class="form-control" value="{{$patient->pat_email}}"  placeholder="请输入邮箱">
                                                {{--<span class="help-block"> A block of help text. </span>--}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">电话号码</label>
                                            <div class="col-md-4">
                                                <input type="text" name="doc_tel" class="form-control" value="{{$patient->pat_tel}}"  placeholder="请输入电话号码">
                                                {{--<span class="help-block"> A block of help text. </span>--}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">头像</label>
                                            <div class="col-md-9">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 120px; height: 90px;">
                                                        <img src="{{$patient->pat_face}}" alt="" /> </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                    <div>
                                                                <span class="btn default btn-file">
                                                                    <span class="fileinput-new"> 选择图片 </span>
                                                                    <span class="fileinput-exists"> 更换 </span>
                                                                    <input type="file" name="pat_face"/> </span>
                                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> 移除 </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions fluid">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn green">提交</button>
                                                <button type="button" class="btn default">重置</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- END FORM-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
    {{--BEGIN MODAL BODY--}}
    <div id="long" class="modal fade modal-scroll" tabindex="-1" data-replace="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">角色信息</h4>
                </div>
                <div class="modal-body">
                    <div class="portlet light portlet-fit bordered">
                        <div class="portlet-body form">
                            <form action="#" class="form-horizontal">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">角色名称</label>
                                        <div class="col-md-5">
                                            <input id="modal_role_name" type="text" disabled class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">描述</label>
                                        <div class="col-md-5">
                                            <input id="modal_role_desc" type="text" disabled class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">创建时间</label>
                                        <div class="col-md-5">
                                            <input id="modal_role_addtime" type="text" disabled class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-social-dribbble font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">拥有权限</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th> 模块 </th>
                                                <th style="text-align: center;"> 权限 </th>
                                            </tr>
                                            </thead>
                                            <tbody id="pris">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">关闭</button>
                </div>
            </div>
        </div>
    </div>
    {{--END MODAL BODY--}}
@endsection
@section('pluginjs')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{asset('resources/assets/global/plugins/icheck/icheck.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('js')
    <!-- BEGIN PAGE LEVEL SCRIPTS -->

    <script type="text/javascript">
        function setCurrentRole(role_id, role_name, role_desc, role_addtime) {
            $("#modal_role_name")[0].value = role_name;
            $("#modal_role_desc")[0].value = role_desc;
            $("#modal_role_addtime")[0].value = role_addtime;

//            获取该角色所有权限
            $.ajax({
                'type' : "get",
                'dataType' : "json",
                'url' : "{{url('admin/ajaxGetRolesByRoleId')}}",
                'data': {'role_id': role_id},
                success: function(data) {
                    var html = "";
                    for (var i = 0; i < data.length; i++) {
                        html += "<tr>";
                        html += "<td style=\"vertical-align: middle\">";
                        html += data[i]['pri_name'];
                        html += "</td>";
                        html += "<td>";
                        if(data[i].children != null) {
                            for(var j = 0; j < data[i].children.length; j++) {
                                html += "<div class=\"col-md-4\">";
                                html += data[i]['children'][j]['pri_name'];
                                html += "</div>";
                                if(data[i]['children'][j].children != null) {
                                    for(var k = 0; k < data[i]['children'][j].children.length; k++) {
                                        html += "<div class=\"col-md-4\">";
                                        html += data[i]['children'][j]['children'][k]['pri_name'];
                                        html += "</div>";
                                    }
                                }

                            }
                        }
                        html += "</td>";
                        html += "</tr>";
                    }
                    $("#pris")[0].innerHTML = html;
                }
            })
        }
    </script>

    <script src="{{asset('resources/assets/pages/scripts/form-icheck.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/pages/scripts/form-samples.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endsection