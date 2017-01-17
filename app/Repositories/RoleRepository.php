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
     * @param User $model
     */
    public function __construct(Role $model)
    {
        $this->model = $model;
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
