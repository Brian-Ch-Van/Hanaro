
<script type="text/javascript">
		$(document).ready(function() {
			
			// log out
			$("#inputNewPassword").on("keyup", function() {
				$('#passwordInfo').addClass('text-primary');
			});
			
		});
</script>
		
	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h1 class="mt-5">Change Password</h1>
			
			<form class="pt-3 w-50">
				<div class="form-group">
					<label for="inputCurrentPassword" class="text-info">Current Password</label>
					<input type="password" class="form-control" id="inputCurrentPassword" placeholder="">
				</div>
				<div class="form-group">
					<label for="inputNewPassword" class="text-info">New Password</label>
					<input type="password" class="form-control" id="inputNewPassword" placeholder="">
					<small id="passwordInfo" class="form-text text-danger">Your password must be 6-20 characters long.</small>
				</div>
				<div class="form-group">
					<label for="inputConfirmPassword" class="text-info">Confirm Password</label>
					<input type="password" class="form-control" id="inputConfirmPassword" placeholder="">
					<small id="emailHelp" class="form-text text-danger">Password Match</small>
				</div>
				
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</main>