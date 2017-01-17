<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TestRepository;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreTestsRequest;
use App\Http\Requests\UpdateTestsRequest;

class TestsController extends Controller
{

    /**
     * Construct
     *
     * @param TestRepository $test
     */
    public function __construct(TestRepository $test)
    {
        $this->test = $test;
    }

    /**
     * Display a listing of Test.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Gate::allows('test_access'))
        {
            return abort(401);
        }

       $tests = $this->test->getAll();

       return view('tests.index', compact('tests'));
    }

    /**
     * Show the form for creating new Test.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('test_create'))
        {
            return abort(401);
        }

        return view('tests.create');
    }

    /**
     * Store a newly created Test in storage.
     *
     * @param  \App\Http\Requests\StoreTestsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTestsRequest $request)
    {
        if(!Gate::allows('test_create'))
        {
            return abort(401);
        }

        try
        {
            $test = $this->test->create($request);

            if($test)
            {
                session()->flash('success', trans('admin.tests.created'));
            }
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('tests.index');
    }


    /**
     * Show the form for editing Test.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Gate::allows('test_edit'))
        {
            return abort(401);
        }

        $test = $this->test->findOrThrowException($id);

        return view('tests.edit', compact('test'));
    }

    /**
     * Update Test in storage.
     *
     * @param  \App\Http\Requests\UpdateTestsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTestsRequest $request, $id)
    {
        if (!Gate::allows('test_edit'))
        {
            return abort(401);
        }

        try
        {
            $test = $this->test->update($request, $id);

            if($test)
            {
                session()->flash('success', trans('admin.tests.updated'));
            }
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('tests.index');
    }


    /**
     * Display Test.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('test_view'))
        {
            return abort(401);
        }

        $test = $this->test->findOrThrowException($id);

        return view('tests.show', compact('test'));
    }


    /**
     * Remove Test from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('test_delete'))
        {
            return abort(401);
        }

        try
        {
             if($this->test->destroy($id))
             {
                 session()->flash('success', trans('admin.tests.deleted'));
             }
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('tests.index');
    }

    /**
     * Delete all selected Test at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('test_delete'))
        {
            return abort(401);
        }

        try
        {
             $this->test->destroyAll($request);
             session()->flash('success', trans('admin.tests.deleted'));
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }
    }

}
