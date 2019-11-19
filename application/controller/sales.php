<?php

/**
 * 
  * @desc		: Sales 관련 controller
  * @creator	: BrianC
  * @date		: 2019. 11. 7.
  * @Version	: 
  * @history	: 2019-11-15 : added export to pdf
  * 			: 2019-11-18 : added excel download
  *
 */
class Sales extends Controller 
{
	public function index ()
	{
		$this->salesMain();
	}

	// Sales Main
	public function salesMain ()
	{
		require 'application/views/_templates/header.php';
		require 'application/views/sales/salesmain.php';
		require 'application/views/_templates/footer.php';
	}
	
	// sample Chart
	public function salesSplChart ()
	{
		require 'application/views/_templates/header.php';
		require 'application/report/indexreport.php';
		require 'application/views/_templates/footer.php';
	}
	
	/**
	 * 
	  * @Method Name	: openDailySales
	  * @desc			: 일별 판매 내역 조회 화면 오픈
	  * @creator		: BrianC
	  * @date			: 2019. 11. 7.
	 */
	public function openDailySales ()
	{
		require 'application/views/_templates/header.php';
		require 'application/views/sales/dailysales.php';
		require 'application/views/_templates/footer.php';
	}
	
	/**
	 * 
	  * @Method Name	: getDailySales
	  * @desc			: 일별 판매 내역 조회 - 조회 기간
	  * @creator		: BrianC
	  * @date			: 2019. 11. 12.
	  * @throws exception
	 */
	public function getDailySales ()
	{
		$result = array();
		
		try {
			$formSearch = $_POST;
			
			if(!empty($formSearch)) {
				
				$sales_model = $this->loadModel('SalesModel');
				$dailySalesList = $sales_model->selDailySales($formSearch);
				
				$htmlTableHead = "<table class='table table-hover table-sm table-responsive-md' id='tableDailySalesList'>
									<thead class='thead-light'>
										<tr class='titleRow'>
											<th scope='col'>Date</th>
											<th scope='col'>Sale Q'ty</th>
											<th scope='col'>Price</th>
											<th scope='col'>HST</th>
											<th scope='col'>GST</th>
											<th scope='col'>PST</th>
											<th scope='col'>Amount</th>
										</tr>
									</thead>
									<tbody>
								";
				$htmlTableTr = "";
				if (!empty($dailySalesList)) { 
					foreach ($dailySalesList as $row) {
						$htmlTableTr .= "<tr name='trDailySalesList'>";
						$htmlTableTr .= "<td scope='row'>" . date('Y-m-d, D', strtotime($row['ds_date'])) . "</td>";
						$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_qty'], 2, '.', ',') . "</td>";
						$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_amt'], 2, '.', ',') . "</td>";
						$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_hst'], 2, '.', ',') . "</td>";
						$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_gst'], 2, '.', ',') . "</td>";
						$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_pst'], 2, '.', ',') . "</td>";
						$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_totalAmt'], 2, '.', ',') . "</td>";
						$htmlTableTr .= "</tr>";
					}
					$htmlTableTr .= "<tr class='bg-info text-white totalColumn'>
										<td>Total</td>
										<td class='rowTotalTd'></td>
										<td class='rowTotalTd'></td>
										<td class='rowTotalTd'></td>
										<td class='rowTotalTd'></td>
										<td class='rowTotalTd'></td>
										<td class='rowTotalTd'></td>
									</tr>";
					
				} else {
					$htmlTableTr .= "<tr><td colspan='7' style='text-align: center; font-size: 18px;'>No results</td></tr>";
				}
				$htmlTableCls = "</tbody></table>";
				
				$htmlData = $htmlTableHead . $htmlTableTr. $htmlTableCls;
				
				$result['success'] = true;
				$result['data'] = $htmlData;
				
			} else {
				throw new exception ('조회 기간 Form Data가 없습니다.');
			}
			
		} catch (Exception $e) {
			$result['success'] = false;
			$result['errMsg'] = $e->getMessage();
			
		} finally {
			echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		}

	}
	
