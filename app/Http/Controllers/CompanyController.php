<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function ajaxCompany()
    {
        $q = request('q');
        $data = Company::whereRaw($q ? '(nit like "%'.$q.'%" or activity like "%'.$q.'%" or representative like "%'.$q.'%" or razon like "%'.$q.'%" )' : 1)
        ->where('deleted_at', null)->get();

        return response()->json($data);
    }
}
