<?php
function set_flush($is_flush_msg = 0, $grid_class = NUll, $alert_class = NULL, $msg_1 = NULL, $msg_2 = NULL) {

    $_SESSION['is_flush_msg'] =  $is_flush_msg;
    $_SESSION['grid_class']   =  $grid_class;
    $_SESSION['alert_class']  =  $alert_class;
    $_SESSION['msg_1']        =  $msg_1;
    $_SESSION['msg_2']        =  $msg_2;
}

function default_success_flash($type = 'Save'){

    set_flush(TRUE, "col-md-12", "success", "Data ".$type." Successfull");
}

function default_failed_flash($type = 'Save'){

    set_flush(TRUE, "col-md-12", "danger", "Data ".$type." Failed");
}


function delete_flush() {

    $_SESSION['is_flush_msg'] =  NULL;
    $_SESSION['grid_class']   =  NULL;
    $_SESSION['alert_class']  =  NULL;
    $_SESSION['msg_1']        =  NULL;
    $_SESSION['msg_2']        =  NULL;
}
