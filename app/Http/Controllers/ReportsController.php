<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\ReportRepository;
use Illuminate\Support\Facades\Gate;
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
    public function index()
    {
        if (!Gate::allows('report_access'))
        {
            return abort(401);
        }

        $reports = $this->report->getAll();

        return view('reports.index', compact('reports'));
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
