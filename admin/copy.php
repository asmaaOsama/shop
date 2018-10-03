<?php
	ob_start();
	session_start();
    $getTitle="Members";
    if (isset($_SESSION['username'])) {
        

        include "init.php";


        $do=isset($_GET['do']) ? $_GET['do'] : "Manage";

        if ($do=="Manage") {
        }

        elseif ($do=="Add") {
        }

        elseif ($do=="Insert") {
        }

        elseif ($do=="Edit") {
        }

        elseif ($do=="update") {
        }

        elseif ($do=="Delete") {
        }

        include $tpl . "footer.php";
    }
    else{
        header("Location:index.php");
        exit();
    }
    ob_end_flush();


