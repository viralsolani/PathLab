@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('admin.reports.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('admin.view')
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

            <a href="{{ route('reports.index') }}" class="btn btn-default">@lang('admin.back_to_list')</a>
        </div>
    </div>
@stop