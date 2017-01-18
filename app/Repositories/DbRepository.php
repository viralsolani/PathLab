<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;

/**
 * @package App\Repositories
 */
Abstract class DbRepository
{
    /**
     * @param  $id
     *
     * @throws GeneralException
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|static
     */
    public function findOrThrowException($id)
    {
        if (! is_null($this->model->find($id)))
        {
            return $this->model->find($id);
        }

        throw new GeneralException('That record does not exist.');
    }
	/**
     * @param  $per_page
     * @param  string      $order_by
     * @param  string      $sort
     * @return mixed
     */
    public function getPaginated($per_page, $active = '', $order_by = 'id', $sort = 'asc')
    {
    	if($active)
    	{
	        return $this->model->where('status', $active)
	            ->orderBy($order_by, $sort)
	            ->paginate($per_page);
	    }
	    else
	    {
	    	return $this->model->orderBy($order_by, $sort)
	            ->paginate($per_page);
	    }
    }

    /**
    * @param  string  $order_by
    * @param  string  $sort
    * @return mixed
    */
    public function getAll($order_by = 'id', $sort = 'asc')
    {
        return $this->model->orderBy($order_by, $sort)->get();
    }

    /**
     * Delete particualr
     * @param  $id
     * @throws GeneralException
     * @return bool
     */
    public function destroy($id)
    {
        if ($this->model->where('ID', '=', $id)->delete())
        {
            return true;
        }

        throw new GeneralException('There was a problem deleting this record. Please try again.');
    }

    /**
     * Delete all records
     *
     * @param  $id
     * @throws GeneralException
     * @return bool
     */
    public function destroyAll($request)
    {
        if($request->input('ids'))
        {
            $entries = $this->model->whereIn('id', $request->input('ids'))->get();

            foreach($entries as $entry)
            {
                $entry->delete();
            }
        }
    }

    /**
    * @param  array $columns
    * @param  string  $sort
    * @param  string  $order_by
    * @return mixed
    */
    public function selectAll($columns='*', $order_by = 'id', $sort = 'asc')
    {
        return $this->model->select($columns)->orderBy($order_by, $sort)->get();
    }



}
