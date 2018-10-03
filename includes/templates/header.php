<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php pagesTitle() ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>jquery.selectBoxIt.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>frontend.css">
		<?php if(isset($fixedFooter)):?>
			<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>fixedFooter.css">
		<?php endif;?>
	</head>
	<body>
		<div class="upper-bar">
			<div class="container">
				<?php

					if (isset($_SESSION['user'])) {
						$statment=$con->prepare("SELECT image FROM users WHERE userID=1");
						$statment->execute();
						$row=$statment->fetch();
						echo $row['image'];
				?>
					<img class='my-avatar img-responsive img-thumbnail img-circle ' src='layout/images/vector-2.jpg' alt=''>
					<div class="btn-group my-info">
						<span class="btn dropdown-toggle" data-toggle="dropdown">
							<?php echo $_SESSION['user']; ?>
							<span class="caret"></span>

						</span>
						<ul class="dropdown-menu">
							<li><a href="profile.php">My Profile</a></li>
							<li><a href="newAd.php">New Item</a></li>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</div>
					<div class="angu" ng-app="myApp" ng-controller="myController"><i class="fa fa-shopping-cart user"></i>
			      		<span id="result_button" class="badge badge-x">
			      			<?php

				      			$stat=$con->prepare("SELECT * FROM cart WHERE user_id=?");
								$stat->execute(array($_SESSION['uid']));
								$count=$stat->rowCount();
								echo $count;
			      			?>


			      		</span>
			      		<div class="table_x">
			      			<table class="text-center main-table table table-bordered main-table">
			      				<tr>
			      					<td>#</td>
			      					<td>item name</td>
			      					<td>quantity</td>
			      					<td>price</td>
			      					
			      				</tr>
			      				<?php
			      				
				      				$statment=$con->prepare("SELECT * FROM cart WHERE user_id=?");
									$statment->execute(array($_SESSION['uid']));
									$rows=$statment->fetchAll();
									$i=0;
									$total=0;
				      				foreach ($rows as $row) {
				      					$i+=1;
				      					echo "<tr>";
				      							echo "<td>".$i."</td>";
				      						
					      					echo "<td>".$row['item_name']."</td>";
					      					echo "<td>".$row['quantity']."</td>";
					      					echo "<td>$ 
					      					".$row['Price']."</td>";
					      					
					      					$total=$total+$row['Price'];

					      				
					      				echo "</tr>";
				      				}
				      				echo "<tr>
				      				<td classs='total-price'>Total Price</td>
				      				<td colspan=3>$$total</td>
				      				</tr>";

				      				
			      				
			      				?>
			      			</table>
			      		</div>
	      			</div>
					<?php
						
					}
					else{
						
					echo "<a href='login.php'>
							<span class='pull-right login_button'>Login/SignUp</span>
						</a>";
					}

				?>	
			</div>
		</div>
	<nav class="navbar navbar-inverse">
	  <div class="container">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="index.php">
	      	<div class="img_logo">
	      		<img src="product_images/obs.png">
	      	</div>
	      	
	      </a>
	    </div>

	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	    	
	      <ul class="nav navbar-nav navbar-right">
	      	<li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories<span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <?php
		      		$cats=getAll("categories","ID","WHERE parent=0","ASC");
				    foreach ($cats as $cat) {
						echo '<li><a href="categories.php?pageid='.$cat['ID'].'&pageName='.str_replace(' ','-',$cat['name']).'">'.$cat['name'].'</a></li>';
				    }
		      	?>
	          </ul>
	        </li>

	        <li class="icon_home"><a href="index.php"><i class="fa fa-home fa-x"></i></a></li>
	      	
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
			


