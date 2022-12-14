<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Models\Signature;
use App\Models\Company;
use App\Models\Code;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $certificate = Certificate::with(['company', 'signature', 'code'])
            ->where('deleted_at', null)->get();
        return view('certificates.browse', compact('certificate'));
    }

    public function create()
    {
        $signature = Signature::where('deleted_at', null)->where('status',1)->get();
        $company = Company::where('deleted_at', null)->where('status',1)->get();
        return view('certificates.add', compact('signature', 'company'));
    }

    public function store(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $ok = Code::where('deleted_at', null)->where('code', $request->code)->first();
            if($ok)
            {
                return redirect()->route('certificates.create')->with(['message' => 'El Codigo debe ser diferente', 'alert-type' => 'error']);
            }
            $code = Code::create(['code'=>$request->code, 'initials' => 'EMCC', 'registerUser_id'=>Auth::user()->id]);
            // return 1;
            Certificate::create([
                'company_id'=>$request->company_id,
                'signature_id'=>$request->signature_id,
                'code_id'=>$code->id,
                'dateStart'=>$request->dateStart,
                'dateFinish'=>$request->dateFinish,
                'registerUser_id'=>Auth::user()->id
            ]);
            // return $code;
            DB::commit();
            return redirect()->route('certificates.index')->with(['message' => 'Registrado exitosamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('certificates.create')->with(['message' => 'Ocurri?? un error.', 'alert-type' => 'error']);
        }
    }

    public function print($id)
    {
        $certificate = Certificate::with(['company', 'signature', 'code'])
            ->where('deleted_at', null)->where('id', $id)->first();
            // return $certificate;
        return view('certificates.print',compact('certificate'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $ok = Certificate::where('id', $id)->first();
            $ok->update(['deleted_at'=>Carbon::now()]);
            Code::where('id', $ok->code_id)->update(['deleted_at'=>Carbon::now()]);
            DB::commit();
            return redirect()->route('certificates.index')->with(['message' => 'Eliminado exitosamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            return 0;
            return redirect()->route('certificates.create')->with(['message' => 'Ocurri?? un error.', 'alert-type' => 'error']);
        }
    }
}
