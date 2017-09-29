<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Clinic;
use Session;
use Auth;
use App\User;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        //
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        ;
         $clinic = Clinic::find($request)->first();
         Session::put('cliniccode',$clinic->cliniccode);
         Session::put('clinicname',$clinic->name);
         return redirect()->route('patients.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
