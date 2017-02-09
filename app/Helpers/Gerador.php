<?php
/**
 * Created by PhpStorm.
 * User: d2678128
 * Date: 02/08/2016
 * Time: 13:54
 */

namespace CapOut\Helpers;


use CapOut\DocProc;
use CapOut\DocProcCont;
use Illuminate\Support\Facades\Mail;
use PDF;
use Milon\Barcode\DNS2D;

class Gerador
{
    public static function geraDocumento(DocProc $docProc)
    {
        $cabecaDocumento = utf8_decode(view('modelos.exigencia.head')->with('conteudo',$docProc)->render());
        $docProc->load("docProcCont.processoOriginal.docProcCont");
        $conteudo =  view('modelos.exigencia.body')
            ->with('conteudo',$docProc);
        ///dump($docProc);
        //$assinatura = view('modelos.exigencia.assinatura')->render();
        $geral = $conteudo;//.$assinatura;
        
        $rodape = view('modelos.exigencia.footer')
        ->with("qr",self::geraBarcode($docProc->docProcCont->hash,3))->render();
        $rodape = utf8_decode($rodape);
        //return $geral;
        //exit();
        $path =  base_path() . '/public/documentos/';
        
        $nome_arquivo = time() . '-'.$docProc->idDocProc.'.pdf';
        $pdf = Pdf::loadHTML($geral);
        $pdf->setPaper('a4')
            ->setOption('header-html',$cabecaDocumento)
            ->setOption('header-spacing',9)
            ->setOption('footer-html',$rodape)
            ->setOption('margin-bottom', 50)
            ->save($path.$nome_arquivo);
        return $nome_arquivo;
    }
    public static function geraEmail(DocProcCont $documento)
    {
        $ids=[];
        foreach ($documento->partesInteressadas as $id){
            $ids[]=$id->idSsoParte;
        }
        $aux=json_decode(Jarvis::email($ids));
        if(is_array($aux)) {
            foreach ($aux as $dado) {
                if ($dado->email != null) {
                    $statusEmail = Mail::send('modelos.email.email', array('dado' => $dado), function ($message) use ($dado) {
                        $message->to($dado->email, $dado->nome);
                        $message->from('hello@app.com', 'Teste');
                        $message->sender('hello@app.com', 'Teste');
                        $message->subject('CAP - Atualização situacional de  processo');
                        //$message->attach("http://www.repositorio.segeth.df.gov.br/img/sso_email_topo.png");
                        //$message->attach("http://www.repositorio.segeth.df.gov.br/img/sso_email_rodape.png");
                    });
                }
            }
        }
    }

    public static function geraBarcode($hash=null,$tipo=null) {
        //recebo string, gero qr com essa estring e retorno uma imagem
        $d = new DNS2D();
        if($tipo==1) {
            $barra = $d->getBarcodePNG($hash, "QRCODE",5,5);
            header('Content-Disposition: attachment;filename="'.$hash.'.png"');
            header('Content-Type: application/force-download');
            return base64_decode($barra);
        }
        else {

             $barra = $d->getBarcodePNG("http://".$_SERVER['HTTP_HOST']."/validadoc/".$hash, "QRCODE",3,3); 
             return $barra;          
        } 

    }
}