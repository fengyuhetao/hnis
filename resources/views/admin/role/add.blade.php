@extends('admin.layouts.admin')
@section('plugincss')
    <link href="{{asset('resources/assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
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
                    <span>管理员管理</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> 添加管理员
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
                                    <i class="fa fa-gift"></i>角色</div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"> </a>
                                    <a href="javascript:;" class="reload"> </a>
                                    <a href="javascript:;" class="remove"> </a>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="{{url('admin/role')}}" method="post" class="form-horizontal">
                                    {{csrf_field()}}
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">角色名称</label>
                                            <div class="col-md-4">
                                                <input name="role_name" type="text" class="form-control" placeholder="请输入角色名称">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">描述</label>
                                            <div class="col-md-4">
                                                <input name="role_desc" type="text" class="form-control" placeholder="请输入角色描述">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">角色</label>
                                            <div class="col-md-10">
                                                <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                <div class="portlet-body">
                                                    <div class="table-scrollable">
                                                        <table class="table table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th class="col-md-2"> 模块 </th>
                                                                <th style="text-align: center;"> 权限 </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($data as $v)
                                                            <tr>
                                                                <td style="vertical-align: middle"> <div class="icheck-inline">
                                                                        <label>
                                                                            <input type="checkbox" name="pris[]" value="{{$v['id']}}" class="icheck" data-checkbox="icheckbox_square-grey"> {{$v['text']}}  </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    @if(isset($v['children']))
                                                                        @foreach($v['children'] as $v1)
                                                                        <div class="col-md-3">
                                                                            <div class="icheck-inline">
                                                                                <label>
                                                                                    <input type="checkbox" name="pris[]" value="{{$v1['id']}}" class="icheck" data-checkbox="icheckbox_square-grey"> {{$v1['text']}}  </label>
                                                                            </div>
                                                                        </div>
                                                                            @if(isset($v1['children']))
                                                                                @foreach($v1['children'] as $v2)
                                                                                    <div class="col-md-3">
                                                                                        <div class="icheck-inline">
                                                                                            <label>
                                                                                                <input type="checkbox" name="pris[]" value="{{$v2['id']}}" class="icheck" data-checkbox="icheckbox_square-grey"> {{$v2['text']}}  </label>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- END SAMPLE TABLE PORTLET-->
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
                                            <input type="text" disabled class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">描述</label>
                                        <div class="col-md-5">
                                            <input type="text" disabled class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">创建时间</label>
                                        <div class="col-md-5">
                                            <input type="text" disabled class="form-control">
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
                                            <tbody>
                                            <tr>
                                                <td> Otto </td>
                                                <td>
                                                    <div class="col-md-4">makr124</div>
                                                    <div class="col-md-4">makr124</div>
                                                    <div class="col-md-4">makr124</div></td>
                                            </tr>
                                            <tr>
                                                <td> Jacob </td>
                                                <td> <div class="col-md-4">makr124</div>
                                                    <div class="col-md-4">makr124</div>
                                                    <div class="col-md-4">makr124</div> </td>
                                            </tr>
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
    <!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('js')
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{asset('resources/assets/pages/scripts/form-icheck.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/pages/scripts/form-samples.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/assets/pages/scripts/ui-modals.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endsection