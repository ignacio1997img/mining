<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Form101;
use App\Models\TypeMineral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use App\Http\Controllers\HTML2PDF;

class Form101Controller extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    public function index()
    {

        return view('form101.browse');
    }

    public function list($search = null){
        $user = Auth::user();
        
        $paginate = request('paginate') ?? 10;

     
        $data = Form101::with(['certificate.company', 'typeMineral'])
                    ->where(function($query) use ($search){
                        if($search){
                            $query->OrwhereHas('certificate.company', function($query) use($search){
                                $query->whereRaw("(razon like '%$search%' or representative like '%$search%' or nit like '%$search%')");
                            })
                            ->OrwhereHas('certificate', function($query) use($search){
                                $query->whereRaw("(code like '%$search%')");
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
            $form->update(['code'=>'SDMEH-'.str_pad($form->id, 6, "0", STR_PAD_LEFT), 'register_id'=>Auth::user()->id]);

        


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

        $forms = Form101::with(['certificate.company', 'typeMineral'])
                    ->where('id', $form)->where('deleted_at', NULL)->orderBy('id', 'DESC')->first();



                    // $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', 3);
                    // $html2pdf->pdf->SetDisplayMode('fullpage');
                    // $html2pdf->writeHTML($form, isset($_GET['vuehtml']));
                    // $html2pdf->Output('PDF-CF.pdf');










 

        return view('form101.prinf', compact('forms'));

        // view()->share('forms', $forms);
        // $pdf = PDF::loadView('form101.prinf',compact('forms'));

        // return $pdf->download('Formulario 101.pdf');





        return PDF::loadView('form101.prinf',compact('forms') )
        // ->setPaper('A4', 'landscape')
        ->setPaper('A4', 'portrait')
        ->stream('Formulario 101.pdf');

    }

    public function destroy($id)
    {
        // return $id;
        DB::beginTransaction();
        try {
            Form101::where('id', $id)->update(['deleted_at'=>Carbon::now(), 'deleted_id'=>Auth::user()->id]);
            DB::commit();
            return redirect()->route('form101s.index')->with(['message' => 'Eliminado exitosamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            return 0;
            return redirect()->route('form101s.create')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }
}
