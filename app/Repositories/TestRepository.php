<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Test;
use App\Repositories\DbRepository;

/**
 * Class TestRepository
 *
 */
class TestRepository extends DbRepository
{
    /**
     *
     * @param Test $model
     */
    public function __construct(Test $model)
    {
        $this->model = $model;
    }

    /**
     * Create Test
     *
     * @param $request
     * @return mixed
     */
    public function create($request)
    {
        $test =  $this->model->create($request->all());

        return $test;
    }

    /**
     * Update Test
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    public function update($request, $id)
    {
        $test = $this->findOrThrowException($id);

        return $test->update($request->all());
    }

    /**
     * Get Tests
     *
     * @return mix
     */
    public function getSelectedTests()
    {
        return $this->model->get()->pluck('title', 'id')->prepend('Please select', '');
    }
}
