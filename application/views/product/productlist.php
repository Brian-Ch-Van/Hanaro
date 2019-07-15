<?php 

foreach ($prod_list as $row) {
	echo "-" . $row['pd_cd'] . " / " . $row['pd_name'] . " / " . $row['pd_category_name'] . "/" . $row['pd_price1'] . "/" . $row['pd_remark'] . "<br/>";
}


