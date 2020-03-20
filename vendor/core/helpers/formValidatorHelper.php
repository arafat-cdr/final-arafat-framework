<?php

function validate($data = NULL){
  if(empty($data)){
    return 0;
  }
  $data = trim($data);
  // replace single quote
  $data =  str_replace("'", '"', $data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  // encode html entities
  $data = htmlentities($data);
  return $data;
}

 function auto_validate($data) {

	$res = array();

	foreach ($data as $k => $v) {

	  $res[$k] = validate($v);
	}

	return $res;
}