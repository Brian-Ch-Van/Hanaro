
	<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
	<script type="text/javascript">

		$(document).ready(function() {
	
			$("#log_out").on("click", function() {
			    location.href = "<?php echo URL; ?>/login/logOut";
			});
			
		});

	</script>

	<?php 
		echo $_SESSION['user_name'] . '님이 로그인 했습니다.';
	?>
	<br/>	
	<input type="button" value="sign out" class="btn btn-lg btn-primary btn-block" id="log_out">

	 