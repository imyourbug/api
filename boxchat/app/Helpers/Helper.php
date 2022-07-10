<?php

namespace App\Helpers;

class Helper{
    public static function getLevel($objects, $id_member, $id_skill){
        foreach($objects as $o){
            if($o->id_member == $id_member && $o->id_skill == $id_skill)
                return $o->level;
        }
        return false;
    }
}