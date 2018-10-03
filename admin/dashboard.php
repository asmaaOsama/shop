<?php
	session_start();

	if (isset($_SESSION['username'])) {

		
		$getTitle="Dashboard";

		include "init.php";
		/*start-dashboard-page*/

		$nomUsers=5;
		$latestUsers=(getLatest("*","users","userID",$nomUsers));
		
		$nomItems=5;
		$latestItems=(getLatest("*","items","itemID",$nomItems));
		
		$nomComments=5;
		$latestComments=(getLatest("*","comments","c_id",$nomComments));
		

	?>
	<div id="mySidenav" class="sidenav">
        <div class="text-center content-admin">
            <img src="layout/css/images/boy.png" width="80px" height="90px">
            <h4><?php echo "Welcome ", $_SESSION['username']; ?></h4>
        </div>
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="some">

            <a href="dashboard.php" class="active notAct"><i class="fa fa-home"></i>Dashboard</a>

            <div class="bad">
                <a href="categories.php" class="notAct"><i class="fa fa-suitcase"></i><?php echo lang('CATEGORIES'); ?></a>
                <span class="badge"><?php echo countItem('ID','categories'); ?></span>
            </div>

            <div class="bad">
                <a href="items.php" class="notAct"><i class="fa fa-edit"></i><?php echo lang('ITEMS'); ?></a>
                <span class="badge"><?php echo countItem('itemID','items'); ?></span>
            </div>
            <div class="bad">
                <a href="members.php" class="notAct"><i class="fa fa-users"></i><?php echo lang('MEMBERS'); ?></a>
                <span class="badge"><?php echo countItem('userID','users'); ?></span>
            </div>
            <div class="bad">
                <a href="comments.php" class="notAct"><i class="fa fa-comments-o"></i><?php echo lang('COMMENTS'); ?></a>
                <span class="badge"><?php echo countItem('c_id','comments'); ?></span>
            </div>
            <div class="bad">
                <a href="brands.php" class="notAct"><i class="fa fa-gear"></i>Brands</a>
                <span class="badge"><?php echo countItem('id','brands'); ?></span>
            </div>
            <div class="bad">
                <a href="tags.php" class="notAct"><i class="fa fa-support"></i>Tags</a>
                <span class="badge"><?php echo countItem('id','tags'); ?></span>
            </div>
      </div>
    </div>

	
	<!-- Add all page content inside this div  -->
	<div id="main">

		<div class="container home-stats text-center">
			<!-- <h1>Dashboard</h1> -->
			<div class="row">
				<div class="col-md-3">
					<div class="stat st-members">
						<i class="fa fa-users"></i>
						<div class="info" >
							Total Members
							<span><a href="members.php"><?php echo  countItem("userID","users"); ?></a></span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="stat st-pending">
						<i class="fa fa-user-plus"></i>
						<div class="info" >
							Pending Members
							<span><a href="members.php?do=Manage&page=pending"><?php echo  countItem("regStatus","users",'WHERE regStatus=0'); ?></a></span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="stat st-items">
						<i class="fa fa-tag"></i>
						<div class="info" >
							Total Items
							<span><a href="items.php"><?php echo  countItem("itemID","items"); ?></a></span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="stat st-comments">
						<i class="fa fa-comments"></i>
						<div class="info" >
							Total Comments
							<span><a href="comments.php"><?php echo  countItem("c_id","comments"); ?></a></span>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<canvas id="myChart" width="400" height="150"></canvas>
				</div>
				<div class="col-md-4">
					<canvas id="myPieChart" width="400" height="288"></canvas>
				</div>
			</div>
		</div>
		<div class="container latest">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-users"></i>Latest <?php echo  $nomUsers; ?> Register Users
							<span class="pull-right toggle-info"><i class="fa fa-plus "></i></span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-users">
							<?php
							if (!empty($latestUsers)) {
								foreach ($latestUsers as $user) {
									echo '<li>';
										echo  $user['userName'];
										echo "<a href='members.php?do=Edit&userid=".$user['userID']."'>";
											echo "<span class='btn btn-success pull-right'>";
												echo "<i class='fa fa-edit'></i>";
												if ($user['regStatus']==0) {
                                                	echo "<a href='members.php?do=Activate&userid=".
                                                	$user['userID']."
		                                            'class='btn btn-primary activate pull-right'><i class='fa fa-check'></i></a>";
		                                            }
											echo "</span>";
										echo "</a>";
									echo "</li>";
								}
							}
							else {
								echo "There is No Users To Show";
							}
							?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-tag"></i>Latest <?php echo  $nomItems; ?> Items
							<span class="pull-right toggle-info"><i class="fa fa-plus "></i></span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-users">
							<?php
								foreach ($latestItems as $item) {
									echo '<li>';
										echo  $item['name'];
										echo "<a href='items.php?do=Edit&itemid=".$item['itemID']."'>";
											echo "<span class='btn btn-success pull-right'>";
												echo "<i class='fa fa-edit'></i>";
												if ($item['Approve']==0) {
                                                	echo "<a href='items.php?do=Approve&itemid=".
                                                	$item['itemID']."
		                                            'class='btn btn-primary activate pull-right'><i class='fa fa-check'></i></a>";
		                                            }
											echo "</span>";
										echo "</a>";
									echo "</li>";
								}
							?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-comments-o"></i>Latest <?php echo  $nomComments; ?> Comments
							<span class="pull-right toggle-info"><i class="fa fa-plus "></i></span>
						</div>
						<div class="panel-body">
							<?php
								$stmt=$con->prepare("SELECT comments.*,users.userName AS userName FROM comments
                                INNER JOIN users ON users.userID=comments.user_id
                                 ORDER BY c_id DESC
                                LIMIT $nomComments");
					            $stmt->execute();
					            $comments=$stmt->fetchAll();
					            foreach ($comments as $comment) {
					            	echo "<div class='comment-box'>";
						            	echo "<span class='member-c'>".$comment['userName']."</span>";
						            	echo "<p class='comment-c'>".$comment['comment']."</p>";
					            	echo "</div>";
					            }
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
			include $tpl . "footer.php";
			}

			else{

				header("Location:index.php");
				exit();
			}
			ob_end_flush();?>
	</div>