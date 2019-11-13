<?php
header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = excel_test.xls" );
header( "Content-Description: PHP4 Generated Data" );

$EXCEL_FILE = "
	<table border='1'>
	    <tr>
	       <td>사용자ID</td>
	       <td>이름</td>
	       <td>성</td>
	       <td>E-mail</td>
	       <td>Phone</td>
	    </tr>
	";

// while ($row = $res->fetch_object()) {
	$EXCEL_FILE .= "
	    <tr>
	       <td>1 Test</td>
	       <td>2 Test</td>
	       <td>3 Test</td>
	       <td>4 Test</td>
	       <td>5 Test</td>
	    </tr>
	";
// }

$EXCEL_FILE .= "</table>";

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
echo $EXCEL_FILE;

?>



