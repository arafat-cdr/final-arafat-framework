<?php

if(!function_exists("pr")){
    function pr($data){
        echo "<pre style='background: black; color:green; font-size: 25px;'>";
        print_r($data);
        echo "</pre>";
    }
}
if(!function_exists("vpr")){
    function vpr($data){
        echo "<pre style='background: black; color:green; font-size: 25px;'>";
        var_dump($data);
        echo "</pre>";
    }
}
if(!function_exists("dd")){
    function dd($data){
    	echo "<pre style='background: black; color:green; font-size: 25px;'>";
    	print_r($data);
    	echo "</pre>";

    	die();
    }
}