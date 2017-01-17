@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('admin.users.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('admin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('admin.users.fields.name')</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.users.fields.email')</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.users.fields.password')</th>
                            <td>---</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.users.fields.role')</th>
                            <td>{{ $user->role->title or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.users.fields.remember-token')</th>
                            <td>{{ $user->remember_token }}</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.users.fields.phone')</th>
                            <td>{{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.users.fields.dob')</th>
                            <td>{{ $user->dob }}</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.users.fields.photo')</th>
                            <td>@if($user->photo)<a href="{{ asset('uploads/' . $user->photo) }}" target="_blank"><img src="{{ asset('uploads/thumb/' . $user->photo) }}"/></a>@endif</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('users.index') }}" class="btn btn-default">@lang('admin.back_to_list')</a>
        </div>
    </div>
@stop