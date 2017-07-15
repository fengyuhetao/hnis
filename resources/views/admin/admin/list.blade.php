@extends('admin.layouts.admin')
@section('plugincss')
    <link href="{{asset('resources/assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/bootstrap-editable/inputs-ext/address/address.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
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
                    <a href="#">管理员管理</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>管理员列表</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <div>
            <h1 class="page-title" style="display: inline-block;"> 管理员管理</h1>
            <a href="{{url('admin/admin/create')}}"><button type="button" class="btn btn-info btn-primary" style="float:right; margin: 20px 0;"><i class="fa fa-plus"></i> 添加用户</button></a>
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
                                <th class="dt-center">头像</th>
                                <th class="dt-center">真实姓名</th>
                                <th class="dt-center">性别</th>
                                <th class="dt-center">账号</th>
                                <th class="dt-center">邮箱</th>
                                <th class="dt-center">电话号码</th>
                                <th class="dt-center">创建时间</th>
                                <th class="dt-center">最近修改时间</th>
                                <th class="dt-center">添加者</th>
                                <th class="dt-center">状态</th>
                                <th class="dt-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $v)
                                    <tr>
                                        <td class="dt-center">{{$v->admin_id}}</td>
                                        {{--展示图片--}}
                                        <td class="dt-center">{!! show_face($v->admin_pic, 30, 30) !!}</td>
                                        <td class="dt-center">{{$v->admin_name}}</td>
                                        <td class="dt-center">{{$v->admin_sex}}</td>
                                        <td class="dt-center">{{$v->admin_username}}</td>
                                        <td class="dt-center">{{$v->admin_email}}</td>
                                        <td class="dt-center">{{$v->admin_tel}}</td>
                                        <td class="dt-center">{{$v->admin_addtime}}</td>
                                        <td class="dt-center">{{$v->admin_updatetime}}</td>
                                        <td class="dt-center">{{$v->admin_adder}}</td>
                                        <td class="dt-center">{{$v->admin_is_use == 1 ? '启用' : '禁用'}}</td>
                                        <td class="dt-center">
                                            <a data-toggle="modal" onclick="editCurrentAdmin({{$v->admin_id}}, '{{$v->admin_name}}', '{{$v->admin_sex}}', '{{$v->admin_username}}', '{{$v->admin_email}}', '{{$v->admin_tel}}', '{{$v->admin_addtime}}', '{{$v->admin_updatetime}}', '{{$v->admin_adder}}', '{{$v->admin_is_use}}', '{{$v->admin_pic}}')" href="#long"><i title="查看" class="fa fa-eye"></i></a>&nbsp;
                                            <a href="{{url('admin/admin')}}/{{$v->admin_id}}/edit"><i title="修改" class="fa fa-edit"></i></a>&nbsp;
                                            <a href="javascript:;" id="delete_confirm" onclick="doDelete({{$v->admin_id}})"><i title="删除" class="fa fa-trash"></i></a>
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
    {{--BEGIN MODAL BODY--}}
    <div id="long" class="modal fade modal-scroll" tabindex="-1" data-replace="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">管理员信息</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-checkbox-inline">
                                <button id="enable" class="btn green">编辑 / 取消编辑</button>
                            </div>
                        </div>
                    </div>
                    <div class="portlet light portlet-fit bordered">
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="admin" class="table table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <td style="width:40%"> 姓名 </td>
                                            <td style="width:60%">
                                                <a href="javascript:;" id="admin_name" data-type="text" data-pk="1" data-original-title="请输入姓名">姓名</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 性别 </td>
                                            <td>
                                                <a href="javascript:;" id="admin_sex" data-type="select" data-pk="1" data-value="" data-original-title="请输入性别"> </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 账号 </td>
                                            <td>
                                                <a href="javascript:;" id="admin_username" data-type="text" data-pk="1" data-original-title="选择性别"> </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 邮箱 </td>
                                            <td>
                                                <a href="javascript:;" id="admin_email" data-pk="1" data-type="text" data-original-title="请输入邮箱"> Admin </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 电话号码 </td>
                                            <td>
                                                <a href="javascript:;" id="admin_tel" data-type="text" data-pk="1" data-original-title="请输入电话号码"> Active </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 创建时间 </td>
                                            <td>
                                                <a href="javascript:;" id="admin_addtime"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 最近修改时间 </td>
                                            <td>
                                                <a href="javascript:;" id="admin_updatetime">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 添加者 </td>
                                            <td>
                                                <a href="javascript:;" id="admin_adder">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 状态 </td>
                                            <td>
                                                <a href="javascript:;" id="admin_is_use" data-pk="1" data-type="select" data-value="" data-original-title="请选择状态"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 图片 </td>
                                            <td>
                                                <form id="pic_form" method="post" action="{{url('admin/upload')}}" enctype="multipart/form-data">
                                                    {{csrf_field()}}
                                                    <input id="hidden_id" type="hidden" name="admin_id" value=""/>
                                                <div class="col-md-9">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 100px; height: 75px;">
                                                            <img id="admin_pic" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                        <div>
                                                            <span style="display: none;" id="hidden_button" class="btn default btn-file">
                                                                    <span class="fileinput-new"> 选择图片 </span>
                                                                    <span class="fileinput-exists"> 修改 </span>
                                                                    <input type="file" name="admin_pic"/>
                                                            </span>
                                                            <button id="save_pic" class="btn red fileinput-exists">保存</button>
                                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> 取消 </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
    <script src="{{asset('resources/assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>

    <script src="{{asset('resources/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/jquery.mockjax.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-editable/inputs-ext/address/address.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/global/plugins/bootstrap-editable/inputs-ext/wysihtml5/wysihtml5.js')}}" type="text/javascript"></script>
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

        //        保存当前操作管理员的id
        var currentId = -1;

        //        保存编辑管理员，提交的地址
        var url = "{{url('admin/admin')}}";

        function editCurrentAdmin(admin_id, admin_name, admin_sex, admin_username, admin_email, admin_tel, admin_addtime, admin_updatetime, admin_adder, admin_is_use, admin_pic) {
//            保存当前要修改的admin的ID值
            currentId = admin_id;
//            设置url
            url = url + "/" + admin_id;

//            设置整个页面的值
            $("#admin_name")[0].innerText = admin_name;
            $("#admin_sex")[0].dataset['value'] = admin_sex;
            $("#admin_username")[0].innerText = admin_username;
            $("#admin_email")[0].innerText = admin_email;
            $("#admin_tel")[0].innerText = admin_tel;
            $("#admin_addtime")[0].innerText = admin_addtime;
            $("#admin_updatetime")[0].innerText = admin_updatetime;
            $("#admin_adder")[0].innerText = admin_adder;
            $("#admin_is_use")[0].dataset['value'] = admin_is_use;
            $("#admin_pic").attr({
                'src': admin_pic
            });
            $("#hidden_id")[0].value = admin_id;
//            初始化表单可编辑
            FormEditable.init();
        }

        function doDelete(admin_id) {
            //删除管理员
            bootbox.confirm("是否确定删除该条记录?", function (result) {
                if (result) {
                    $.post("{{url('admin/admin/')}}/" + admin_id, {
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

        function save_pic() {

//            https://github.com/jquery-form/form
//            异步上传图片
            var options = {
                url: '{{url("admin/upload")}}',
                type: 'post',
                dataType: 'json',
                data: $("#pic_form").serialize(),
                success: function (data) {
                    console.log(data);
                    if (data.length > 0)
                        $("#responseText").text(data);
                }
            };
            $.ajax(options);
            return false;
        }

        $('#save_pic').on('click', function() {
            $("#pic_form").ajaxSubmit({
                type: 'post', // 提交方式 get/post
                url: '{{url("admin/upload")}}', // 需要提交的 url
                data: $("#pic_form").formSerialize(),
                dataType: "json",
                success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                    // 此处可对 data 作相关处理
                    $("#admin_pic")[0].src = data.admin_pic;
                    alert('提交成功！');
                }
            });
            return false; // 阻止表单自动提交事件
        });


    </script>
    <script src="{{asset('resources/assets/pages/scripts/table-datatables-buttons.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/pages/scripts/ui-modals.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/pages/scripts/form-editable.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/jquery.form.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endsection