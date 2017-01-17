@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('admin.tests.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('admin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('admin.tests.fields.name')</th>
                            <td>{{ $test->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.tests.fields.description')</th>
                            <td>{{ $test->description }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('tests.index') }}" class="btn btn-default">@lang('admin.back_to_list')</a>
        </div>
    </div>
@stop