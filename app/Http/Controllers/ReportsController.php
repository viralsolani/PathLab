<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreReportsRequest;
use App\Http\Requests\UpdateReportsRequest;

class ReportsController extends Controller
{
    /**
     * Display a listing of Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('report_access')) {
            return abort(401);
        }
        $reports = Report::all();

        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating new Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('report_create')) {
            return abort(401);
        }

        $relations = [
            'users' => \App\Models\User::get()->where('role_id',2)->pluck('name', 'id')->prepend('Please select', ''),
        ];

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
        if (! Gate::allows('report_create')) {
            return abort(401);
        }
        $report = Report::create($request->all());

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
        if (! Gate::allows('report_edit')) {
            return abort(401);
        }
        $relations = [
            'users' => \App\Models\User::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $report = Report::findOrFail($id);

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
        if (! Gate::allows('report_edit')) {
            return abort(401);
        }
        $report = Report::findOrFail($id);
        $report->update($request->all());

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
        if (! Gate::allows('report_view')) {
            return abort(401);
        }
        $relations = [
            'users' => \App\Models\User::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $report = Report::findOrFail($id);

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
        if (! Gate::allows('report_delete')) {
            return abort(401);
        }
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('reports.index');
    }

    /**
     * Delete all selected Report at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('report_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Report::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
