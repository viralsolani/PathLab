<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Report;
use App\Repositories\DbRepository;

/**
 * Class ReportRepository
 *
 */
class ReportRepository extends DbRepository
{

    /**
     *
     * @param Report $model
     */
    public function __construct(Report $model)
    {
        $this->model = $model;
    }

    /**
     * Create Report
     *
     * @param $request
     * @return mixed
     */
    public function create($request)
    {
        $report =  $this->model->create($request->all());

        return $report;
    }

    /**
     * Update Report
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    public function update($request, $id)
    {
        $report = $this->findOrThrowException($id);

        return $report->update($request->all());
    }

}
