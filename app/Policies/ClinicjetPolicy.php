<?php

namespace App\Policies;

use Auth;
use App\User;
use App\Role;
use Session;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClinicjetPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function nonmedical($user)
    {

        if($user->jobtype->jobtype!='Doctor' && $user->jobtype->jobtype!='JrDoctor')
        {
            return true;
        }
        else
        {
            return  false;
        }

    }
    public function superadmin($user)
    {
        
        $role =$user->roles()->wherePivot('clinic_id',Session::get('clinicid'))->first();
        if($role->role=='SuperAdmin')
        {
            return true;
        }
    }

    public function Admin($user)
    {
        $roletype = $user->roles()->first();

        if($roletype->role=='Admin')
        {
            return true;
        }
    }

}
