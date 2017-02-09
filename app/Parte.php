<?php

namespace CapOut;
use CapOut\Helpers;
class Parte
{
    public $idAreaPessoa;
    public $idArea;
    public $idPessoa;
    public $nomeArea;
    public $sigla;
    public $nomePessoa;
    public $nomeFull;
    public $idAreaReal;
    private $detalhes;  

//variavel origem indica a partir de qual tabela se vai buscar os dados, area, pessoa, areaPessoa
    public function __construct($id=null,$origem='areaPessoa',$json=false){
        //vejo se tenho de buscar pessoa
            //dd('id zerado');
        if($id!=null && $id!=0){
            //se tenho, vejo a partir de qual tabela tenho de buscar
            $xpto=Helpers\Jarvis::buscaGeralSimplesPorId($id,$origem);
            //dump($xpto);
            $json=json_decode($xpto,true);
            $this->id=$json['idAreaPessoa'];
        }
        if($json){            
            if(array_key_exists('idAreaPessoa',$json)){
                $this->idAreaPessoa=$json['idAreaPessoa'];
            }
            if(array_key_exists('idArea',$json)){
                $this->idArea=$json['idArea'];
            }
            if(array_key_exists('idPessoa',$json)){
                $this->idPessoa=$json['idPessoa'];
            }
            if(array_key_exists('nomeArea',$json)){
                $this->nomeArea=$json['nomeArea'];
            }
            if(array_key_exists('sigla',$json)){
                $this->sigla=$json['sigla'];
            }
            if(array_key_exists('nomePessoa',$json)){
                $this->nomePessoa=$json['nomePessoa'];
            }
            if(array_key_exists('nomeFull',$json)){
                $this->nomeFull=$json['nomeFull'];
                $this->nomeMenor = self::getNomeMenor();
            }
            if(array_key_exists('idAreaReal',$json)) {
                $this->idAreaReal = $json['idAreaReal'];
            }
        }
    }

    /*
     * Tratamento do nome completo para exibir em areas menores
     * @param int $limite
     * @return null|string
     */
    public function getNomeMenor($limite=30){
        $texto=$this->nomeFull;
        $contador = strlen($texto);
        if ( $contador >= $limite ) {
            $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . '...';
            return $texto;
        }else{
            return $texto;
        }
        return null;
    }     

    private function continuacao($campo){
        if(isset($this->idPessoa)) {
            $this->detalhes = json_decode(Helpers\Jarvis::detalhes($this->idPessoa),true);
            if (is_array($this->detalhes)) {
                if (array_key_exists($campo, $this->detalhes)) {
                    return $this->detalhes[$campo];
                }
            }
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->continuacao('nome');
    }

    /**
     * @return mixed
     */
    public function getEmailS()
    {
        return $this->continuacao('email_s');
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->continuacao('email');
    }

    /**
     * @return mixed
     */
    public function getRamal()
    {
        return $this->continuacao('ramal');
    }

    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->continuacao('telefone');
    }

    /**
     * @return mixed
     */
    public function getCelular()
    {
        return $this->continuacao('celular');
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->continuacao('cpf');
    }



}