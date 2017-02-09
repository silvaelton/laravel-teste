<?php

namespace CapOut;

class Area
{
	private $id;
	private $id_pai;
	private $nome;
	private $sigla;
	private $ativo;
	private $interno;
	private $codigo_protocolo;
	private $cnpj;

	public function __construct($aux=null){
		//$aux=json_decode($json,true);
		$this->id= (array_key_exists('id',$aux))? $aux['id'] : null;
		$this->id_pai= (array_key_exists('id_pai',$aux))? $aux['id_pai'] : null;
		$this->nome= (array_key_exists('nome',$aux))? $aux['nome'] : null;
		$this->sigla= (array_key_exists('sigla',$aux))? $aux['sigla'] : null;
		$this->ativo= (array_key_exists('ativo',$aux))? $aux['ativo'] : null;
		$this->interno= (array_key_exists('interno',$aux))? $aux['interno'] : null;
		$this->codigo_protocolo= (array_key_exists('codigo_protocolo',$aux))? $aux['codigo_protocolo'] : null;
		$this->cnpj= (array_key_exists('cnpj',$aux))? $aux['cnpj'] : null;
	}

	public function getId(){
		return $this->id;
	}

	public function getId_pai(){
		return $this->id_pai;
	}

	public function getNome(){
		return $this->nome;
	}

	public function getSigla(){
		return $this->sigla;
	}

	public function getAtivo(){
		return $this->ativo;
	}

	public function getInterno(){
		return $this->interno;
	}

	public function getCodigoProtocolo(){
		return $this->codigo_protocolo;
	}

	public function getCnpj(){
		return $this->cnpj;
	}



}