<?php

	/*
	get All from database v1.0
	*/
	function getAll($table,$order,$where=NULL,$ordering='DESC')
	{
		if ($where==NULL) {
			$sql="";
		}
		else{
			$sql=$where;
		}
		global $con;
		$statment=$con->prepare("SELECT * FROM $table $sql ORDER BY $order $ordering");
		$statment->execute();
		$rows=$statment->fetchAll();

		return $rows;

	}

	/*
	get categories from database v1.0
	*/
	function getCat()
	{
		global $con;
		$statment=$con->prepare("SELECT * FROM categories ORDER BY ID ASC");
		$statment->execute();
		$rows=$statment->fetchAll();

		return $rows;

	}
	/*
	get items Ad from database v1.0
	*/
	function getItem($where,$id,$approve=NULL)
	{
		if ($approve==NULL) {
			$sql="AND approve=1";
		}
		else{
			$sql=NULL;
		}
		global $con;
		$statment=$con->prepare("SELECT * FROM items WHERE $where=? $sql ORDER BY itemID DESC");
		$statment->execute(array($id));
		$rows=$statment->fetchAll();

		return $rows;

	}

	// title function that echo the page title in case v1.0
	// the page has the variable $pageTitle


	function pagesTitle()
	{
		global $getTitle;

		if (isset($getTitle)) {
			echo $getTitle;
		}

		else{
			echo "Default";
		}
	}

	/*
	home-redirect-function v2.0
	*/

	function redirectHome($errorMsg,$url=null,$seconds=3)
	{
		if ($url===null) {
			$url="index.php";
			$link="Home Page";
		}
		else{

			if (isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']!=='') {
				$url=$_SERVER['HTTP_REFERER'];
				$link="Previous Page";
			}
			else{
				$url="index.php";
				$link="Home Page";
			}

			// $url=(isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']!=='')?$_SERVER['HTTP_REFERER']:"index.php";
			// $link="Previous Page";

		}
		echo $errorMsg;
		echo "<div class='alert alert-info'>You Will Be Directed To $link After $seconds seconds.</div>";
		header("refresh:$seconds;url=$url");
		exit();
	}

	/*
	function to check item in database v1.0
	$select=the item to select EX[user,item,category]
	$from=the table to select from EX[users]
	$value=the value of select EX[osama]
	*/
	function checkItem($select,$from,$value)
	{
		global $con;
		$statment=$con->prepare("SELECT $select FROM $from WHERE $select=?");
		$statment->execute(array($value));
		$count=$statment->rowCount();
		return $count;
	}
	/*
	count-nomber-of-items-columns-v1.0

	*/
	function countItem($item,$table,$pend=null)
	{
		global $con;

		$stmt2=$con->prepare("SELECT COUNT($item) FROM $table $pend");
		$stmt2->execute();
		return $stmt2->fetchColumn();
	}
	/*
	get latest records items from database v1.0
	*/
	function getLatest($select,$table,$order,$limit=5)
	{
		global $con;
		$statment=$con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
		$statment->execute();
		$rows=$statment->fetchAll();

		return $rows;

	}
	//function-check-if-user-activate

	function checkUserStatus($user)
	{
		global $con;
		$stmt=$con->prepare("SELECT userName,regStatus FROM users WHERE userName=? AND regStatus=0");
		$stmt->execute(array($user));
		$count=$stmt->rowCount();
		return $count;
		
	}