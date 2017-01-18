<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@lang('admin.site-title')</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <style>
        body {
            margin-top: 25px;
        }

        .fa-btn {
            margin-right: 6px;
        }

        .table-text div {
            padding-top: 6px;
        }
    </style>

</head>

<body>

<div class="page-content-wrapper">
    <div class="page-content">


        <h3 class="page-title">
            ABC Pathology Lab
        </h3>

        <div class="row">
            <div class="col-md-12">
                <h3 class="page-title">@lang('admin.reports.pdf-title')</h3>

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
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


</body>
</html>
