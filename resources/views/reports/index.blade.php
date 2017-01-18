@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('admin.reports.title')</h3>
    @can('report_create')
    <p>
        <a href="{{ route('reports.create') }}" class="btn btn-success">@lang('admin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('admin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($reports) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                    <tr>
                        @can('report_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan
                        @can('report_patient_name_access')
                            <th>@lang('admin.reports.fields.user')</th>
                        @endcan
                        <th>@lang('admin.reports.fields.name')</th>
                        <th>@lang('admin.reports.fields.date')</th>
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
                                @can('report_patient_name_access')
                                    <td>{{ $report->user->name or '' }}</td>
                                @endcan
                                <td>{{ $report->name }}</td>
                                <td>{{ $report->date }}</td>
                                <td>
                                    @can('report_create')
                                    <a href="{{route('reports.tests.index', $report->id)}}" class="btn btn-xs btn-primary">@lang('admin.add_test')</a>
                                    @endcan
                                    @can('report_view')
                                    <a href="{{ route('reports.show',[$report->id]) }}" class="btn btn-xs btn-primary">@lang('admin.view')</a>
                                    @endcan
                                    @can('report_edit')
                                    <a href="{{ route('reports.edit',[$report->id]) }}" class="btn btn-xs btn-info">@lang('admin.edit')</a>
                                    @endcan
                                    @can('report_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("admin.are_you_sure")."');",
                                        'route' => ['reports.destroy', $report->id])) !!}
                                    {!! Form::submit(trans('admin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">@lang('admin.no_entries_in_table')</td>
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