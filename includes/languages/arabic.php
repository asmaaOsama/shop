<?php
	
	function lang($phrase)
	{
		static $lang=array(

			"message"=>"helloA"

		);

		return $lang[$phrase];
	}
