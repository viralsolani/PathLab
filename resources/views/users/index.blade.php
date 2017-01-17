@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('admin.users.title')</h3>
    @can('user_create')
    <p>
        <a href="{{ route('users.create') }}" class="btn btn-success">@lang('admin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('admin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($users) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                    <tr>
                        @can('user_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('admin.users.fields.name')</th>
                        <th>@lang('admin.users.fields.email')</th>
                        <th>@lang('admin.users.fields.role')</th>
                        <th>@lang('admin.users.fields.phone')</th>
                        <th>@lang('admin.users.fields.dob')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($users) > 0)
                        @foreach ($users as $user)
                            <tr data-entry-id="{{ $user->id }}">
                                @can('user_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->title or '' }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->dob }}</td>
                                <td>
                                    @can('user_view')
                                    <a href="{{ route('users.show',[$user->id]) }}" class="btn btn-xs btn-primary">@lang('admin.view')</a>
                                    @endcan
                                    @can('user_edit')
                                    <a href="{{ route('users.edit',[$user->id]) }}" class="btn btn-xs btn-info">@lang('admin.edit')</a>
                                    @endcan
                                    @can('user_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("admin.are_you_sure")."');",
                                        'route' => ['users.destroy', $user->id])) !!}
                                    {!! Form::submit(trans('admin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10">@lang('admin.no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        @can('user_delete')
            window.route_mass_crud_entries_destroy = '{{ route('users.mass_destroy') }}';
        @endcan
    </script>
@endsection