<?php
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		if (isset($_SESSION['user'])) {

			
			$name=$_POST['postname'];
			$price=$_POST['postprice'];
			$id=$_POST['postid'];


		$stmt=$con->prepare("INSERT INTO 
			cart(user_id,items_id,Price,item_name,quantity)
            VALUES (:zuser,:zitem,:zprice,:itemName,1)");

        $stmt->execute(array(
            'zuser'=>$_SESSION['uid'],
            'zitem'=>$id,
            'zprice'=>$price,
            'itemName'=>$name
            // 'ztotal'=>$num*$rows['price']
            
           

        ));

        if ($stmt) {
        	$successMsg="<div class='alert alert-success'>".$stmt->rowCount()." " . "Record Added</div>";

        }

		}
		else{
			$errorMsg="<div class='alert alert-danger'>Sign Up First</div>";
		}
		}
		

        $stat=$con->prepare("SELECT * FROM cart WHERE user_id=?");
			$stat->execute(array($_SESSION['uid']));
			$count=$stat->rowCount();
			echo "1";
?>