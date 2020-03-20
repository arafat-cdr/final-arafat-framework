<?php

function get_mysql_type_date($date){
    return date('Y-m-d H:i:s', strtotime($date));
}

function get_day_month_year($dateTime){
    $datetime = new DateTime($dateTime);
    return  $datetime->format('j F Y');
}

function mysql_type_date_time($dateTime){
    $datetime = new DateTime($dateTime);
    return  $datetime->format('Y-m-d H:i:s');
}
function mysql_type_date($dateTime){
    $datetime = new DateTime($dateTime);
    return  $datetime->format('Y-m-d');
}
# Remove the Year Part form Data Range ...
function remove_year_form_date_range($date_range, $range_delimeter = "-", $date_delimeter = "/")
{
    $final_str = array();
    $split_2 = explode($range_delimeter, $date_range);
    // pr($split_2);
    if(is_array($split_2)){
        foreach ($split_2 as $k => $v) {
            $str_op = explode($date_delimeter, trim($v));
            # remove the last element of array..
            # The last element is the Year ...
            array_pop($str_op);
            $final_str[] = implode($date_delimeter, $str_op).$date_delimeter;

        }
    }
    $final_str = implode($range_delimeter, $final_str);

    return $final_str;
}