	/**
	 * 
	  * @Method Name	: getDailySalesByDate
	  * @desc			: 일별 판매 내역 조회 - By Date
	  * @creator		: BrianC
	  * @date			: 2019. 11. 12.
	 */
	public function getDailySalesByDate () {
		
		$result = array();
		
		try {
			if(isset($_POST['byDate'])) {
				if (empty($_POST['byDate'])) {
					throw new exception ('조회를 원하는 날짜에 오류가 있습니다.');
				} else {
					$byDate = $_POST['byDate'];
					
					$sales_model = $this->loadModel('SalesModel');
					$dailySalesByDate = $sales_model->selDailySalesByDate($byDate);
					
					$htmlTableHead = "<table class='table table-hover table-sm table-responsive-md' id='tableDailySalesByDate'>
										<thead class='thead-light'>
											<tr class='titleRow'>
												<th scope='col'>Code</th>
												<th scope='col'>Name</th>
												<th scope='col'>Sale Q'ty</th>
												<th scope='col'>Price</th>
												<th scope='col'>HST</th>
												<th scope='col'>GST</th>
												<th scope='col'>PST</th>
												<th scope='col'>Amount</th>
											</tr>
										</thead>
										<tbody>
										";
					$htmlTableTr = "";
					if (!empty($dailySalesByDate)) {
						$htmlTableTr .= "<tr class='bg-info text-white totalColumn'>
											<td></td>
											<td>Total</td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
										</tr>";
						
						foreach ($dailySalesByDate as $row) {
							$htmlTableTr .= "<tr name='trDailySalesByDate'>";
							$htmlTableTr .= "<td scope='row'>" . $row['ds_pcode'] . "</td>";
							$htmlTableTr .= "<td scope='row'>" . $row['ds_ptname'] . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_qty'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_amt'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_hst'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_gst'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_pst'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_totalAmt'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "</tr>";
						}
						
					} else {
						$htmlTableTr .= "<tr><td colspan='8' style='text-align: center; font-size: 18px;'>No results</td></tr>";
					}
					$htmlTableCls = "</tbody></table>";
					
					$htmlData = $htmlTableHead . $htmlTableTr. $htmlTableCls;
					
					$result['success'] = true;
					$result['data'] = $htmlData;
					
				}
			}
			
		} catch (Exception $e) {
			$result['success'] = false;
			$result['errMsg'] = $e->getMessage();
			
		} finally {
			echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		}
		
	}
	
	/**
	 * 
	  * @Method Name	: getDailySalesByType
	  * @desc			: 일별 판매 내역 조회 - By Type
	  * @creator		: BrianC
	  * @date			: 2019. 11. 12.
	 */
	public function getDailySalesByType ()
	{
		$result = array();
		
		try {
			if(isset($_POST['byDate']) && isset($_POST['byType'])) {
				if (empty($_POST['byDate'])) {
					throw new exception ('조회를 원하는 날짜에 오류가 있습니다.');
				} else if (empty($_POST['byType']) ){
					throw new exception ('조회를 원하는 품목에 오류가 있습니다.');
				} else {
					$byDate = $_POST['byDate'];
					$byType = $_POST['byType'];
					
					$sales_model = $this->loadModel('SalesModel');
					
					$dailySalesByType = $sales_model->selDailySalesByType($byDate, $byType);
					
					$htmlTableHead = "<table class='table table-hover table-sm table-responsive-md' id='tableDailySalesByType'>
										<thead class='thead-light'>
											<tr class='titleRow'>
												<th scope='col'>Code</th>
												<th scope='col'>Name</th>
												<th scope='col'>Sale Q'ty</th>
												<th scope='col'>Price</th>
												<th scope='col'>HST</th>
												<th scope='col'>GST</th>
												<th scope='col'>PST</th>
												<th scope='col'>Amount</th>
											</tr>
										</thead>
										<tbody>
										";
					$htmlTableTr = "";
					if (!empty($dailySalesByType)) {
						$htmlTableTr .= "<tr class='bg-info text-white totalColumn'>
											<td></td>
											<td>Total</td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
										</tr>";
						
						foreach ($dailySalesByType as $row) {
							$htmlTableTr .= "<tr name='trDailySalesByType'>";
							$htmlTableTr .= "<td scope='row'>" . $row['ds_ptype'] . "</td>";
							$htmlTableTr .= "<td scope='row'>" . $row['ds_pname'] . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_qty'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_amt'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_hst'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_gst'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_pst'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_totalAmt'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "</tr>";
						}
						
					} else {
						$htmlTableTr .= "<tr><td colspan='8' style='text-align: center; font-size: 18px;'>No results</td></tr>";
					}
					$htmlTableCls = "</tbody></table>";
					
					$htmlData = $htmlTableHead . $htmlTableTr. $htmlTableCls;
					
					$result['success'] = true;
					$result['data'] = $htmlData;
					
				}
			}
			
		} catch (Exception $e) {
			$result['success'] = true;
			$result['errMsg'] = $e->getMessage();
			
		} finally {
			echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		}
	}
	
