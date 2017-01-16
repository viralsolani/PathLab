@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.reports.title')</h3>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.reports.fields.user')</th>
                            <td>{{ $report->user->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.reports.fields.name')</th>
                            <td>{{ $report->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.reports.fields.details')</th>
                            <td>{!! $report->details !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.reports.fields.date')</th>
                            <td>{{ $report->date }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('reports.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop