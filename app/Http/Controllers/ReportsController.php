<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Gate;
use App\Repositories\ReportRepository;
use App\Http\Requests\EmailReportRequest;
use App\Http\Requests\StoreReportsRequest;
use App\Http\Requests\UpdateReportsRequest;

class ReportsController extends Controller
{
    /**
     * Construct
     *
     * @param ReportRepository  $report
     * @param UserRepository    $user
     */
    public function __construct(ReportRepository $report, UserRepository $user)
    {
        $this->report   = $report;
        $this->user     = $user;
    }

    /**
     * Display a listing of Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('report_access'))
        {
            return abort(401);
        }

        $reports = $this->getReports($request);

        return view('reports.index', compact('reports'));
    }

    /**
     * Get Reports
     *
     * @return Report collection
     */
    public function getReports($request)
    {
        if($this->loggedInUser()->role->id == 1)
        {
            $reports = $this->report->getAll();
        }
        else
        {
            $reports = $this->report->forUser($request->user());
        }

        return $reports;
    }

    /**
     * Show the form for creating new Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('report_create'))
        {
            return abort(401);
        }

        $relations = $this->__getUSerRelation();

        return view('reports.create', $relations);
    }

    /**
     * Store a newly created Report in storage.
     *
     * @param  \App\Http\Requests\StoreReportsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportsRequest $request)
    {
        if(!Gate::allows('report_create'))
        {
            return abort(401);
        }

        try
        {
            $report = $this->report->create($request);

            if($report)
            {
                session()->flash('success', trans('admin.reports.created'));
            }
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('reports.index');
    }


    /**
     * Show the form for editing Report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Gate::allows('report_edit'))
        {
            return abort(401);
        }

        $relations  = $this->__getUSerRelation();
        $report     = $this->report->findOrThrowException($id);

        return view('reports.edit', compact('report') + $relations);
    }

    /**
     * Update Report in storage.
     *
     * @param  \App\Http\Requests\UpdateReportsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportsRequest $request, $id)
    {
        if(!Gate::allows('report_edit'))
        {
            return abort(401);
        }

        try
        {
            $report = $this->report->update($request, $id);

            if($report)
            {
                session()->flash('success', trans('admin.reports.updated'));
            }
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('reports.index');
    }


    /**
     * Display Report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Gate::allows('report_view'))
        {
            return abort(401);
        }

        $relations  = $this->__getUSerRelation();
        $report     = $this->report->findOrThrowException($id);

        return view('reports.show', compact('report') + $relations);
    }


    /**
     * Remove Report from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('report_delete'))
        {
            return abort(401);
        }

        try
        {
             if($this->report->destroy($id))
             {
                 session()->flash('success', trans('admin.reports.deleted'));
             }
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('reports.index');
    }

    /**
     * Delete all selected Report at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if(!Gate::allows('report_delete'))
        {
            return abort(401);
        }

        try
        {
             $this->report->destroyAll($request);
             session()->flash('success', trans('admin.reports.deleted'));
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function download($id = null)
    {
        if (!Gate::allows('report_access'))
        {
            return abort(401);
        }

        try
        {
            $relations  = $this->__getUSerRelation();
            $report     = $this->report->findOrThrowException($id);

            $pdf = \PDF::loadView('reports.pdf', compact('report') + $relations);

            session()->flash('success', trans('admin.reports.downloaded'));

            return $pdf->download('report.pdf');
        }
        catch (\Exception $e)
        {
            session()->flash('error', $e->getMessage());
            return redirect()->route('reports.show', $id);
        }
    }

    /**
     * @param EmailReportRequest $request
     * @param $id
     * @return mixed
     */
    public function send(EmailReportRequest $request, $id)
    {
        if(!Gate::allows('report_access'))
        {
            return abort(401);
        }

        try
        {
            $to = $request->get('email');
            $text = $request->get('message');

            $relations  = $this->__getUSerRelation();
            $report     = $this->report->findOrThrowException($id);

            $pdf = \PDF::loadView('reports.pdf', compact('report') + $relations);


            Mail::send('emails.report', ['text' => $text], function($message) use($pdf,$to, $request )
            {
                $message->from('info@abcpathology.com', $request->user()->name);

                $message->to($to)->subject('Pathology Test Report');

                $message->attachData($pdf->output(), "report.pdf");
            });

            session()->flash('success', trans('admin.reports.emailed'));

        } catch (\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('reports.show', $id);
    }

    /**
     * Get Users
     *
     * @return Array
     */
    protected function __getUserRelation()
    {
        return $relations = [
            'users' => $this->user->getSelectedUsers(),
        ];
    }


}
