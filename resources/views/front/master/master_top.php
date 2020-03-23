<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        <?php
            if(isset($title)){
                echo $title;
            }else if(defined("SITE_TITLE")){
                echo SITE_TITLE;
            }
        ?>
    </title>
    <?php include(VIEW_PATH."/front/includes/header.php"); ?>
</head>
<body>
   <?php loader()->get_inject_after_body_tag(); ?>
   <?php include(VIEW_PATH."/front/includes/menu.php"); ?>
