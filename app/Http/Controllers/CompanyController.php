<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function ajaxCompany()
    {
        $q = request('q');
        $data = Certificate::with(['company'])
            ->where(function($query) use ($q){
                if($q){
                    $query->OrwhereHas('company', function($query) use($q){
                        $query->whereRaw("(razon like '%$q%' or representative like '%$q%' or nit like '%$q%' or activity like '%$q%')");
                    })
                    ->OrWhereRaw($q ? "code like '%$q%'" : 1);
                }
            })
            ->where('deleted_at', NULL)->get();



        // $data = Company::whereRaw($q ? '(nit like "%'.$q.'%" or activity like "%'.$q.'%" or representative like "%'.$q.'%" or razon like "%'.$q.'%" )' : 1)
        // ->where('deleted_at', null)->get();

        return response()->json($data);
    }
}
