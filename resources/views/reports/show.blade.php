@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('admin.reports.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('admin.reports.sub-title')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('admin.reports.fields.user')</th>
                            <td>{{ $report->user->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.reports.fields.name')</th>
                            <td>{{ $report->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.reports.fields.details')</th>
                            <td>{!! $report->details !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.reports.fields.date')</th>
                            <td>{{ $report->date }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            @foreach($report->tests as $test)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ucfirst(strtolower($test->name))}}</h3>
                    </div>
                    <div class="panel-body">
                        {{$test->pivot->result}}
                    </div>
                </div>
            @endforeach

            <p>&nbsp;</p>

            <a href="{{ route('reports.index') }}" class="btn btn-default">@lang('admin.back_to_list')</a>

            @can('report_access')
                <a href="{{route('reports.download',$report->id)}}" class="btn btn-default">Download</a>
            @endcan

            @can('report_access')
                <a href="javascript:void(0);" class="btn btn-default" id="email-modal">E-mail</a>
            @endcan
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">
                        @lang('admin.reports.report-email')
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="{{route('reports.send',$report->id)}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">
                                @lang('admin.reports.fields.recipient')
                            </label>
                            <input type="email" name="email" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">
                               @lang('admin.reports.fields.message')
                            </label>
                            <textarea class="form-control" name="message" id="message-text"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                @lang('admin.close')
                            </button>
                            <button type="submit" class="btn btn-primary">
                                @lang('admin.save')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('javascript')
    @parent
    <script>
         $('#email-modal').click(function(){
            $('#exampleModal').modal('show');
            $('#exampleModal').css('display', 'block');
        });
    </script>
@stop