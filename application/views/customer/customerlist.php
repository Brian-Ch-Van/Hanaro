
	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h3>Customer List</h3></br>
			<?php 
				foreach ($cust_list as $row) {
					echo "-" . $row['cm_no'] . " / ". $row['cm_fname'] . " / ". $row['cm_mname'] . " / ". $row['cm_lname'] . " / ". $row['cm_street1'] . " / ". $row['cm_street2'] . " / ". $row['cm_city'] . " / ". $row['cm_province'] . " / ". $row['cm_homephone'] . " / ". $row['cm_sDate'] . "<br>";
				}
			?>
		</div>
	</main>