	/**
	 * 
	  * @Method Name	: getDailySalesByTypeDetail
	  * @desc			: 일별 판매 내역 조회 - Details by Type
	  * @creator		: BrianC
	  * @date			: 2019. 11. 13.
	  * @throws exception
	 */
	public function getDailySalesByTypeDetail ()
	{
		$result = array();
		
		try {
			if(isset($_POST['byDate']) && isset($_POST['byPtype'])) {
				if (empty($_POST['byDate'])) {
					throw new exception ('조회를 원하는 날짜에 오류가 있습니다.');
				} else if (empty($_POST['byPtype']) ){
					throw new exception ('조회를 원하는 상세 품목에 오류가 있습니다.');
				} else {
					$byDate = $_POST['byDate'];
					$byPtype = $_POST['byPtype'];
					
					$sales_model = $this->loadModel('SalesModel');
					
					$dailySalesByTypeDetail = $sales_model->selDailySalesByTypeDetail($byDate, $byPtype);
					
					$htmlTableHead = "<table class='table table-hover table-sm table-responsive-md' id='tableDailySalesByTypeDetail'>
										<thead class='thead-light'>
											<tr class='titleRow'>
												<th scope='col'>Name</th>
												<th scope='col'>Sale Q'ty</th>
												<th scope='col'>Price</th>
												<th scope='col'>HST</th>
												<th scope='col'>GST</th>
												<th scope='col'>PST</th>
												<th scope='col'>Amount</th>
											</tr>
										</thead>
										<tbody>
										";
					$htmlTableTr = "";
					if (!empty($dailySalesByTypeDetail)) {
						$htmlTableTr .= "<tr class='bg-info text-white totalColumn'>
											<td>Total</td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
											<td class='rowTotalTd'></td>
										</tr>";
						
						foreach ($dailySalesByTypeDetail as $row) {
							$htmlTableTr .= "<tr name='trDailySalesByTypeDetail'>";
							if(empty($row['ds_prodKname'])) {
								$htmlTableTr .= "<td scope='row'>" . $row['ds_prodName'] . "<br>" . $row['ds_prod'] . "</td>";
							} else {
								$htmlTableTr .= "<td scope='row'>" . $row['ds_prodName'] . " (" . $row['ds_prodKname']. ")<br>" . $row['ds_prod'] . "</td>";
							}
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_qty'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_amt'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_hst'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_gst'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_pst'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "<td scope='row' class='rowDataTd'>" . number_format($row['ds_totalAmt'], 2, '.', ',') . "</td>";
							$htmlTableTr .= "</tr>";
						}
						
					} else {
						$htmlTableTr .= "<tr><td colspan='7' style='text-align: center; font-size: 18px;'>No results</td></tr>";
					}
					$htmlTableCls = "</tbody></table>";
					
					$htmlData = $htmlTableHead . $htmlTableTr. $htmlTableCls;
					
					$result['success'] = true;
					$result['data'] = $htmlData;
					
				}
			}
			
		} catch (Exception $e) {
			$result['success'] = true;
			$result['errMsg'] = $e->getMessage();
			
		} finally {
			echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		}
	}
	
