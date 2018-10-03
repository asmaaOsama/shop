		<footer>
			<div class="container">
				<div class="footer">
					All Rights &copy; Reseved
				</div>
			</div>
		</footer>
		<!-- <script src="https://code.jquery.com/jquery-1.12.1.min.js"></script> -->
		<script src="<?php echo $js; ?>jquery-3.2.1.min.js"></script>
		<script src="<?php echo $js; ?>bootstrap.min.js"></script>
		<script src="<?php echo $js; ?>jquery-ui.min.js"></script>
		<script src="<?php echo $js; ?>jquery.selectBoxIt.min.js"></script>
		<script src="<?php echo $js; ?>angular.min.js"></script>
		<script src="<?php echo $js; ?>controller.js"></script>
		<script src="<?php echo $js; ?>front.js"></script>

		<script>
			$(".toggle-info").click(function () {
			$(this).toggleClass("selected").parent().next('.panel-body').fadeToggle(100);
			if ($(this).hasClass("selected")) {
				$(this).html("<i class='fa fa-minus'></i>");
			}
			else{
				$(this).html("<i class='fa fa-plus'></i>");
			}
		});

			var id=$("#id_input").val();
			var price=$("#price_input").val();
			var name=$("#name_input").val();
			window.onload=function(){
				'use strict';
			$.post('acton.php',
				function (data) {

					$("#result_button").html($data);
				
			});
		}


			$(".angu").click(function () {
				$(".table_x").fadeToggle(400);
			});
			var app=angular.module("myApp",[]);
			app.controller("myController",function ($scope) {
				$scope.count=0;
				
				$scope.myFunc=function () {
					$scope.count+=1;
				}
			})
			
			
			
		</script>
	</body>
</html>