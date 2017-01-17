<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Repositories\TestRepository;
use Illuminate\Support\Facades\Gate;
use App\Repositories\ReportRepository;
use App\Http\Requests\ReportTestRequest;

class ReportTestController extends Controller
{

    /**
     * The test repository instance.
     *
     * @var TestRepository
     */
    protected $tests;
    /**
     * The test repository instance.
     *
     * @var TestRepository
     */
    protected $reports;

     /**
     * Create a new controller instance.
     *
     * @param TestRepository $tests
     * @param ReportRepository $reports
     */
    public function __construct(TestRepository $tests, ReportRepository $reports)
    {
        $this->tests    = $tests;
        $this->reports  = $reports;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Report $report
     * @return \Illuminate\Http\Response
     */
    public function index(Report $report)
    {
        if(!Gate::allows('report_test_access'))
        {
            return abort(401);
        }

        try
        {
            $tests      = $this->tests->forReport($report);
            $tests_list = $this->tests->getTestLists();

            return view('reports.tests.index', compact('report', 'tests', 'tests_list'));
        }
        catch (\Exception $e)
        {
            return redirect()->route('reports.index');
        }
    }

    public function store(ReportTestRequest $request, Report $report)
    {
        try
        {
            $test_data = [
                'id'        => $request->get('test'),
                'result'    => $request->get('result'),
            ];

            $this->reports->addTest($test_data, $report);

            session()->flash('success', trans('admin.report-tests.added'));

            return redirect()->route('reports.tests.index', $report->id);
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
            return redirect()->route('reports.index');
        }
    }

    /**
     * Remove the specified test from report.
     *
     * @param Report $report
     * @param Test $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report, Test $test)
    {
        try
        {
            $this->reports->removeTest($test, $report);
            session()->flash('success', trans('admin.report-tests.removed'));
            return redirect()->route('reports.tests.index', $report->id);
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
            return redirect()->route('reports.index');
        }
    }

}
