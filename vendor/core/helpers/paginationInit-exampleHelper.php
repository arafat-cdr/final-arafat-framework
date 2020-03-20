<?php
function in_the_top($obj){
    $per_page_show = PER_PAGE;
    $total_rows =    $obj->dbSelect("payment_data", "*");
    $res =   $obj->dbSelect("payment_data", "*", "", $per_page_show, '0');
    if(isset($_GET['page'])){
        if(is_numeric($_GET['page'])){
            $page =  $_GET['page'] - 1; // bcs we need to offset 5 start 0
            $offset = $per_page_show * $page;
            $res  =  $obj->dbSelect("payment_data", "*", "", $per_page_show, $offset);
        }
    }
}
?>

<!-- printing the pagination -->
<?php if(!empty($total_rows)) {
    $total_page = @count($total_rows);
    $baseUrl ="";
    $totalResults = $total_page;
    $resultsPerPage = $per_page_show;
    $currentPage = !empty($_GET['page']) && ctype_digit($_GET['page']) ? $_GET['page'] : 1;
    echo pagination($baseUrl, $totalResults, $resultsPerPage, $currentPage);
    }
?>