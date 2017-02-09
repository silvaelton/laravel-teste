<?php

namespace CapOut\Helpers;
use Cache;


class Jarvis
{
    const urlBase = 'http://apiauth/';

    public static function validaUsuario($usuario,$senha){
        $ch = curl_init();
        $curlConfig = array(
            CURLOPT_URL            => self::urlBase.'validausuario',
            CURLOPT_POST           => true,
            //CURLOPT_HEADER         => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT=>5,
            CURLOPT_TIMEOUT=>5,
            CURLOPT_POSTFIELDS     => array(
                'login' => $usuario,
                'senha'   => $senha,
            )
        );
        curl_setopt_array($ch, $curlConfig);
        $result = curl_exec($ch);
        curl_close($ch);

//dd($resultado);
        return $result;

    }

    public static function buscaGeralSimplesPorId($id,$origem,$tenta=1){
        if (Cache::has('buscaGeralSimplesPorId'.'-'.$origem.'-'.$id)) {
            $result = Cache::get('buscaGeralSimplesPorId'.'-'.$origem.'-'.$id);
        }else{
            try{
                $ch = curl_init();
                $curlConfig = array(
                    CURLOPT_URL            => self::urlBase.'buscaporid/'.$id.'/'.$origem,
                    CURLOPT_POST           => false,
                    //CURLOPT_HEADER         => true,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CONNECTTIMEOUT=>10,
                    CURLOPT_TIMEOUT=>10,
                );
                curl_setopt_array($ch, $curlConfig);
                $result = curl_exec($ch);
                if(curl_errno($ch))
                {
                    throw new \Exception('Curl error in buscaGeralSimplesPorId: ' . curl_error($ch));
                }
                $status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
                curl_close($ch);
                if($status==200)
                    Cache::put('buscaGeralSimplesPorId'.'-'.$origem.'-'.$id, $result, 8*1440);//1404= 24horas
            }catch(\Exception $e){
                dd($e);
                curl_close($ch);
                if ($tenta<=1)
                    return self::buscaGeralSimplesPorId($id,$origem,2);
                else
                    return null;
            }
        }
        return $result;
    }
    public static function salvaRetornaPessoaArea($dados){
        $ch = curl_init();
        $curlConfig = array(
            CURLOPT_URL            => self::urlBase.'area-pessoa-create',
            CURLOPT_POST           => true,
            //CURLOPT_HEADER         => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT=>5,
            CURLOPT_TIMEOUT=>5,
            CURLOPT_POSTFIELDS     => $dados
        );
        curl_setopt_array($ch, $curlConfig);
        $result = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo 'Curl error in salvaRetornaPessoaArea: ' . curl_error($ch);
            curl_close($ch);
            return null;
        }
        curl_close($ch);
        return $result;
    }
    /**
     * utilizada para retornar o nome completo da area concatenado com sua hierarquia
     * @param $id
     * @return mixed
     */
    public static function nomeAreaCompletoDaArea($id){
        if (Cache::has('nomeAreaCompletoDaArea'.$id)) {
            $result = Cache::get('nomeAreaCompletoDaArea'.$id);
        }else{
            $ch = curl_init();
            $curlConfig = array(
                CURLOPT_URL            => self::urlBase.'area-completa-area',
                CURLOPT_POST           => true,
                //CURLOPT_HEADER         => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT=>5,
                CURLOPT_TIMEOUT=>5,
                CURLOPT_POSTFIELDS     => array(
                    'id' => $id,
                )
            );
            curl_setopt_array($ch, $curlConfig);
            $result = curl_exec($ch);
            if(curl_errno($ch))
            {
                echo 'Curl error in nomeAreaCompletoDaArea: ' . curl_error($ch);
                curl_close($ch);
                return null;
            }
            $status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($status==200)
                Cache::put('nomeAreaCompletoDaArea'.$id, $result, 1440);
        }
        return $result;
    }
    public static function buscaRas(){
        if (Cache::has('buscaRas')) {
            $result = Cache::get('buscaRas');
        }else{
            $ch = curl_init();
            $curlConfig = array(
                CURLOPT_URL            => self::urlBase.'busca-ra',
                CURLOPT_POST           => false,
                //CURLOPT_HEADER         => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT=>5,
                CURLOPT_TIMEOUT=>5,
            );
            curl_setopt_array($ch, $curlConfig);
            $result = curl_exec($ch);
            if(curl_errno($ch))
            {
                echo 'Curl error in buscaRas: ' . curl_error($ch);
                curl_close($ch);
                return null;
            }
            $status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($status==200)
                Cache::put('buscaRas', $result, 1440);
        }

        return $result;
    }
    public static function buscaPerfis(){
        //if (Cache::has('buscaPerfis')) {
        //$result = Cache::get('buscaPerfis');
        // }else{
        $ch = curl_init();
        $curlConfig = array(
            CURLOPT_URL            => self::urlBase.'perfil-sistema/'.request()->server('HTTP_HOST'),
            CURLOPT_POST           => false,
            //CURLOPT_HEADER         => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT=>7,
            CURLOPT_TIMEOUT=>8,
        );
        curl_setopt_array($ch, $curlConfig);
        $result = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo 'Curl error in buscaPerfis: ' . curl_error($ch);
            curl_close($ch);
            return null;
        }
        $status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
        //if($status==200)
         //   Cache::put('buscaPerfis', $result, 1440);
        // }
        return $result;
    }
    public static function buscaPessoasPerfil($perfil){
        if (Cache::has('buscaPessoaPerfil'.$perfil)) {
            $result = Cache::get('buscaPessoaPerfil'.$perfil);
        }else{
            $ch = curl_init();
            $curlConfig = array(
                CURLOPT_URL            => self::urlBase.'pessoas-perfil/'.$perfil,
                CURLOPT_POST           => false,
                //CURLOPT_HEADER         => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT=>5,
                CURLOPT_TIMEOUT=>5,
            );
            curl_setopt_array($ch, $curlConfig);
            $result = curl_exec($ch);
            if(curl_errno($ch))
            {
                echo 'Curl error inbuscaPessoasPerfil: ' . curl_error($ch);
                curl_close($ch);
                return null;
            }
            $status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($status==200)
                Cache::put('buscaPessoaPerfil'.$perfil, $result, 1440);
        }
        return $result;
    }

    public static function buscafilhos($id,$real=0){
            $ch = curl_init();
            $curlConfig = array(
                CURLOPT_URL            => self::urlBase.'areas-filho/'.$id.'?real='.$real,
                CURLOPT_POST           => false,
                //CURLOPT_HEADER         => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT=>5,
                CURLOPT_TIMEOUT=>5,
            );
            curl_setopt_array($ch, $curlConfig);
            $result = curl_exec($ch);
            if(curl_errno($ch))
            {
                echo 'Curl error inbuscafilhos: ' . curl_error($ch);
                curl_close($ch);
                return null;
            }
            $status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
            curl_close($ch);
        return $result;
    }
    public static function email($ids,$tenta=1){
        $aux=json_encode($ids);
        try{
            $ch = curl_init();
            $curlConfig = array(
                CURLOPT_URL            => self::urlBase.'email',
                CURLOPT_POST           => true,
                //CURLOPT_HEADER         => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT=>5,
                CURLOPT_TIMEOUT=>5,
                CURLOPT_POSTFIELDS     => array(
                    'ids' => $aux
                )
            );
            curl_setopt_array($ch, $curlConfig);
            $result = curl_exec($ch);
            if(curl_errno($ch))
            {
                throw new \Exception('Curl error in email: ' . curl_error($ch));
            }
            $status=curl_getinfo($ch,CURLINFO_HTTP_CODE);

            curl_close($ch);
            if($status==200)
                return $result;
            else
                return null;
        }catch(\Exception $e){
            curl_close($ch);
            if ($tenta<=1)
                return self::email($ids,2);
            else
                return null;
        }
    }
    public static function detalhes($id){
        $ch = curl_init();
        $curlConfig = array(
            CURLOPT_URL            => self::urlBase.'detalhesPessoa/'.$id,
            CURLOPT_POST           => false,
            //CURLOPT_HEADER         => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT=>5,
            CURLOPT_TIMEOUT=>5,
        );
        curl_setopt_array($ch, $curlConfig);
        $result = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo 'Curl error in detalhes: ' . curl_error($ch);
            curl_close($ch);
            return null;
        }
        $status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($status==200)
            return $result;
        else
            return null;
    }

}
