<?php

class Validate
{
    // 文字列が指定を超えている場合true
    public static function isStrOverMaxLength($str, $length)
    {
        return strlen($str) > $length ? true : false;
    }


    // マルチバイト文字列が指定を超えている場合true
    public static function isMbStrOverMaxLength($str, $length)
    {
        return mb_strlen($str) > $length ? true : false;
    }


    // 文字列が英数字のみの場合true
    public static function isAlphabetAndNumOnly($str)
    {
        return ctype_alnum($str);
    }
}