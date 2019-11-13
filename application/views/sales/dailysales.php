
	<script type="text/javascript">
		$(document).ready(function () {

		    $('form').attr('autocomplete','off');

			$('#btnSearch').on('click', function (e){
			    e.preventDefault();

			    $('#divList p').text('일자별 매출 현황');
			    $('#btnDaily').hide();
			    
		    	var formData = $('#formSearch').serialize(true);
		    	// form 입력 data 확인
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

		    	$.ajax({
			    	url			: '<?php echo URL;?>/sales/getDailySales/', 
			    	type		: 'post',
			    	data		: formData, 
			    	dataType	: 'json',
			    	success		: function (result) {
			    	    if(result.success == true) {
							$('#divTable').html(result.data);

							// sum column
							var totals=[0,0,0,0,0,0];
							var $dataRows=$("#tableDailySalesList tr[name='trDailySalesList']");

							$dataRows.each(function() {
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
					    //alert("Error Occur : \n code = "+ jqXHR.status + "\n status = " + jqXHR.statusText + "\n message = \n" + jqXHR.responseText);
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

			// dblclick list for detail
			$("#divTable").on("dblclick", "tr[name='trDailySalesList']", getSalesByDate);
			$("#divTable").on("dblclick", "tr[name='trDailySalesByDate']", getSalesByType);

			// list by date
			function getSalesByDate (event) {
			 	// event.data 없으면 call form up button
				if(isEmpty(event.data)) {	
					schDateDay = $(this).find('td:nth-child(1)').text();
					schDate = schDateDay.split(',')[0];
				} 
				
				$.ajax({
					url			: '<?php echo URL; ?>/sales/getDailySalesByDate/',
					type		: 'post',
					data		: { byDate : schDate},
					dataType	: 'json',
					success		: function (result) {
			    	    if(result.success == true) {
			    	        $('#divList p').text('매출 현황 : ' + schDateDay);
							$('#divBtnUp').html('<input type="button" class="btn btn-sm btn-outline-info" value="Daily" id="btnDaily">');
			    	        
							$('#divTable').html(result.data);

							// sum column
							var totals=[0,0,0,0,0,0];
							var $dataRows=$("#tableDailySalesByDate tr[name='trDailySalesByDate']");

							$dataRows.each(function() {
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
				if(isEmpty(event.data)) {	// event.data 없으면 up button에서 call
				    schCode = $(this).find('td:nth-child(1)').text();
				    schType = $(this).find('td:nth-child(2)').text();
				}
				
			    $.ajax({
					url			: '<?php echo URL; ?>/sales/getDailySalesByType/',
					type		: 'post',
					data		: { 
									byDate : schDate,
									byType : schCode
									},
					dataType	: 'json',
					success		: function (result) {
			    	    if(result.success == true) {
			    	        $('#divList p').text(schDate + ' : ' + schCode + ' ' + schType);
							$('#divBtnUp').html('<input type="button" class="btn btn-sm btn-outline-info" value="By date" id="btnByDate">');
			    	        
							$('#divTable').html(result.data);

							// sum column
							var totals=[0,0,0,0,0,0];
							var $dataRows=$("tr[name='trDailySalesByType']");

							$dataRows.each(function() {
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
									byDate : schDate,
									byPtype : schPtype
									},
					dataType	: 'json',
					success		: function (result) {
			    	    if(result.success == true) {
			    	        $('#divList p').text(schDate + ' : ' + schPtype + ' ' + schPname);
							$('#divBtnUp').html('<input type="button" class="btn btn-sm btn-outline-info" value="By type" id="btnByType">');
			    	        
							$('#divTable').html(result.data);

							// sum column
							var totals=[0,0,0,0,0,0];
							var $dataRows=$("tr[name='trDailySalesByTypeDetail']");

							$dataRows.each(function() {
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

			// up button 
			$(document).on('click', '#btnDaily', function () {
			    $('#btnSearch').trigger('click');											// up to daily list
			});
			$(document).on('click', '#btnByDate', {from : "btnByDate"}, getSalesByDate);	// up to list by date
			$(document).on('click', '#btnByType', {from : "btnByType"}, getSalesByType);	// up to list by type
			
			// calendar
            $("#inputFromDate").datepicker({yearRange: "-1:+0"});
            $("#inputToDate").datepicker({yearRange: "-1:+0"});
			
		})

	</script>

	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h2 class="mt-4" style="font-weight: bold;">일별 판매 내역</h2>
			
			<!-- Search -->
			<div class="my-3 p-3 rounded shadow-sm" style="background-color: #dfebf7;">
				<div class="media mb-3">
					<img src="<?php echo IMG_URL; ?>/placeholder_lightblue.png" style="width: 20px; border-radius: 30%" class="align-self-center mr-2" alt="placeholder" >
					<div class="media-body">
						<p class="mb-0" style="font-weight: bold; font-size: 1.2rem;">Search</p>
					</div>
				</div>
				
				<form method="post" id="formSearch">
					<div class="form-row align-items-center">
						<label class="ml-4 mr-2" for="inputFromDate">대상 기간 : </label>
						<div class="col-auto">
							<label class="sr-only" for="inputFromDate">From</label>
							<input type="text" class="form-control mb-2" id="inputFromDate" name="inputFromDate" placeholder="From">
						</div>
						<div class="ml-3 mr-3">
							~ 
						</div>
						<div class="col-auto">
							<label class="sr-only" for="inputToDate">To</label>
							<input type="text" class="form-control mb-2" id="inputToDate" name="inputToDate" placeholder="To">
						</div>
						<div class="col-auto">
							<input type="button" class="btn btn-primary mb-2 ml-3" value="Search" id="btnSearch">
						</div>
					</div>
				</form>
			</div>
		
			<!-- List -->
			<div class="my-3 p-3 bg-white rounded shadow-sm" id="divList">
				<div class="media mb-3">
					<img src="<?php echo IMG_URL; ?>/placeholder_lightblue.png" style="width: 20px; border-radius: 30%" class="align-self-center mr-2" alt="" >
					<div class="media-body">
						<p class="mb-0" style="font-weight: bold; font-size: 1.2rem;">일자별 매출 현황</p>
					</div>
					<div id="divBtnUp"></div>
				</div>
				
				<div id="divTable">
					<table class="table table-hover table-sm table-responsive-md" id="tableDailySalesList">
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