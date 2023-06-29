<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Form101;
use App\Models\TypeMineral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Form101Controller extends Controller
{
    public function index()
    {

        return view('form101.browse');
    }

    public function list($search = null){
        $user = Auth::user();
        
        $paginate = request('paginate') ?? 10;

     
        $data = Form101::with(['company', 'typeMineral'])
                    ->where(function($query) use ($search){
                        if($search){
                            $query->OrwhereHas('company', function($query) use($search){
                                $query->whereRaw("(razon like '%$search%' or representative like '%$search%' or nit like '%$search%')");
                            })
                            ->OrwhereHas('typeMineral', function($query) use($search){
                                $query->whereRaw("(name like '%$search%')");
                            })
                            // ->OrWhereRaw($search ? "typeLoan like '%$search%'" : 1)
                            ->OrWhereRaw($search ? "code like '%$search%'" : 1);
                        }
                    })
                    ->where('deleted_at', NULL)->orderBy('id', 'DESC')->paginate($paginate);
                   
                return view('form101.list', compact('data'));

    }

    public function create()
    {
        // return 1;
        $company = Company::where('deleted_at', null)->get();
        $type = TypeMineral::where('deleted_at', null)->get();

        return view('form101.add', compact('company', 'type'));

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // return $request;

            $form = Form101::create($request->all());
            $form->update(['code'=>str_pad($form->id, 6, "0", STR_PAD_LEFT), 'register_id'=>Auth::user()->id]);

        


            // return 1;
            DB::commit();
            return redirect()->route('form101s.index')->with(['message' => 'Registrado exitosamente exitosamente.', 'alert-type' => 'success']);            
        } catch (\Throwable $th) {
            DB::rollBack();
          
            return redirect()->route('form101s.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function prinf($form)
    {

        $forms = Form101::with(['company', 'typeMineral'])
                    ->where('id', $form)->where('deleted_at', NULL)->orderBy('id', 'DESC')->first();
 

        return view('form101.prinf', compact('forms'));

    }
}