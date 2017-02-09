<?php

namespace CapOut;

use Illuminate\Database\Eloquent\Model;

class SsoPartes extends Model
{

//	public $timestamps = false;

	protected $primaryKey = 'id';

	protected $table = 'SSO_PARTES';
	protected $fillable =['idDocProcCont','idSsoParte','flTipoParte'];
	protected $instanciaSsO;
	/*
	public function getPartesAttribute()
	{
		return new Parte($this->attributes['idSsoParte']);
	}
	*/

	public function docProcCont()
	{
		return $this->hasOne('CapOut\DocProcCont','idDocProcCont','idDocProcCont');
	}
	public function getInteressadoAttribute()
	{
		if(!($this->instanciaSsO instanceof Parte)){
			$this->instanciaSsO = new Parte($this->attributes['idSsoParte']);
		}
		return $this->instanciaSsO;
	}
}