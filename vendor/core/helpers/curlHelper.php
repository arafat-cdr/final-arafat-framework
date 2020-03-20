<?php
function my_curl($data){
    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, 'http://localhost/tests/trans.php?data='.$data);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

    $res = curl_exec($cURLConnection);
    curl_close($cURLConnection);

    return $res;
}

function curl_example(){
    for($i = 0; $i < 10; $i++) {

        $data  = "data_".$i;

        $res = my_curl($data);

        echo $res.str_repeat("<br/>", 4);

    }

    echo "<br/>"."I Execute After The Curl Called";
}