	/**
	 * 
	  * @Method Name	: testExport
	  * @desc			: 일별 매출 내역 export test
	  * @creator		: BrianC
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
	
	/**
	 * 
	  * @Method Name	: exportPdfDailySales
	  * @desc			: export to PDF
	  * @creator		: BrianC
	  * @date			: 2019. 11. 15.
	 */
	public function exportPdfDailySales ()
	{
		// main TCPDF library
		require_once 'application/libs/tcpdf_min/config/tcpdf_config.php';
		
		// create new PDF document
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
	  * @Method Name	: exportDailySalesExl
	  * @desc			: Daily Sales export to excel
	  * @creator		: BrianC
	  * @date			: 2019. 11. 18.
	 */
	public function exportExlDailySales ()
	{
		date_default_timezone_set('America/Vancouver');
		$fileDate = date("Ymd");
		$fileName = "Daily Sales_" . $fileDate . ".xls";
		$title = "Daily Sales Report";
		$headerImg = IMG_URL . "/report_header_hmart_sm.png";
		
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-type: application/vnd.ms-excel; charset=utf-8");
// 		header( "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header( "Content-Disposition: view; filename = $fileName" );
		header( "Content-Description: PHP4 Generated Data" );
		header( "Cache-Control: max-age=0");
		
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
								.titleRow {
									background-color: #bdd7f1;
								}
								.totalColumn {
									background-color: #17a2b8;
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
							<tr class="">
								<th class="titleRow" width="20%">Date</th>
								<th class="titleRow" width="15%">Sale Q\'ty</th>
								<th class="titleRow" width="15%">Price</th>
								<th class="titleRow" width="10%">HST</th>
								<th class="titleRow" width="15%">GST</th>
								<th class="titleRow" width="10%">PST</th>
								<th class="titleRow" width="15%">Amount</th>
							</tr>
						</thead>
						<tbody>
						';
		if (!empty($dailySalesList)) {
			$totals = [0,0,0,0,0,0];
			
			foreach ($dailySalesList as $row) {
				$exlFile .= '	<tr class="trBody">
									<td width="20%">'. date("Y-m-d, D", strtotime($row["ds_date"])) . '</td>
									<td width="15%">' . number_format($row["ds_qty"], 2, '.', ',') . '</td>
									<td width="15%">' . number_format($row["ds_amt"], 2, '.', ',') . '</td>
									<td width="10%" style="mso-number-format:\'0\.00\'">' . number_format($row["ds_hst"], 2, '.', ',') . '</td>
									<td width="15%">' . number_format($row["ds_gst"], 2, '.', ',') . '</td>
									<td width="10%">' . number_format($row["ds_pst"], 2, '.', ',') . '</td>
									<td width="15%">' . number_format($row["ds_totalAmt"], 2, '.', ',') . '</td>
								</tr>';
				$totals[0] += $row["ds_qty"];
				$totals[1] += $row["ds_amt"];
				$totals[2] += $row["ds_hst"];
				$totals[3] += $row["ds_gst"];
				$totals[4] += $row["ds_pst"];
				$totals[5] += $row["ds_totalAmt"];
			}
			$exlFile .= '	<tr>
								<td class="totalColumn" id="firstTotalTd" width="20%">Total</td>
								<td class="totalColumn" width="15%">' . number_format($totals[0], 2, '.', ',') . '</td>
								<td class="totalColumn" width="15%">' . number_format($totals[1], 2, '.', ',') . '</td>
								<td class="totalColumn" width="10%" style="mso-number-format:\'0\.00\'">' . number_format($totals[2], 2, '.', ',') . '</td>
								<td class="totalColumn" width="15%">' . number_format($totals[3], 2, '.', ',') . '</td>
								<td class="totalColumn" width="10%">' . number_format($totals[4], 2, '.', ',') . '</td>
								<td class="totalColumn" width="15%">' . number_format($totals[5], 2, '.', ',') . '</td>
							</tr>';
			
		} else {
			$exlFile .= '<tr><td colspan="7" style="text-align: center; font-size: 15px;">No results</td></tr>';
		}
		$exlFile .= '</tbody></table>';
		$exlFile .= '</body></html>';
		
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		echo $exlFile;
	}
	
}



