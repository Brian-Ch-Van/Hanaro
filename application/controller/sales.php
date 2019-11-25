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
	  * @Method Name	: openHourlySales
	  * @desc			: 시간별 방문객/판매액 차트
	  * @creator		: BrianC
	  * @date			: 2019. 11. 19.
	 */
	public function openHourlySales ()
	{
		$sales_model = $this->loadModel('SalesModel');
		$ptCodeList = $sales_model->selPtCodeList();
		
		require 'application/views/_templates/header.php';
		require 'application/views/sales/hourlysales.php';
		require 'application/views/_templates/footer.php';
	}
	
	/**
	 * 
	  * @Method Name	: getHourlySales
	  * @desc			: 시간별 방문객/매출액 리스트 조회 
	  * @creator		: BrianC
	  * @date			: 2019. 11. 20.
	  * @throws exception
	 */
	public function getHourlySales ()
	{
		$result = array();
		
		try {
			$formSearch = $_POST;
			
			if(!empty($formSearch)) {
				
				$sales_model = $this->loadModel('SalesModel');
				$hourlySalesList = $sales_model->selHourlySales($formSearch);
				
				$htmlTableHead = '<table class="table table-hover table-sm table-responsive-md" id="tableHourlySalesList" >
									<thead class="thead-light">
										<tr class="titleRow">
											<th scope="col">시간대</th>
											<th scope="col">고객수</th>
											<th scope="col">시간별 매출액</th>
											<th scope="col">비율</th>
											<th scope="col">객단가</th>
										</tr>
									</thead>
									<tbody>
								';
				$htmlTableTr = "";
				if (!empty($hourlySalesList)) {
					foreach ($hourlySalesList as $row) {
						$prctSales = round(($row["hs_paid"]/$row["hs_totalAmt"])*100, 2);
						$salesPerVst = round($row["hs_paid"]/$row["hs_visitor"], 2);
						$salesPerVst = number_format($salesPerVst, 2, ".", ",");
						
						$htmlTableTr .= '<tr name="trHourlySalesList">';
						$htmlTableTr .= '<td scope="row">' . $row["hs_hour"] . '</td>';
						$htmlTableTr .= '<td scope="row" class="rowDataTd">' . $row["hs_visitor"] . '</td>';
						$htmlTableTr .= '<td scope="row" class="rowDataTd">' . number_format($row["hs_paid"], 2, ".", ",") . '</td>';
						$htmlTableTr .= '<td scope="row" class="rowDataTd">' . number_format($prctSales, 2, ".", ",") . '%</td>';
						$htmlTableTr .= '<td scope="row" class="rowDataTd">' . $salesPerVst . '</td>';
						$htmlTableTr .= '</tr>';
					}
					
					$totalSalesPerVst = round($hourlySalesList[0][5]/$hourlySalesList[0][4], 2);
					$totalSalesPerVst = number_format($totalSalesPerVst, 2, ".", ",");
					
					$htmlTableTr .= '<tr class="bg-info text-white totalColumn">
										<td>Total</td>
										<td class="rowTotalTd">' . number_format($hourlySalesList[0][4], 0, ".", ",") . '</td>
										<td class="rowTotalTd">' . number_format($hourlySalesList[0][5], 2, ".", ",") . '</td>
										<td class="rowTotalTd"></td>
										<td class="rowTotalTd">' . $totalSalesPerVst . '</td>
									</tr>';
					
				} else {
					$htmlTableTr .= '<tr><td colspan="5" style="text-align: center; font-size: 18px;">No results</td></tr>';
				}
				$htmlTableCls = '</tbody></table>';
				
				$htmlData = $htmlTableHead . $htmlTableTr. $htmlTableCls;
				
				$result['success'] = true;
				$result['data'] = $htmlData;
				$result['list']	= $hourlySalesList;
				
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
	
	
	
	
}



