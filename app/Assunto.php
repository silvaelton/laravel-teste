<?php

namespace CapOut;

use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{
    public $timestamps = false; 

	protected $primaryKey = 'idAssunto';

	protected $table = 'TB_ASSUNTO';

	
}
