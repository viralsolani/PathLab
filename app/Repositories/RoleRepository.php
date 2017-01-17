<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Role;
use App\Repositories\DbRepository;

/**
 * Class RoleRepository
 *
 */
class RoleRepository extends DbRepository
{

    /**
     *
     * @param Role $model
     */
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    /**
     * Create Role
     *
     * @param $request
     * @return mixed
     */
    public function create($request)
    {
        $role =  $this->model->create($request->all());

        return $role;
    }

    /**
     * Update Role
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    public function update($request, $id)
    {
        $role = $this->findOrThrowException($id);

        return $role->update($request->all());
    }

    /**
     * Get Roles
     *
     * @return mix
     */
    public function getSelectedRoles()
    {
        return $this->model->get()->pluck('title', 'id')->prepend('Please select', '');
    }
}
