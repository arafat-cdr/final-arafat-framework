<?php
$base_url = APP_URL;
// echo $base_url;
function redirect($url = NULL) {

	global $base_url;

		if($url == "self") {
			#reload the Current Page
			header('Location: '.$_SERVER['REQUEST_URI']);
			exit();

		}else {
			#redirect to Given Page
			header("location:".$base_url."/".$url);
			exit();
		}
}
