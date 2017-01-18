<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Get Logged in User
     *
     * @return Collection
     */
    public function loggedInUser()
    {
        return Auth::user();
    }

    /**
     * [checkPermission description]
     *
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function checkPermission($permission)
    {
        if(!Gate::allows($permission))
        {
            return true;
        }
        else
        {
            return false;
        }

    }
}
