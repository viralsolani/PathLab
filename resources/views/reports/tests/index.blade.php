@extends('layouts.app')

@section('content')
    <h3 class="page-title">Report : {{ $report->name }} </h3>
    <form action="{{route('reports.tests.store',$report->id)}}" method="POST" >
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('admin.report-tests.title')
        </div>

        <div class="panel-body">

            {{ csrf_field() }}
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label for="report-test" class="control-label">Report name</label>

                    <div class="form-control">
                        <b>{{ucfirst(strtolower($report->name))}}</b>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    <label for="report-test" class="control-label">Patient</label>

                    <div class="form-control">
                        <b>{{ucfirst(strtolower($report->user->name))}}</b>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">

                    <label for="report-test" class="control-label">Test</label>

                    <select type="text" class="form-control" name="test" id="report-test" required>
                        @foreach($tests_list as $id => $test)
                            <option value="{{$id}}" @if(old('test') == $id) selected="selected" @endif>{{$test}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    <label for="task-name" class="control-label">Result</label>

                     <input type="text" name="result" id="test-result" class="form-control" value="{{ old('result') }}" required>
                </div>
            </div>

        </div>
    </div>

    <input class="btn btn-danger" type="submit" value="Save">
    <a href="{{route('reports.index')}}" class="btn btn-default">Cancel</a>
    </form>
    <hr/>

    <!-- Current Tests -->

   <div class="panel panel-default">
        <div class="panel-heading">
            @lang('admin.current_test')
        </div>

         <div class="panel-body">
            <table class="table table-striped task-table">
                <thead>
                <th>Test</th>
                <th>Result</th>
                <th>&nbsp;</th>
                </thead>
                <tbody>
                @foreach ($tests as $test)
                    <tr>
                        <td class="table-text"><div>{{ $test->name }}</div></td>
                        <td class="table-text"><div>{{ $test->pivot->result }}</div></td>

                        <!-- Task Delete Button -->
                        <td>
                            <form onsubmit="return confirm('Are you sure?');" action="{{route('reports.tests.destroy',[$report->id, $test->id] )}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" id="delete-test-{{ $test->id }}" class="btn btn-sm btn-danger">
                                    <i class="fa fa-btn fa-trash"></i>Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

 <script type="text/javascript">
        jQuery('select').select2();
</script>
@endsection

@section('javascript')

@endsection