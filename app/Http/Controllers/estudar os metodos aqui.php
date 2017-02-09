<?php

namespace CapOut\Http\Controllers;

use CapOut\Pessoa;
use CapOut\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessaoController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function testar()
    {

    $request = Request::create('http://apiauth/', 'GET');

    $response = Route::dispatch($request);
    }
}