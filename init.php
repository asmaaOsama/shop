<?php 

	//routes
	include "connect.php";

	$sessionUser='';
	if (isset($_SESSION['user'])) {
		$sessionUser=$_SESSION['user'];
	}

	$tpl="includes/templates/";	//template-direction
	$lang="includes/languages/";	//language-direction
	$func="includes/functions/";	//functions-direction
	$css="layout/css/";			//css-direction
	$js="layout/js/";			//js-direction
	

	//include-other-pages

	include $func ."functions.php";
	include $lang ."english.php";
	include $tpl . "header.php";
	