<?php 
	$splitFileName = explode('\\', __FILE__); 
	require 'application/views/_templates/authvalid.php';
?>
	<script type="text/javascript">
		$(document).ready(function () {
		    
		    $('form').attr('autocomplete','off');
		    $('#loader').hide();

			$('#inputFromDate').val(getToday());
			$('#inputToDate').val(getToday());

		    var dsData = "";
			$('#btnSearch').on('click', function (e){
			    e.preventDefault();

			    $('#divList p').text('일자별 매출 현황');
			    $('#btnDaily').hide();
			    
		    	var formData = $('#formSearch').serialize(true);
		    	console.log("Search input data : " + formData);

		    	if(isEmpty($('#inputFromDate').val())) {
			    	// confirm dialog
		    	    $("#dialog").data('item', 'From date').data('bodyText', ' 를 입력해주세요.').data('id', 'inputFromDate').dialog("open");
			    	return;
		    	} else if(isEmpty($('#inputToDate').val())) {
		    	    $("#dialog").data('item', 'To date').data('bodyText', ' 를 입력해주세요.').data('id', 'inputToDate').dialog("open");
			    	return;
		    	}

		    	if($('#inputFromDate').val() > $('#inputToDate').val()) {
		    	    $("#dialog").data('item', '').data('bodyText', '시작일은 종료일 보다 클 수 없습니다.').data('id', 'inputFromDate').dialog("open");
			    	return;
		    	}

		    	var loading;
		    	$.ajax({
			    	url			: '<?php echo URL;?>/sales/getDailySales/', 
			    	type		: 'post',
			    	data		: formData, 
			    	dataType	: 'json',
					beforeSend: function() {
					    $('#loader').show();
					    $('#divTable').hide();
					    
						var cnt = 1;
						loading = setInterval(function (){
							cnt++;
							$('#progressbar').css('width', cnt+'%');
							
							if(cnt == 99) {
								clearInterval(loading);
							}
						}, 150);			
					},
					complete: function(){
					    $('#loader').hide();
					    $('#divTable').show();
					    $('#progressbar').css('width', '1%');
						clearInterval(loading);
					},
			    	success		: function (result) {
			    	    if(result.success == true) {
			    	        $('#divBtnUp').html('<input type="button" class="btn btn-sm btn-outline-danger" value="PDF" id="btnPrintPdf"><input type="button" class="btn btn-sm btn-outline-success  ml-1" value="Excel" id="btnExcel">');
							$('#divTable').html(result.data);
							dsData = result.data;

							var totals = [0,0,0,0,0,0];
							var dataRows = $("#tableDailySalesList tr[name='trDailySalesList']");

							dataRows.each(function() {
								$(this).find('.rowDataTd').each(function(i){        
									totals[i] += parseFloat($(this).text().replace(',', ''));
								});
							});

							$("#tableDailySalesList td.rowTotalTd").each(function(i) {  
								$(this).html(formatNumber(totals[i]));	// number format - 1,234.56
							});
							
			    	    } else {
							$('.modal-title').text('ERROR');
							$('#modalHeader').addClass('bg-danger');
							$('#modalMsg').text(result.errMsg);
							
							$('#cnfModal').modal('show');
							return;
			    	    }
			    	},
			    	error : function (jqXHR, textStatus, errorThrown) {	
						$('.modal-title').text('ERROR');
						$('#modalHeader').addClass('bg-danger');
						$('#modalMsg').html(jqXHR.responseText);
						
						$('#cnfModal').modal('show');
					}
			    }) // end ajax
			});	// end btn search

			var schDateDay = "";
			var schDate = "";
			var schCode = "";	
			var schType = "";	
			var schPtype = "";	
			var schPname = "";

			$("#divTable").on("dblclick", "tr[name='trDailySalesList']", getSalesByDate);
			$("#divTable").on("dblclick", "tr[name='trDailySalesByDate']", getSalesByType);

			// list by date
			function getSalesByDate (event) {
			 	// event.data 없으면 call from up button
				if(isEmpty(event.data)) {	
					schDateDay = $(this).find('td:nth-child(1)').text();
					schDate = schDateDay.split(',')[0];
				} 

				$.ajax({
					url			: '<?php echo URL; ?>/sales/getDailySalesByDate/',
					type		: 'post',
					data		: { 
									byDate		: schDate
								},
					dataType	: 'json',
					success		: function (result) {
			    	    if(result.success == true) {
			    	        $('#divList p').text(schDateDay);
							$('#divBtnUp').html('<input type="button" class="btn btn-sm btn-outline-danger" value="PDF" id="btnPrintPdf"><input type="button" class="btn btn-sm btn-info ml-1" value="Up" id="btnDaily">');
			    	        
							$('#divTable').html(result.data);

							var totals=[0,0,0,0,0,0];
							var dataRows=$("#tableDailySalesByDate tr[name='trDailySalesByDate']");

							dataRows.each(function() {
								$(this).find('.rowDataTd').each(function(i){        
									totals[i] += parseFloat($(this).text().replace(',', ''));
								});
							});

							$("#tableDailySalesByDate td.rowTotalTd").each(function(i) {  
								$(this).html(formatNumber(totals[i]));	// number format - 1,234.56
							});
							
			    	    } else {
							$('.modal-title').text('ERROR');
							$('#modalHeader').addClass('bg-danger');
							$('#modalMsg').text(result.errMsg);
							
							$('#cnfModal').modal('show');
							return;
			    	    }
					}, 
					error		: function (jqXHR, textStatus, errorThrown) {
						$('.modal-title').text('ERROR');
						$('#modalHeader').addClass('bg-danger');
						$('#modalMsg').html(jqXHR.responseText);
						
						$('#cnfModal').modal('show');
					}
				});	// end ajax
			};	// end getSalesByDate

			// list by type
			function getSalesByType (event) {
				if(isEmpty(event.data)) {
				    schCode = $(this).find('td:nth-child(1)').text();
				    schType = $(this).find('td:nth-child(2)').text();
				}
				
			    $.ajax({
					url			: '<?php echo URL; ?>/sales/getDailySalesByType/',
					type		: 'post',
					data		: { 
									byDate		: schDate,
									byType		: schCode
								},
					dataType	: 'json',
					success		: function (result) {
			    	    if(result.success == true) {
			    	        $('#divList p').text(schDate + ' : ' + schCode + ' ' + schType);
							$('#divBtnUp').html('<input type="button" class="btn btn-sm btn-outline-danger" value="PDF" id="btnPrintPdf"><input type="button" class="btn btn-sm btn-info ml-1" value="Up" id="btnByDate">');
			    	        
							$('#divTable').html(result.data);

							// sum column
							var totals=[0,0,0,0,0,0];
							var dataRows=$("tr[name='trDailySalesByType']");

							dataRows.each(function() {
								$(this).find('.rowDataTd').each(function(i){        
									totals[i] += parseFloat($(this).text().replace(',', ''));
								});
							});

							$("td.rowTotalTd").each(function(i) {
								$(this).html(formatNumber(totals[i]));	// number format - 1,234.56
							});
							
			    	    } else {
							$('.modal-title').text('ERROR');
							$('#modalHeader').addClass('bg-danger');
							$('#modalMsg').text(result.errMsg);
							
							$('#cnfModal').modal('show');
							return;
			    	    }
					}, 
					error		: function (jqXHR, textStatus, errorThrown) {
						$('.modal-title').text('ERROR');
						$('#modalHeader').addClass('bg-danger');
						$('#modalMsg').html(jqXHR.responseText);
						
						$('#cnfModal').modal('show');
					}

				});	// end ajax			    
			};	// end list by type

			// list by type detail
			$("#divTable").on("dblclick", "tr[name='trDailySalesByType']", function () {
			    schPtype = $(this).find('td:nth-child(1)').text();
			    schPname = $(this).find('td:nth-child(2)').text();

			    $.ajax({
					url			: '<?php echo URL; ?>/sales/getDailySalesByTypeDetail/',
					type		: 'post',
					data		: { 
									byDate		: schDate,
									byPtype		: schPtype
									},
					dataType	: 'json',
					success		: function (result) {
			    	    if(result.success == true) {
			    	        $('#divList p').text(schDate + ' : ' + schPtype + ' ' + schPname);
							$('#divBtnUp').html('<input type="button" class="btn btn-sm btn-outline-danger" value="PDF" id="btnPrintPdf"><input type="button" class="btn btn-sm btn-info ml-1" value="Up" id="btnByType">');
			    	        
							$('#divTable').html(result.data);

							var totals=[0,0,0,0,0,0];
							var dataRows=$("tr[name='trDailySalesByTypeDetail']");

							dataRows.each(function() {
								$(this).find('.rowDataTd').each(function(i){        
									totals[i] += parseFloat($(this).text().replace(',', ''));
								});
							});

							$("td.rowTotalTd").each(function(i) {
								$(this).html(formatNumber(totals[i]));	// number format - 1,234.56
							});							
							
			    	    } else {
							$('.modal-title').text('ERROR');
							$('#modalHeader').addClass('bg-danger');
							$('#modalMsg').text(result.errMsg);
							
							$('#cnfModal').modal('show');
							return;
			    	    }
					}, 
					error		: function (jqXHR, textStatus, errorThrown) {
						$('.modal-title').text('ERROR');
						$('#modalHeader').addClass('bg-danger');
						$('#modalMsg').html(jqXHR.responseText);
						
						$('#cnfModal').modal('show');
					}
				});	// end ajax
			});

			// export to pdf - 현재 버튼 없음. print pdf로 대체
			$(document).on('click', '#btnPdf', function (){
			    $('#formSearch').attr("action", "<?php echo URL;?>/exportfile/exportPdfDailySales/");
			    $('#formSearch').attr("method", "post");
			    $('#formSearch').attr("target", "Daily_Sales_Pdf");
			    
			    window.open("", "Daily_Sales_Pdf");
			    $('#formSearch').submit();
			    
			});	// end export to pdf			

			$(document).on('click', '#btnDaily', function () {
				if(!isEmpty (dsData)) {
				    $('#divList p').text('일자별 매출 현황');
	    	        $('#divBtnUp').html('<input type="button" class="btn btn-sm btn-outline-danger" value="PDF" id="btnPrintPdf"><input type="button" class="btn btn-sm btn-outline-success ml-1" value="Excel" id="btnExcel">');
					$('#divTable').html(dsData);

					var totals = [0,0,0,0,0,0];
					var dataRows = $("#tableDailySalesList tr[name='trDailySalesList']");

					dataRows.each(function() {
						$(this).find('.rowDataTd').each(function(i){        
							totals[i] += parseFloat($(this).text().replace(',', ''));
						});
					});

					$("#tableDailySalesList td.rowTotalTd").each(function(i) {  
						$(this).html(formatNumber(totals[i]));	// number format - 1,234.56
					});
				} else {
				    $('#btnSearch').trigger('click');
				}
			});
			
			$(document).on('click', '#btnByDate', {from : "btnByDate"}, getSalesByDate);	// up to list by date
			$(document).on('click', '#btnByType', {from : "btnByType"}, getSalesByType);	// up to list by type
			
            $("#inputFromDate").datepicker({yearRange: "-1:+0"});
            $("#inputToDate").datepicker({yearRange: "-1:+0"});

            // pdf
            $(document).on('click', '#btnPrintPdf', function (){
				var oriTitle = $(document).attr('title');
				$(document).prop('title', 'Daily Sales_' + getTodayNoHyph());
				
				// sub title
				if($('#divList p').text() != "일자별 매출 현황") {
					$('.hidden-obj h3').text("(" + $('#divList p').text() + ")");
				} else {
				    $('.hidden-obj h3').text("");
				}
				
				window.print();
				$(document).attr('title', oriTitle);
            });
            
            // excel
            $(document).on('click', '#btnExcel', function (){
			    $('#formSearch').attr("action", "<?php echo URL;?>/exportfile/exportExlDailySales/");
			    $('#formSearch').attr("method", "post");
			    $('#formSearch').submit();
            });

		})

	</script>
	
	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h2 class="mt-4 no-print" style="font-weight: bold;">일별 판매 내역</h2>
			<div class="hidden-obj" ><!-- screen hidden -->
				<img src="<?php echo IMG_URL; ?>/report_header_hmart.png" style="width: 200px;" alt="hmart-header-logo">
				<h2 style="text-align: center; margin: 20px 0px; font-weight: bold">Daily Sales Report</h2>
				<h3 style="text-align: center;"></h3>
			</div>
			<!-- Search -->
			<div class="my-3 p-3 rounded shadow-sm no-print" style="background-color: #dfebf7;">
				<div class="media mb-3">
					<img src="<?php echo IMG_URL; ?>/placeholder_lightblue.png" style="width: 20px; border-radius: 30%" class="align-self-center mr-2" alt="placeholder" >
					<div class="media-body">
						<p class="mb-0" style="font-weight: bold; font-size: 1.2rem;">Search</p>
					</div>
				</div>
				
				<form class="form-inline" method="post" id="formSearch">
					<div class="form-group">
						<label class="my-1 ml-3" for="inputFromDate">대상 기간 : </label>
						<input type="text" class="form-control mx-sm-2" id="inputFromDate" name="inputFromDate" placeholder="From"> ~ 
						<input type="text" class="form-control mx-sm-2" id="inputToDate" name="inputToDate" placeholder="To">
					</div>

					<input type="button" class="btn btn-primary my-1 ml-4" value="Search" id="btnSearch">
				</form>
			</div>
		
			<!-- List -->
			<div class="my-3 p-3 bg-white rounded shadow-sm" id="divList">
				<div class="media mb-3 no-print">
					<img src="<?php echo IMG_URL; ?>/placeholder_lightblue.png" style="width: 20px; border-radius: 30%" class="align-self-center mr-2" alt="" >
					<div class="media-body">
						<p class="mb-0" style="font-weight: bold; font-size: 1.2rem;">일자별 매출 현황</p>
					</div>
					<div id="divBtnUp"></div>
				</div>
				
				<div class="progress" id="loader">
					<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 1%" id="progressbar"></div>
				</div>
				
				<div id="divTable" class="section1">
					<table class="table table-hover table-sm table-responsive-md" id="tableList" >
						<thead class="thead-light">
							<tr>
								<th scope="col">Date</th>
								<th scope="col">Sale Q'ty</th>
								<th scope="col">Price</th>
								<th scope="col">HST</th>
								<th scope="col">GST</th>
								<th scope="col">PST</th>
								<th scope="col">Amount</th>
							</tr>
						</thead>
						<tbody>
							<tr><td colspan="7" style="text-align: center; font-size: 18px;">Please search to list</td></tr>
						</tbody>
					</table>
				</div>

			</div>

		</div>
	</main>
	
	<div id="dialog"></div>
	<?php require 'application/views/_templates/util.php';?>
	<?php require 'application/views/_templates/confirmmodal.php'; ?>