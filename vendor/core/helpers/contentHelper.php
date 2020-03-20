<?php
function get_excerpt($string, $length = 55){
    // strip tags to avoid breaking any html
    $string = strip_tags($string);
    if (strlen($string) > $length) {

        // truncate string
        $stringCut = substr($string, 0, $length);
        $endPoint = strrpos($stringCut, ' ');

        //if the string doesn't contain any space then it will cut without word basis.
        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
        // $string .= '... <a href="/this/story">Read More</a>';

        return $string;
    }
}

function get_html_decoded_data($data){
    $data = trim($data, '"');
    $data = htmlspecialchars_decode($data);
    $data = html_entity_decode($data);
    return  $data;
}