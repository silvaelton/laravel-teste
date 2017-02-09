<?php

namespace CapOut\Http\Controllers;

use CapOut\SsoPartes;
use CapOut\DocProc;
use CapOut\Ciente;
use CapOut\DocProcCont;
use CapOut\SituacaoDocProc;
use CapOut\SituacaoDocProcAnexo;
use CapOut\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class ProcessoController extends Controller
{
    public function index(Request $request)
    {
        //DB::connection()->enableQueryLog();
        $pedidos= SsoPartes::where('idSsoParte','=',session('id'))
            ->with('docProcCont')
            ->get();

        $idsProc=[];
        foreach ($pedidos as $pedido) {
            if(isset($pedido->docProcCont->idDocProc))
                $idsProc[]= $pedido->docProcCont->idDocProcOrigem;
        }

        $processos= DocProc::whereIn('idDocProc',$idsProc)
            ->where('idTpDocProc','=',1)// 1 é o id para tipos processo
            ->with(
                'ultimaMovimentacao'
                ,'docProcCont.ultimaSituacao.detalhes'
                ,'docProcCont.ultimaSituacao.movimentacao'
            )
            ->get();
        //return response()->json($processos);
        //dd(DB::getQueryLog());
        $request->session()->put('bread', ['PROCESSOS']);
        return view('processo.index')
            ->with('processos',$processos);
    }

    //método para exibição de processo
    public function show(Request $request,$id)
    {

        $pedidos = DocProc::where('idDocProc','=',$id)
            ->with('DocProcCont.assunto','tipoDocProc', 'docProcCont.anexos.partes', 'DocProcCont.ultimaMovimentacao')
            ->first();

        $pedidosPorInteressado = SsoPartes::where('idSsoParte','=',session('id'))
            ->get();

        $idsProc=[];
        foreach ($pedidosPorInteressado as $pedido) {
            $idsProc[]= $pedido->idDocProcCont;
        }

        //dd($pedidos->DocProcCont->anexos[1]->assunto->dsAssunto);
        $ultimoBread=count($request->session()->get('bread'))-1;

        if($ultimoBread>0){
            $aux=session('bread');
            array_pop($aux);
            $request->session()->put('bread', $aux);
        }
        $request->session()->push('bread', $pedidos->ssoArea.'.'.$pedidos->numero.'/'.$pedidos->ano);
        //dump(session()->all());
        return view('pedido.index')
            ->with('pedidos',$pedidos)
            ->with('interessados',$idsProc);

    }
    //metodo para exibir historico de situações do pedido
    public function historico(Request $request, $id)
    {
        //$request->session()->push('bread', 'teste');
        $pedido=DocProcCont::find($id);
        $situacoes=SituacaoDocProc::where('idDocProcCont',$id)
            ->with('anexos.identificacao.tipoDocProc','area','detalhes')
            ->orderBy('created_at','desc')
            ->get();
        return view('pedido.detalhes')
            ->with('situacoes',$situacoes);
    }
    public function checaAnexo($id)
    {
        $confirma=Ciente::where('idDocAnexo',$id)
            ->where('ssoParte',session('id'))->get();

        if(count($confirma)>=1)//retorna ok qunado ja foi notificado
            return response()->json(1,200);
        else//retorna não encontrado qunado tem notificação
            return response()->json(0,204);
    }
    public function pedeAnexo($id,$anexo)
    {
        //busco o arquivo via serviço
        $resource = curl_init();
        curl_setopt($resource, CURLOPT_URL, 'http://capin/cienteDown/'.$id.'/'.session('id'));
        curl_setopt($resource, CURLOPT_HEADER, 1);
        curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($resource, CURLOPT_BINARYTRANSFER, 1);
        //salvo conteudo do retorno
        $file = curl_exec($resource);
        //status da requisição
        $status=curl_getinfo($resource,CURLINFO_HTTP_CODE);
        //quantidade de erros 0(false) esperado
        $erro=curl_errno($resource);
        curl_close($resource);
        //dd($file);
        // copieia daqui
        //http://ryansechrest.com/2012/07/send-and-receive-binary-files-using-php-and-curl/
        //se requisição ok e erro 0
        if($status==200 && !$erro){
          //preparo alguns itens do cabeçalho da requisição
            $file_array = explode("\n\r", $file, 2);
            $header_array = explode("\n", $file_array[0]);
            foreach($header_array as $header_value) {
                $header_pieces = explode(':', $header_value);
                if(count($header_pieces) == 2) {
                    $headers[$header_pieces[0]] = trim($header_pieces[1]);
                }
            }
            //dd('http://capin/cienteUp/'.$id.'/'.session('id'));
            $atualiza = curl_init();
            curl_setopt($atualiza, CURLOPT_URL, 'http://capin/cienteUp/'.$id.'/'.session('id'));
            curl_setopt($atualiza, CURLOPT_HEADER, 1);
            curl_setopt($atualiza, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($atualiza, CURLOPT_BINARYTRANSFER, 1);
            $dado = curl_exec($atualiza);
            $status=curl_getinfo($atualiza,CURLINFO_HTTP_CODE);
            $erro=curl_errno($atualiza);
            curl_close($atualiza);
            // DB::connection()->beginTransaction();
            // //atualizo os registros de ciencia de parcial para sistema externo
            // $ciente=Ciente::whereIn('idDocAnexo',function($q2)use($id){
            //     $q2->select('id')
            //         ->from(with(new SituacaoDocProcAnexo)->getTable())
            //         ->whereIn('idDocProcCont',function($q1)use($id){
            //             $q1->select('idDocProcCont')
            //                 ->from(with(new DocProcCont)->getTable())
            //                 ->where('idDocProc',$id);
            //         });
            // })
            //     ->where('ssoParte',session('id'))
            //     ->update(['flTpNotificacao' => 3,'dtCiente'=>date('Y-m-d H:i:s')]);
            // DB::connection()->commit();
            //return response('',204);
            header('Content-type: ' . $headers['Content-Type']);
            header('Content-disposition: attachment; filename=exigencia_'.date('d_m_Y').'.pdf');
            echo substr($file_array[1], 1);
        }
        else {
            return response('',204);
        }
    }
}
