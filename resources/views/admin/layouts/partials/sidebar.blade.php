<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                                            <a href="javascript:;" class="btn submit">
                                                <i class="icon-magnifier"></i>
                                            </a>
                                        </span>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <li class="nav-item start">
                <a href="javascript:;" class="nav-link">
                    <i class="icon-home"></i>
                    <span class="title">首页</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item active open">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">系统管理</span>
                    <span class="arrow open"></span>
                </a>
                <ul class="sub-menu"  style="display: block;">
                    <li class="nav-item  ">
                        <a href="{{url('admin/admin')}}" class="nav-link ">
                            <span class="title">管理员管理</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url('admin/role')}}" class="nav-link ">
                            <span class="title">角色管理</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url('admin/privilege')}}" class="nav-link ">
                            <span class="title">权限管理</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url('admin/log')}}" class="nav-link ">
                            <span class="title">日志管理</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  active open">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-puzzle"></i>
                    <span class="title">用户管理</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url('admin/doctor')}}" class="nav-link ">
                            <span class="title">医生管理</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url('admin/patient')}}" class="nav-link ">
                            <span class="title">患者管理</span>
                            {{--<span class="badge badge-danger">2</span>--}}
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url('admin/type')}}" class="nav-link ">
                            <span class="title">分类管理</span>
                            {{--<span class="badge badge-danger">2</span>--}}
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url('admin/category')}}" class="nav-link ">
                            <span class="title">类型管理</span>
                            {{--<span class="badge badge-danger">2</span>--}}
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->