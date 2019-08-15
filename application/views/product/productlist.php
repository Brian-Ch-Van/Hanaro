
	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h3>Product List</h3></br>
			<?php 
				foreach ($prod_list as $row) {
					echo "-" . $row['pd_cd'] . " / " . $row['pd_name'] . " / " . $row['pd_category_name'] . "/" . $row['pd_price1'] . "/" . $row['pd_remark'] . "<br/>";
				}
			?>
		</div>
	</main>

