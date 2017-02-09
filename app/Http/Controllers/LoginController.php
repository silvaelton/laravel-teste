<?php

namespace CapOut\Http\Controllers;

use CapOut\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CapOut\Helpers;
use CapOut\SituacaoArea;

class LoginController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function validar(Request $request)
    {

		$validacao=Helpers\Jarvis::validaUsuario($request->input('login'),$request->input('senha'));
        $sucesso=json_decode($validacao);
        if($sucesso){
            //busco dados da area
            
            //cria sessão
            $request->session()->put('id', $sucesso->area_pessoa_atual[0]->pivot->id);
            $request->session()->put('idArea', $sucesso->area_pessoa_atual[0]->pivot->id_area);
            $request->session()->put('idPessoa', $sucesso->area_pessoa_atual[0]->pivot->id_pessoa);
            $request->session()->put('permicoes', $sucesso->permicoes);
            $request->session()->put('nome', $sucesso->nome);
            $request->session()->put('local', $sucesso->atualAreaPessoa->nomeArea);
            $request->session()->put('localCompleto', $sucesso->atualAreaPessoa->nomeFull);
            $request->session()->put('idAreaReal', $sucesso->atualAreaPessoa->idAreaPessoa);
            $request->session()->put('areasFilho', $sucesso->areasFilho);
            $request->session()->put('hierarquia', $sucesso->hierarquia);
            $request->session()->put('resto', $sucesso);
            
            $request->session()->put('sucesso','Bem vindo.');
            return redirect()->route('index');
        }
        
        $request->session()->put('erro','Falha ao logar.');
        return redirect()->route('telaLogin');
    }

    public function sair(Request $request)
    {
		$request->session()->flush();
        return redirect()->route('telaLogin');
    }
    public function telaLogin(Request $request)
    {
		
        return view('login');
    }
}