<?php

/**
 *
 * @desc		: file export controller
 * @creator		: BrianC
 * @date		: 2019. 11. 22.
 * @Version		:
 * @history		: 
 *
 */
class ExportFile extends Controller
{
	
	/**
	 *
	 * @Method Name		: exportPdfDailySales
	 * @desc			: export to PDF
	 * @creator			: BrianC
	 * @date			: 2019. 11. 15.
	 */
	public function exportPdfDailySales ()
	{
		// main TCPDF library
		require_once 'application/libs/tcpdf_min/config/tcpdf_config.php';
		
		require_once 'application/libs/tcpdf_min/tcpdf.php';
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$pdf->setFontSubsetting(false) ;
		
		// document information
		$pdf->SetCreator('Hana Solutions');
		$pdf->SetAuthor('');
		$pdf->SetTitle('Daily Sales Report');	// window name
		$pdf->SetSubject('');
		$pdf->SetKeywords('');
		
		// header
		// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		// footer
		$pdf->setFooterData(array(0,64,0), array(0,64,128));	// font color, line color
		
		// header and footer fonts
		//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));	// font, size
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));	// font, size
		
		// remove header
		$pdf->setPrintHeader(false);
		
		// default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// margins
		$pdf->SetMargins(10, 15, 10);	//left, top, right
		//$pdf->SetHeaderMargin(10);
		$pdf->SetFooterMargin(10);
		
		// auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		
		// default font subsetting mode
		$pdf->setFontSubsetting(true);
		
		// font : 용량 고려 - helvetica or times
		$pdf->SetFont('helvetica', '', 14, '', true);
		// $pdf->SetFont('nanumgothic', '', 14, '', true); // 한글 - 폰트 받아서 파일 변환 필요, 현재 나눔고딕/코딩만 적용
		
		// add a page
		$pdf->AddPage();
		
		// text shadow effect
		//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
		
		// html start ==============================================
		$formSearch = $_POST;
		
		$sales_model = $this->loadModel('SalesModel');
		$dailySalesList = $sales_model->selDailySales($formSearch);
		
		$htmlData = '
					<style>
					h1 {
						text-align: center;
					}
					.table {
						margin: 3;
						padding: 3;
						border-spacing: 0 5px;
					}
					.titleRow {
						font-size: 15px;
						background-color: #bdd7f1;
						line-height: 2;
						margin: 10;
					}
					.trBody {
						font-size: 15px;
					}
					.rowTh {
						text-align: right;
					}
					.rowDataTd {
						text-align: right;
					}
					td#firstTotalTd {
						text-align: center;
					}
					.rowTotalTd {
						text-align: right;
					}
					.totalColumn {
						background-color: #17a2b8;
						color: white;
					}
					</style>
					';
		$htmlData .= '<h1>Daily Sales Report</h1>';
		
		$htmlData .= '	<table class="table" id="tableDailySalesList">
						<thead>
							<tr class="titleRow">
								<th id="firstTh" width="20%">Date</th>
								<th class="rowTh" width="15%">Sale Q\'ty</th>
								<th class="rowTh" width="15%">Price</th>
								<th class="rowTh" width="10%">HST</th>
								<th class="rowTh" width="15%">GST</th>
								<th class="rowTh" width="10%">PST</th>
								<th class="rowTh" width="15%">Amount</th>
							</tr>
						</thead>
						<tbody>
						';
		if (!empty($dailySalesList)) {
			foreach ($dailySalesList as $row) {
				$htmlData .= '	<tr class="trBody" name="trDailySalesList">
									<td id="firstDataTd" width="20%">'. date("Y-m-d, D", strtotime($row["ds_date"])) . '</td>
									<td class="rowDataTd" width="15%">' . number_format($row["ds_qty"], 2, '.', ',') . '</td>
									<td class="rowDataTd" width="15%">'. number_format($row["ds_amt"], 2, '.', ',') . '</td>
									<td class="rowDataTd" width="10%">' . number_format($row["ds_hst"], 2, '.', ',') . '</td>
									<td class="rowDataTd" width="15%">' . number_format($row["ds_gst"], 2, '.', ',') . '</td>
									<td class="rowDataTd" width="10%">' . number_format($row["ds_pst"], 2, '.', ',') . '</td>
									<td class="rowDataTd" width="15%">' . number_format($row["ds_totalAmt"], 2, '.', ',') . '</td>
								</tr>';
			}
			$htmlData .= '	<tr class="totalColumn">
								<td id="firstTotalTd" width="20%">Total</td>
								<td class="rowTotalTd" width="15%"></td>
								<td class="rowTotalTd" width="15%"></td>
								<td class="rowTotalTd" width="10%"></td>
								<td class="rowTotalTd" width="15%"></td>
								<td class="rowTotalTd" width="10%"></td>
								<td class="rowTotalTd" width="15%"></td>
							</tr>';
			
		} else {
			$htmlData .= '<tr><td colspan="7" style="text-align: center; font-size: 18px;">No results</td></tr>';
		}
		$htmlData .= '</tbody></table>';
		
		// html end ==============================================
		
		// output the HTML content
		// 		$pdf->writeHTML($htmlData, true, false, true, false, '');
		
		$pdf->writeHTMLCell(0, 0, '', '', $htmlData, 0, 1, 0, true, '', true);
		
		$pdf->Output('Daily Sales Report.pdf', 'I');	// error 메세지 구분
	}
	
	/**
	 *
	 * @Method Name		: exportExlDailySales
	 * @desc			: Daily Sales export to excel
	 * @creator			: BrianC
	 * @date			: 2019. 11. 18.
	 */
	public function exportExlDailySales ()
	{
		date_default_timezone_set('America/Vancouver');
		$fileDate = date("Ymd");
		$fileName = "Daily Sales_" . $fileDate . ".xls";
		$title = "Daily Sales Report";
		
		require_once 'application/libs/contentheader.php';
		
		// table start ==============================================
		$formSearch = $_POST;

		$sales_model = $this->loadModel('SalesModel');
		
		$dailySalesList = $sales_model->selDailySales($formSearch);
		
		$exlFile = '
					<html>
						<head>
							<style type="text/css">
								table {
									font-size: 15;
								}
								tr {
									height: 27px;
								}
								.titleRow{
									background-color: #bdd7f1;
									text-align: right;
								}
								#thDate {
									text-align: left;
								}
								.totalColumn {
									background-color: #17a2b8;
									font-weight: bold;
									color: white;
								}
							</style>
						</head>
					<body>
						<div>
							<img src="'. $headerImg . '" alt="hmart-header-logo"/>
						</div>
		';
		$exlFile .= '<table>
						<tr><td></td></tr>
						<tr>
							<td colspan="7" style="text-align: center;"><h2>' . $title . '</h2></td>
						</tr>
						<tr><td></td></tr>
								
						<thead>
							<tr id="trTile">
								<th class="titleRow" id="thDate" width="130">Date</th>
								<th class="titleRow" width="90">Sale Q\'ty</th>
								<th class="titleRow" width="90">Price</th>
								<th class="titleRow" width="70">HST</th>
								<th class="titleRow" width="80">GST</th>
								<th class="titleRow" width="80">PST</th>
								<th class="titleRow" width="95">Amount</th>
							</tr>
						</thead>
						<tbody>
						';
		if (!empty($dailySalesList)) {
			$totals = [0,0,0,0,0,0];
			
			foreach ($dailySalesList as $row) {
				$exlFile .= '	<tr class="trBody">
									<td>'. date("Y-m-d, D", strtotime($row["ds_date"])) . '</td>
									<td>' . number_format($row["ds_qty"], 2, '.', ',') . '</td>
									<td>' . number_format($row["ds_amt"], 2, '.', ',') . '</td>
									<td style="mso-number-format:\'0\.00\'">' . number_format($row["ds_hst"], 2, '.', ',') . '</td>
									<td>' . number_format($row["ds_gst"], 2, '.', ',') . '</td>
									<td>' . number_format($row["ds_pst"], 2, '.', ',') . '</td>
									<td>' . number_format($row["ds_totalAmt"], 2, '.', ',') . '</td>
								</tr>';
				$totals[0] += $row["ds_qty"];
				$totals[1] += $row["ds_amt"];
				$totals[2] += $row["ds_hst"];
				$totals[3] += $row["ds_gst"];
				$totals[4] += $row["ds_pst"];
				$totals[5] += $row["ds_totalAmt"];
			}
			$exlFile .= '	<tr>
								<td class="totalColumn" id="firstTotalTd">Total</td>
								<td class="totalColumn">' . number_format($totals[0], 2, '.', ',') . '</td>
								<td class="totalColumn">' . number_format($totals[1], 2, '.', ',') . '</td>
								<td class="totalColumn" style="mso-number-format:\'0\.00\'">' . number_format($totals[2], 2, '.', ',') . '</td>
								<td class="totalColumn">' . number_format($totals[3], 2, '.', ',') . '</td>
								<td class="totalColumn">' . number_format($totals[4], 2, '.', ',') . '</td>
								<td class="totalColumn">' . number_format($totals[5], 2, '.', ',') . '</td>
							</tr>';
			
		} else {
			$exlFile .= '<tr><td colspan="7" style="text-align: center; font-size: 15px;">No results</td></tr>';
		}
		$exlFile .= '</tbody></table>';
		$exlFile .= '</body></html>';
		
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		echo $exlFile;
	}
	
	/**
	 *
	 * @Method Name		: exportExlHourlySales
	 * @desc			: 시간별 방문객/매출액 export excel
	 * @creator			: BrianC
	 * @date			: 2019. 11. 22.
	 */
	public function exportExlHourlySales ()
	{
		date_default_timezone_set('America/Vancouver');
		$fileDate = date("Ymd");
		$fileName = "Hourly Sales_" . $fileDate . ".xls";
		$title = "Hourly Sales Report";
		
		require_once 'application/libs/contentheader.php';
		
		// table start ==============================================
		$formSearch = $_POST;
		
		$sales_model = $this->loadModel('SalesModel');
		$hourlySalesList = $sales_model->selHourlySales($formSearch);
		
		$exlFile = '
					<html>
						<head>
							<style type="text/css">
								table {
									font-size: 15;
								}
								tr {
									height: 27px;
								}
								.titleRow {
									background-color: #bdd7f1;
									text-align: right;
								}
								.totalColumn {
									background-color: #17a2b8;
									font-weight: bold;
									color: white;
								}
							</style>
						</head>
					<body>
						<div>
							<img src="'. $headerImg . '" alt="hmart-header-logo"/>
						</div>
		';
		$exlFile .= '<table>
						<tr><td></td></tr>
						<tr>
							<td colspan="5" style="text-align: center;"><h2>' . $title . '</h2></td>
						</tr>
						<tr><td></td></tr>
								
						<thead class="thead-light">
							<tr>
								<th class="titleRow" width="100">시간대</th>
								<th class="titleRow" width="100">고객수</th>
								<th class="titleRow" width="180">시간별 매출액</th>
								<th class="titleRow" width="120">비율</th>
								<th class="titleRow" width="120">객단가</th>
							</tr>
						</thead>
						<tbody>
						';
		if (!empty($hourlySalesList)) {
			foreach ($hourlySalesList as $row) {
				$prctSales = round(($row["hs_paid"]/$row["hs_totalAmt"])*100, 2);
				$salesPerVst = round($row["hs_paid"]/$row["hs_visitor"], 2);
				$salesPerVst = number_format($salesPerVst, 2, ".", ",");
				
				$exlFile .= '	<tr class="trBody">
									<td>'. $row["hs_hour"] . '</td>
									<td>' . $row["hs_visitor"] . '</td>
									<td>' . number_format($row["hs_paid"], 2, ".", ",") . '</td>
									<td>' . number_format($prctSales, 2, ".", ",") . '%</td>
									<td>' . $salesPerVst . '</td>
								</tr>';
			}
			
			$totalSalesPerVst = round($hourlySalesList[0][5]/$hourlySalesList[0][4], 2);
			$totalSalesPerVst = number_format($totalSalesPerVst, 2, ".", ",");
			
			$exlFile .= '	<tr>
								<td class="totalColumn" id="firstTotalTd">Total</td>
								<td class="totalColumn" >' . number_format($hourlySalesList[0][4], 0, ".", ",") . '</td>
								<td class="totalColumn" >' . number_format($hourlySalesList[0][5], 2, ".", ",") . '</td>
								<td class="totalColumn" ></td>
								<td class="totalColumn" >' . $totalSalesPerVst . '</td>
							</tr>';
			
		} else {
			$exlFile .= '<tr><td colspan="5" style="text-align: center; font-size: 15px;">No results</td></tr>';
		}
		$exlFile .= '</tbody></table>';
		$exlFile .= '</body></html>';
		
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		echo $exlFile;
	}
	
	/**
	 *
	 * @Method Name		: testExport
	 * @desc			: 일별 매출 내역 export test
	 * @creator			: BrianC
	 * @date			: 2019. 11. 13.
	 */
	public function testExport ()
	{
		if(array_key_exists('user_id', $_SESSION) && !empty($_SESSION['user_id'])) {
			
			require_once 'application/libs/tcpdf_min/config/tcpdf_config.php';
			
			require_once 'application/libs/tcpdf_min/tcpdf.php';
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			$pdf->SetCreator('Hana Solutions');
			$pdf->SetAuthor('');
			$pdf->SetTitle('Daily Sales Report');	// window name
			$pdf->SetSubject('');
			$pdf->SetKeywords('');
			
			// header
			// 		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			// footer
			$pdf->setFooterData(array(0,64,0), array(0,64,128));	// font color, line color
			
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));	// font, size
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));	// font, size
			
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			$pdf->SetMargins(10, 25, 10);	//left, top, right
			$pdf->SetHeaderMargin(10);
			$pdf->SetFooterMargin(10);
			
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
			
			$pdf->setFontSubsetting(true);
			$pdf->SetFont('helvetica', '', 14, '', true);
			// $pdf->SetFont('nanumgothic', '', 14, '', true); // 한글 - 폰트 받아서 파일 변환 필요, 현재 나눔고딕/코딩만 적용
			
			$pdf->AddPage();
			
			//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
			
			// html start ==============================================
			$htmlData = <<<EOF
						<table>
							<body>
								<h1>Daily Sales Report</h1>
								<table>
									<tr>
										<td>
											Daily Sales Report!!!!!
										</td>
									</tr>
									<tr>
										<td>
											Daily Sales Report!!!!!
										</td>
									</tr>
									<tr>
										<td>
											Daily Sales Report!!!!!
										</td>
									</tr>
								</table>
							</body>
						</table>
EOF;
			
			// writeHTML 함수로 만들어도 됨. append 가능
			$pdf->writeHTML($htmlData, true, false, true, false, '');
			
			// javascript
			// 			$pdf->IncludeJS($js);
			
			// html end ===============================================
			
			// Print text using writeHTMLCell()
			$pdf->writeHTMLCell(0, 0, '', '', $htmlData, 0, 1, 0, true, '', true);
			
			// Close and output PDF document
			$pdf->Output('Daily Sales Report.pdf', 'I');	// error 메세지 구분
			
		} else {
			require 'application/views/error/wrongpage.php';
		}
		
	}
	
}

