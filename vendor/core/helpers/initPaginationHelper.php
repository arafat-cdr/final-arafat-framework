<?php

function process_pagination($obj,$per_page_show, $table, $where = false){

	if(isset($_GET['page'])){

		if(is_numeric($_GET['page'])){

			$page =  $_GET['page'] - 1; // bcs we need to offset 5 start 0

			$offset = $per_page_show * $page;

			if($where != false){

				$res =	 $obj->dbSelect("$table", "*", "$where", $per_page_show, $offset);
			}else{

				$res =	 $obj->dbSelect("$table", "*", "", $per_page_show, $offset);
			}

		}

	}else{

		if($where != false){

			$res = $obj->dbSelect("$table", "*", "$where", $per_page_show, '0');
		}else{

			$res = $obj->dbSelect("$table", "*", "", $per_page_show, '0');
		}

	}


	return $res;
}


function create_pagination_link($obj,$per_page_show, $table, $where = false){

	if($where != false){

		$total_rows =	 $obj->dbSelect("$table", "*", "$where");
	}else{

		$total_rows =	 $obj->dbSelect("users", "*");
	}

	if(!empty($total_rows)) {

		$total_page = @count($total_rows);
		$baseUrl = $_SERVER['PHP_SELF'];
		$totalResults = $total_page;
		$resultsPerPage = $per_page_show;
		$currentPage = !empty($_GET['page']) && ctype_digit($_GET['page']) ? $_GET['page'] : 1;
		echo pagination($baseUrl, $totalResults, $resultsPerPage, $currentPage);
	}
}