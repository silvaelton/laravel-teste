<?php

namespace CapOut;

class Pessoa
{
    private $id;
    private $nome;
    private $matricula;
    private $email_s;
    private $email;
    private $ramal;
    private $data_nascimento;
    private $data_admissao;
    private $data_desligamento;
    private $ativo;
    private $cpf;

    public function __construct($aux)
    {
    //$aux=json_decode($json,true);
    $this->id=array_key_exists('id',$aux)?$aux['id'] : null;
    $this->nome=array_key_exists('nome',$aux)?$aux['nome'] : null;
    $this->matricula=array_key_exists('matricula',$aux)?$aux['matricula'] : null;
    $this->email_s=array_key_exists('email_s',$aux)?$aux['email_s'] : null;
    $this->email=array_key_exists('email',$aux)?$aux['email'] : null;
    $this->ramal=array_key_exists('ramal',$aux)?$aux['ramal'] : null;
    $this->data_nascimento=array_key_exists('data_nascimento',$aux)?$aux['data_nascimento'] : null;
    $this->data_admissao=array_key_exists('data_admissao',$aux)?$aux['data_admissao'] : null;
    $this->data_desligamento=array_key_exists('data_desligamento',$aux)?$aux['data_desligamento'] : null;
    $this->ativo=array_key_exists('ativo',$aux)?$aux['ativo'] : null;
    $this->cpf=array_key_exists('cpf',$aux)?$aux['cpf'] : null;
    }

    public function getId(){
        return $this->id;
    }
    public function getNome(){
        return $this->nome;
    }
    public function getMatricula(){
        return $this->matricula;
    }
    public function getEmail_s(){
        return $this->email_s;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getRamal(){
        return $this->ramal;
    }
    public function getData_nascimento(){
        return $this->data_nascimento;
    }
    public function getData_admissao(){
        return $this->data_admissao;
    }
    public function getData_desligamento(){
        return $this->data_desligamento;
    }
    public function getAtivo(){
        return $this->ativo;
    }
    public function getCpf(){
        return $this->cpf;
    }

}