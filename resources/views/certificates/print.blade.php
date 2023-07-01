@extends('layouts.template-print-alt')

@section('page_title', 'Certificado')

@section('content')
<div id="borde">
    <table width="100%">
        <tr>            
            {{-- <td style="text-align: center;  width:5%">
                {!! QrCode::size(80)->generate('CODIGO: '.str_pad($certificate->code->code, 7, "0", STR_PAD_LEFT).'-'.$certificate->code->initials.', OPERADOR MINERO: '.$certificate->company->miningOperator.', NIT: '.$certificate->company->nit.', NIM: '.$certificate->company->nim.', ACTIVIDAD: '.$certificate->company->activity.', REPRESENTANTE LEGAL: '.$certificate->company->representative.
            ', CEDULA DE IDENTIDAD: '.$certificate->company->ci.', MUNICIPIO: '.$certificate->company->municipe.', VALIDO HASTA: '.date("d-m-Y", strtotime($certificate->dateFinish)).', FECHA DE EMISION: '.date("d-m-Y", strtotime($certificate->dateStart))); !!}
            </td> --}}
            <td style="text-align: center;  width:95%">
                <h1 style="margin-bottom: 0px; margin-top: 5px; font-size: 35px">
                    GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI
                </h1>
               
                <small style="margin-bottom: 0px; margin-top: 5px; font-size: 20px">
                    SECRETARIA DEPARTAMENTAL DE MINERIA, ENERGIA E HIDROCARBUROS
                </small>
            </td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <td style="text-align: center;  width:100%">
                <h1 style="margin-bottom: 0px; margin-top: 5px; font-size: 30px">
                    C.O.M
                </h1>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td style="text-align: center;  width:100%">
                <h1 style="margin-bottom: 0px; margin-top: 5px; font-size: 30px">
                    CODIGO DE OPERADOR MINERO
                </h1>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td style="text-align: center;  width:100%">
                <h1 style="margin-bottom: 0px; margin-top: 5px; font-size: 30px">
                    {{$certificate->code}}
                </h1>
            </td>
        </tr>
    </table>
    <br>
    <br>

    {{-- <table width="100%">
        <tr style="text-transform: uppercase;">
            <td style="text-align: center;  width:100%">
                <h1 style="margin-bottom: 0px; margin-top: 5px; font-size: 30px">
                    {{$certificate->miningOperator}}
                </h1>
            </td>
        </tr>
    </table> --}}

    <div class="text" style="text-transform: uppercase;">
        <p style="font-size: 16px;">
            <b>NIT: {{$certificate->company->nit}}</b><br>
            <b>NIM: {{$certificate->company->nim}}</b><br>
            <b>ACTIVIDAD: {{$certificate->company->activity}}</b><br>
            <b>REPRESENTANTE LEGAL: {{$certificate->company->representative}}</b><br>
            <b>CEDULA DE IDENTIDAD: {{$certificate->company->ci}}</b><br>
            <b>MUNICIPIO: {{$certificate->company->municipe}}</b> <br>
            <b>CODIGO MUNICIPIO MINERO: {{$certificate->company->municipeMiningOperator}}</b>
        </p>
    </div>
    <table width="100%">
        <tr>
            <td style="text-align: rigth; width:32%">
                
            </td>
            <td style="text-align: center; ont-size: 15px; width:36%">
                <b style="text-transform: capitalize;">{{$certificate->signature->alias}} {{$certificate->signature->first_name}} {{$certificate->signature->last_name}}</b>
                <br>
                <b style="text-transform: uppercase;">{{$certificate->signature->job}}</b>
            </td>
            <td style="text-align: right; width:32%">
                {!! QrCode::size(120)->generate('CODIGO: '.$certificate->code.', OPERADOR MINERO: '.$certificate->company->miningOperator.', NIT: '.$certificate->company->nit.', NIM: '.$certificate->company->nim.', ACTIVIDAD: '.$certificate->company->activity.', REPRESENTANTE LEGAL: '.$certificate->company->representative.
            ', CEDULA DE IDENTIDAD: '.$certificate->company->ci.', MUNICIPIO: '.$certificate->company->municipe.', VALIDO HASTA: '.date("d-m-Y", strtotime($certificate->dateFinish)).', FECHA DE EMISION: '.date("d-m-Y", strtotime($certificate->dateStart))); !!}
            </td>
        </tr>
    </table>
    @php
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon\Carbon::parse($certificate->dateStart);
        $mes = $meses[($fecha->format('n')) - 1];

        $fecha1 = Carbon\Carbon::parse($certificate->dateFinish);
        $mes1 = $meses[($fecha->format('n')) - 1];
        // $inputs['Fecha'] =  . ' de ' . $mes . ' de ' . $fecha->format('Y');
    @endphp
    <div class="text">
        <p style="font-size: 12px;"><b>VALIDO HASTA:</b>  {{$fecha1->format('d')}} de {{$mes1}} de {{$fecha1->format('Y')}}<br><b>FECHA DE EMISION:</b> {{$fecha->format('d')}} de {{$mes}} de {{$fecha->format('Y')}}</p>
    </div>
</div>
@endsection