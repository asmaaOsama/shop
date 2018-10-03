<?php
	
	function lang($phrase)
	{
		// $stmt=$con->prepare("SELECT userName FROM users WHERE groupID==1");
  //       $stmt->execute();
  //       $rows=$stmt->fetch();

		static $lang=array(

			"ADMIN"=>"Home",
			"CATEGORIES"=>"Categories",
			"ITEMS"=>"items",
			"MEMBERS"=>"Members",
			"STATISTICS"=>"Statistics",
			"COMMENTS"=>"Comments",
			"LOGS"=>"Logs",
			"NAME"=>"Asmaa",
			"EDIT"=>"Edit Profile",
			"SETTING"=>"Settings",
			"LOGOUT"=>"Log Out"
			

		);

		return $lang[$phrase];
	}

	