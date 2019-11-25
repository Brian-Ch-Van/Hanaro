<?php

	$headerImg = IMG_URL . "/report_header_hmart_sm.png";

	header( "Content-type: application/vnd.ms-excel" );
	header( "Content-type: application/vnd.ms-excel; charset=utf-8");
	// 		header( "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header( "Content-Disposition: view; filename = $fileName" );
	header( "Content-Description: PHP4 Generated Data" );
	header( "Cache-Control: max-age=0");

