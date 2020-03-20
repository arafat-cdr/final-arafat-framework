<?php
class AuthMiddleware{
    public static function index(){
        echo "<br/>I am middleware index</br/>";
    }

    public static function check(){
        echo "<br/>I am middleware check</br/>";
    }

    public static function foo(){
        echo "<br/>I am middleware foo</br/>";
    }
}