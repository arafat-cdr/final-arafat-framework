<?php
require (__DIR__."/bootstrap/autoload.php");

// echo str_repeat("<br/>", 3);


$last = 'ff';

#-------------------------------------------------------
#-------------------------------------------------------
/*pr(Route::$url_to_match);

echo str_repeat("<br/>", 3);*/

#-------------------------------------------------------
#-------------------------------------------------------



# My Router Example is Here ....
# Wao This Is Great....
if($last == "abc.html"){
    echo "hi bro";
}else if($last == 'crm'){
    echo "welcome to the Crm";
}else if($last == 'great'){
    echo 'great';
}else if($last == "user"){
    pr(auth_info());
}else{
    // echo "<br/> This is Run Globally <br/>";

    /*Auth::auth_from_start();
    Auth::auth_form_email();
    Auth::auth_form_password();
    Auth::auth_form_submit();
    Auth::auth_form_end();*/
}