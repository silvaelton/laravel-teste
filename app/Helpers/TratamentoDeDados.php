<?php
/**
 * Created by PhpStorm.
 * User: d2678128
 * Date: 02/08/2016
 * Time: 14:40
 */

namespace CapOut\Helpers;


class TratamentoDeDados
{
    public static function quebraNumProcesso($value){
        $orgao=explode('.',$value)[0];
        $temp=explode('.', explode('/', $value)[0])[1];
        $num=$temp;
        $ano=explode('/', $value)[1];
        
        return array($orgao,$num,$ano);
    }
    
    public static function dataParaDateTime($value = null)
    {
        if (!empty($value)) {
            if(!($value instanceof \DateTime)){
                if (\DateTime::createFromFormat('d/m/Y', $value)) {
                    $date = \DateTime::createFromFormat('d/m/Y', $value);
                }
                if (\DateTime::createFromFormat('d/m/Y H:i', $value)) {
                    $date = \DateTime::createFromFormat('d/m/Y H:i', $value);
                }
                if (\DateTime::createFromFormat('d/m/Y H:i:s.u', $value)) {
                    $date = \DateTime::createFromFormat('d/m/Y H:i:s.u', $value);
                }
                if (\DateTime::createFromFormat('Y-m-d', $value)) {
                    $date = \DateTime::createFromFormat('Y-m-d', $value);
                }
                if (\DateTime::createFromFormat('Y-m-d H:i', $value)) {
                    $date = \DateTime::createFromFormat('Y-m-d H:i', $value);
                }
                if (\DateTime::createFromFormat('Y-m-d H:i:s.u', $value)) {
                    $date = \DateTime::createFromFormat('Y-m-d H:i:s.u', $value);
                }
                if (isset($date)) {
                    if ($date->format('d/m/Y') == '01/01/1900') {
                        $date == null;
                    }
                }
                return $date;
            }
        }
        return $value;
    }
    public static function dataMaiorQue($dtComparada,$dtBase){
        $dtComparada=self::dataParaDateTime($dtComparada);
        $dtBase=self::dataParaDateTime($dtBase);
        if($dtComparada instanceof \DateTime && $dtBase instanceof  \DateTime){
            $aux=$dtBase->diff( $dtComparada );
            if((int)$aux->format('%r%a')>=1){
                $temp=$aux->format('%r%a')*24;
            }else{
                $temp=(int)$aux->format('%r%a');
            }
            return $temp;
        }
        return 0;
    }
}