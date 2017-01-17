<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use App\Http\Requests\StoreUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    /**
     * Construct
     *
     * @param UserRepository $user
     * @param RoleRepository $role
     */
    public function __construct(UserRepository $user, RoleRepository $role)
    {
        $this->user = $user;
        $this->role = $role;
    }
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('user_access'))
        {
            return abort(401);
        }

        $users = $this->user->getAll();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('user_create'))
        {
            return abort(401);
        }

        $relations = $this->__getRoleRelation();

        return view('users.create', $relations);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        if(!Gate::allows('user_create'))
        {
            return abort(401);
        }

        try
        {
             $user = $this->user->create($request);

             if($user)
             {
                 session()->flash('success', trans('admin.users.created'));
             }
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Gate::allows('user_edit'))
        {
            return abort(401);
        }

        $relations = $this->__getRoleRelation();

        $user = $this->user->findOrThrowException($id);

        return view('users.edit', compact('user') + $relations);
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        if(!Gate::allows('user_edit'))
        {
            return abort(401);
        }

        try
        {
            $user = $this->user->update($request, $id);

            if($user)
            {
                session()->flash('success', trans('admin.users.updated'));
            }

        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('users.index');
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Gate::allows('user_view'))
        {
            return abort(401);
        }

        $relations = $this->__getRoleRelation();

        $user = $this->user->findOrThrowException($id);

        return view('users.show', compact('user') + $relations);
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Gate::allows('user_delete'))
        {
            return abort(401);
        }

        try
        {
             if($this->user->destroy($id))
             {
                 session()->flash('success', trans('admin.users.deleted'));
             }
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if(!Gate::allows('user_delete'))
        {
            return abort(401);
        }

        try
        {
             $this->user->destroyAll($request);
             session()->flash('success', trans('admin.tests.deleted'));
        }
        catch(\Exception $e)
        {
            session()->flash('error', $e->getMessage());
        }

    }

    /**
     * Get Roles
     *
     * @return Array
     */
    protected function __getRoleRelation()
    {
        return $relations = [
            'roles' => $this->role->getSelectedRoles(),
        ];
    }
}
