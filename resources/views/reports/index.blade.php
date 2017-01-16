@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.reports.title')</h3>
    @can('report_create')
    <p>
        <a href="{{ route('reports.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($reports) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                    <tr>
                        @can('report_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.reports.fields.user')</th>
                        <th>@lang('quickadmin.reports.fields.name')</th>
                        <th>@lang('quickadmin.reports.fields.date')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($reports) > 0)
                        @foreach ($reports as $report)
                            <tr data-entry-id="{{ $report->id }}">
                                @can('report_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $report->user->name or '' }}</td>
                                <td>{{ $report->name }}</td>
                                <td>{{ $report->date }}</td>
                                <td>
                                    @can('report_view')
                                    <a href="{{ route('reports.show',[$report->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('report_edit')
                                    <a href="{{ route('reports.edit',[$report->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('report_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['reports.destroy', $report->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">@lang('quickadmin.no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        @can('report_delete')
            window.route_mass_crud_entries_destroy = '{{ route('reports.mass_destroy') }}';
        @endcan
    </script>
@endsection