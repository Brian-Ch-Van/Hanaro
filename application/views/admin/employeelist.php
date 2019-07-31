
	<main role="main" class="flex-shrink-0">
		<div class="container">
			<?php 
				foreach ($eply_list as $row) {
					echo "-" . $row['sf_no'] . " / " . $row['sf_name'] . " / " . $row['sf_sdate'] . " / " . $row['sf_contact'] . " / " . $row['sf_remark'] . "<br/>";
				}
			?>
		</div>
	</main>