<?php

namespace App\Repositories;

use App\Models\Test;
use App\Models\Report;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;

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
     * Get all of the tests for a given reports.
     *
     * @param Report $report
     * @return Collection
     */
    public function forReport(Report $report)
    {
        return $report->tests;
    }

    /**
     * Get Tests
     *
     * @return mix
     */
    public function getTestLists()
    {
        return $this->model->get()->pluck('name', 'id');
    }
}
