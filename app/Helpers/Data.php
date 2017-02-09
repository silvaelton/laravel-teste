<?php

namespace CapOut\Helpers;


class Data
{
    public static function setData(){
        if (!empty($value)) {
            if (\DateTime::createFromFormat('d/m/Y', $value)) {
                $date = \DateTime::createFromFormat('d/m/Y', $value);
            } else {
                $date = \DateTime::createFromFormat('Y-m-d h:', $value);
            }
            return $date->format("Y-m-d");
        }
        return null;
    }
    public static function getData($value=null){
        if (!empty($value)) {
            if (\DateTime::createFromFormat('d/m/Y', $value)) {
                $date = \DateTime::createFromFormat('d/m/Y', $value);

            }elseif(\DateTime::createFromFormat('Y-m-d', $value)) {
                $date = \DateTime::createFromFormat('Y-m-d', $value);

            }elseif(\DateTime::createFromFormat('Y-m-d H:i:s.u', $value)) {
                $date = \DateTime::createFromFormat('Y-m-d H:i:s.u', $value);

            }
            if ($date->format('d/m/Y') == '01/01/1900') {
                return null;
            }
            return $date;
        }
        return $value;
    }
}