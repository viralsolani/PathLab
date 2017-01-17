<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreRolesRequest;
use App\Http\Requests\UpdateRolesRequest;

class RolesController extends Controller
{
    /**
     * Construct
     *
     * @param User $model
     */
    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }

    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Gate::allows('role_access'))
        {
            return abort(401);
        }

        $roles = $this->role->getAll();

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('role_create'))
        {
            return abort(401);
        }

        return view('roles.create');
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolesRequest $request)
    {
        if(!Gate::allows('role_create'))
        {
            return abort(401);
        }

        try
        {
            $role = $this->role->create($request);

            if($role)
            {
                session()->flash('success', trans('admin.roles.created'));
            }
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('roles.index');
    }


    /**
     * Show the form for editing Role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Gate::allows('role_edit'))
        {
            return abort(401);
        }

        $role = $this->role->findOrThrowException($id);

        return view('roles.edit', compact('role'));
    }

    /**
     * Update Role in storage.
     *
     * @param  \App\Http\Requests\UpdateRolesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolesRequest $request, $id)
    {
        if(!Gate::allows('role_edit'))
        {
            return abort(401);
        }

        try
        {
            $role = $this->role->update($request, $id);

            if($role)
            {
                session()->flash('success', trans('admin.roles.updated'));
            }
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('roles.index');
    }


    /**
     * Display Role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Gate::allows('role_view'))
        {
            return abort(401);
        }

        $role = $this->role->findOrThrowException($id);

        return view('roles.show', compact('role'));
    }


    /**
     * Remove Role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Gate::allows('role_delete'))
        {
            return abort(401);
        }

        if($this->role->destroy($id))
        {
            session()->flash('success', trans('admin.roles.deleted'));
            return redirect()->route('roles.index');
        }
    }

    /**
     * Delete all selected Role at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('role_delete'))
        {
            return abort(401);
        }

        $this->role->destroyAll($request);
    }

}
