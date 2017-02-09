<?php

namespace CapOut;

use Illuminate\Database\Eloquent\Model;
use CapOut\docProc;

class RelacionaTagDocProc extends Model
{
   
    public $timestamps = false; 

	protected $primaryKey = 'idRelTag';

	protected $table = 'TB_RELACIONA_TAG_DOC';

}
