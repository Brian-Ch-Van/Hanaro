
	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h3>Employee List</h3></br>
			<?php 
				foreach ($eply_list as $row) {
					echo "-" . $row['sf_no'] . " / " . $row['sf_name'] . " / " . $row['sf_sdate'] . " / " . $row['sf_contact'] . " / " . $row['sf_remark'] . "<br/>";
				}
			?>
		</div>
	</main>