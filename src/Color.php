<?php

namespace App;

class Color
{
    private static string $Error = "\033[91m";
    private static string $Success = "\033[92m";
    private static string $Warning = "\033[93m";
    private static string $Info = "\033[96m";
    private static string $None = "\033[37m";

    /**
     * Color is red
     * @param string $text
     * @return string
     */
    public static function error(string $text){
        return Color::$Error . $text . Color::$Error;
    }

    /**
     * Color is green
     * @param string $text
     * @return string
     */
    public static function success(string $text){
        return Color::$Success . $text . Color::$Success;
    }

    /**
     * Color is yellow
     * @param string $text
     * @return string
     */
    public static function warning(string $text){
        return Color::$Warning . $text . Color::$Warning;
    }

    /**
     * Color is blue
     * @param string $text
     * @return string
     */
    public static function info(string $text){
        return Color::$Info . $text . Color::$Info;
    }

    /**
     * Color is white
     * @param string $text
     * @return string
     */
    public static function none(string $text=''){
        return Color::$None . $text . Color::$None;
    }

}