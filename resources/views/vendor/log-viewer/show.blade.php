@extends('admin.layouts.admin')

@section('plugincss')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.15.35/css/bootstrap-datetimepicker.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700|Source+Sans+Pro:400,600' rel='stylesheet' type='text/css'>
    @include('log-viewer::_template.style')
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
                    <a href="{{url('admin/log')}}">日志管理</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>日志详情页</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <div>
            <h1 class="page-title" style="display: inline-block;"> Log [{{ $log->date }}]</h1>
            <a href="{{url('admin/log/list')}}"><button type="button" class="btn btn-info btn-primary" style="float:right; margin: 20px 0;">日志列表</button></a>
        </div>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->

        <div class="row">
            <div class="col-md-2">
                @include('log-viewer::_partials.menu')
            </div>
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Log info :

                        <div class="group-btns pull-right">
                            <a href="{{ route('log-viewer::logs.download', [$log->date]) }}" class="btn btn-xs btn-success">
                                <i class="fa fa-download"></i> DOWNLOAD
                            </a>
                            <a href="#delete-log-modal" class="btn btn-xs btn-danger" data-toggle="modal">
                                <i class="fa fa-trash-o"></i> DELETE
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <td>File path :</td>
                                <td colspan="5">{{ $log->getPath() }}</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Log entries : </td>
                                <td>
                                    <span class="label label-primary">{{ $entries->total() }}</span>
                                </td>
                                <td>Size :</td>
                                <td>
                                    <span class="label label-primary">{{ $log->size() }}</span>
                                </td>
                                <td>Created at :</td>
                                <td>
                                    <span class="label label-primary">{{ $log->createdAt() }}</span>
                                </td>
                                <td>Updated at :</td>
                                <td>
                                    <span class="label label-primary">{{ $log->updatedAt() }}</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel panel-default">
                    @if ($entries->hasPages())
                        <div class="panel-heading">
                            {!! $entries->render() !!}

                            <span class="label label-info pull-right">
                            Page {!! $entries->currentPage() !!} of {!! $entries->lastPage() !!}
                        </span>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="entries" class="table table-condensed">
                            <thead>
                            <tr>
                                <th>ENV</th>
                                <th style="width: 120px;">Level</th>
                                <th style="width: 65px;">Time</th>
                                <th>Header</th>
                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($entries as $key => $entry)
                                <tr>
                                    <td>
                                        <span class="label label-env">{{ $entry->env }}</span>
                                    </td>
                                    <td>
                                        <span class="level level-{{ $entry->level }}">
                                            {!! $entry->level() !!}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="label label-default">
                                            {{ $entry->datetime->format('H:i:s') }}
                                        </span>
                                    </td>
                                    <td>
                                        <p>{{ $entry->header }}</p>
                                    </td>
                                    <td class="text-right">
                                        @if ($entry->hasStack())
                                            <a class="btn btn-xs btn-default" role="button" data-toggle="collapse" href="#log-stack-{{ $key }}" aria-expanded="false" aria-controls="log-stack-{{ $key }}">
                                                <i class="fa fa-toggle-on"></i> Stack
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @if ($entry->hasStack())
                                    <tr>
                                        <td colspan="5" class="stack">
                                            <div class="stack-content collapse" id="log-stack-{{ $key }}">
                                                {!! $entry->stack() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($entries->hasPages())
                        <div class="panel-footer">
                            {!! $entries->render() !!}

                            <span class="label label-info pull-right">
                            Page {!! $entries->currentPage() !!} of {!! $entries->lastPage() !!}
                        </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- DELETE MODAL --}}
        <div id="delete-log-modal" class="modal fade">
            <div class="modal-dialog">
                <form id="delete-log-form" action="{{ route('log-viewer::logs.delete') }}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="date" value="{{ $log->date }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">DELETE LOG FILE</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to <span class="label label-danger">DELETE</span> this log file <span class="label label-primary">{{ $log->date }}</span> ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">DELETE FILE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            var deleteLogModal = $('div#delete-log-modal'),
                deleteLogForm  = $('form#delete-log-form'),
                submitBtn      = deleteLogForm.find('button[type=submit]');

            deleteLogForm.on('submit', function(event) {
                event.preventDefault();
                submitBtn.button('loading');

                $.ajax({
                    url:      $(this).attr('action'),
                    type:     $(this).attr('method'),
                    dataType: 'json',
                    data:     $(this).serialize(),
                    success: function(data) {
                        submitBtn.button('reset');
                        if (data.result === 'success') {
                            deleteLogModal.modal('hide');
                            location.replace("{{ route('log-viewer::logs.list') }}");
                        }
                        else {
                            alert('OOPS ! This is a lack of coffee exception !')
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(errorThrown);
                        submitBtn.button('reset');
                    }
                });

                return false;
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.15.35/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        Chart.defaults.global.responsive      = true;
        Chart.defaults.global.scaleFontFamily = "'Source Sans Pro'";
        Chart.defaults.global.animationEasing = "easeOutQuart";
    </script>
@endsection
