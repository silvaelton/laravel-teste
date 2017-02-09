<?php

namespace CapOut\Http\Controllers;

use CapOut\MovDocProc;
use CapOut\DocProc;
use CapOut\Movimentacao;
use CapOut\SsoPartes;
use CapOut\Assunto;
use CapOut\Situacao;
use CapOut\DocProcCont;
use CapOut\SituacaoDocProc;
use CapOut\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Testpi3Controller extends Controller
{
	public function testar(Request $request,$id)
	{

		$pedidos = DocProc::where('idDocProc','=',$id)->with('DocProcCont.assunto','tipoDocProc', 'docProcCont.anexos.anexos')->first();
    	//dd($pedidos->DocProcCont->anexos[1]->assunto->dsAssunto);
		$ultimoBread=count($request->session()->get('bread'))-1;

			
		if($ultimoBread>0){
			$aux=session('bread');
			array_pop($aux);
			$request->session()->put('bread', $aux);
		}
		$request->session()->push('bread', $pedidos->idSsoArea.'.'.$pedidos->numero.'/'.$pedidos->ano);
		
		return view('pedido.index')->with('pedidos',$pedidos);


	}
}