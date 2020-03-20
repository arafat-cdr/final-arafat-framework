<?php

function is_logout() {

    if(empty($_SESSION['Auth'])) {

        header("location:".APP_URL."/".LOGIN_FORM);
        exit();
    }
}

function is_login(){

    if(!empty($_SESSION['Auth'])) {
        header("location:".APP_URL."/".DASHBOARD_HOME);
        exit();
    }

}

function logout() {
    unset($_SESSION['Auth']);

    set_flush(TRUE, "col-md-12", "info", "See you Soon !", "Logout is Successfull.");

    header("location:".APP_URL."/".LOGIN_FORM);
    exit();
}

# This Function Will logout Not allowed Role user
function not_allowed_to_dashboard($role){
    if($role == Auth('user_type')){
        unset($_SESSION['Auth']);

        set_flush(TRUE, "col-md-12", "info", "You are Not Allowed !", "To Dashboard !. Further Try will cause Account Termination Problem");
        header("location:".APP_URL."/".LOGIN_FORM);
        exit();
    }
}

function Auth($field){
    if(empty($_SESSION['Auth'])){
        return false;
    }

    if(isset($_SESSION['Auth']->$field)){
        return $_SESSION['Auth']->$field;
    }
    return false;
}
function refreshAuth($data){
    $_SESSION['Auth'] = $data;
}