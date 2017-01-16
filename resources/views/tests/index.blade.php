@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.tests.title')</h3>
    @can('test_create')
    <p>
        <a href="{{ route('tests.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($tests) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                    <tr>
                        @can('test_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.tests.fields.name')</th>
                        <th>@lang('quickadmin.tests.fields.description')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($tests) > 0)
                        @foreach ($tests as $test)
                            <tr data-entry-id="{{ $test->id }}">
                                @can('test_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $test->name }}</td>
                                <td>{{ $test->description }}</td>
                                <td>
                                    @can('test_view')
                                    <a href="{{ route('tests.show',[$test->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('test_edit')
                                    <a href="{{ route('tests.edit',[$test->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('test_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['tests.destroy', $test->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">@lang('quickadmin.no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        @can('test_delete')
            window.route_mass_crud_entries_destroy = '{{ route('tests.mass_destroy') }}';
        @endcan
    </script>
@endsection