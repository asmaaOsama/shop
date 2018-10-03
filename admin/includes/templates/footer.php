		<div class="footer">
			
		</div>
		<!-- <script src="https://code.jquery.com/jquery-1.12.1.min.js"></script> -->
		<script src="<?php echo $js; ?>jquery-3.2.1.min.js"></script>
		<script src="<?php echo $js; ?>bootstrap.min.js"></script>
		<script src="<?php echo $js; ?>jquery-ui.min.js"></script>
		<script src="<?php echo $js; ?>jquery.selectBoxIt.min.js"></script>
		<script src="<?php echo $js; ?>backend.js"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script> -->
		<script src="<?php echo $js; ?>Chart.min.js"></script>
		<script>
			//sidebar

	function openNav() {
	    document.getElementById("mySidenav").style.width = "250px";
	    document.getElementById("main").style.marginLeft = "250px";
	}

	/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
	function closeNav() {
	    document.getElementById("mySidenav").style.width = "0";
	    document.getElementById("main").style.marginLeft = "0";
	}
	
	$(".ii").click(function () {
	$(".zlist").toggle();
});


	$(".show-delete").hover(function () {
		$(this).find(".del").fadeToggle(400);
	});
	//show-plus-minus-in-category

	$(".toggle-info").click(function () {
		$(this).toggleClass("selected").parent().next('.panel-body').fadeToggle(100);
		if ($(this).hasClass("selected")) {
			$(this).html("<i class='fa fa-minus'></i>");
		}
		else{
			$(this).html("<i class='fa fa-plus'></i>");
		}
		});

	
	
		</script>
	</body>
</html>