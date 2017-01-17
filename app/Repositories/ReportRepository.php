<?php

namespace App\Repositories;

use App\Models\Test;
use App\Models\Report;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;

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

    /**
     * Add test to Report
     *
     * @param $test_data
     * @param Report $report
     * @return mixed
     */
    public function addTest($test_data, Report $report)
    {
        return $report->tests()->sync([
                        $test_data['id'] => [
                            'result'    => $test_data['result'],
                            'test_name' => Test::findOrFail($test_data['id'])->name
                        ]
                ], false);
    }

    /**
     * Remove test from report
     *
     * @param Test $test
     * @param Report $report
     * @return mixed
     */
    public function removeTest(Test $test, Report $report)
    {
        return $report->tests()->detach($test->id);
    }

}
