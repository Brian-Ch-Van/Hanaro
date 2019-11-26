<?php 
	$splitFileName = explode('\\', __FILE__); 
	require 'application/views/_templates/authvalid.php';
?>
<script type="text/javascript">
	$(document).ready(function () {

	    $('form').attr('autocomplete','off');

	    // default 오늘 날짜 set - yyyy-mm-dd
		$('#inputFromDate').val(getToday());
		$('#inputToDate').val(getToday());

        $("#inputFromDate").datepicker({yearRange: "-1:+0"});
        $("#inputToDate").datepicker({yearRange: "-1:+0"});

        // chart
		$('#divChart').hide();
		$('#chartTransBtn').hide();
        
		$('#btnSearch').on('click', function (e){
		    e.preventDefault();
			
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

	    	$.ajax({
		    	url			: '<?php echo URL;?>/sales/getHourlySales/', 
		    	type		: 'post',
		    	data		: formData, 
		    	dataType	: 'json',
		    	success		: function (result) {
		    	    if(result.success == true) {
		    	        $('#divBtnExport').html('<input type="button" class="btn btn-sm btn-outline-danger" value="PDF" id="btnPrintPdf"><input type="button" class="btn btn-sm btn-outline-success ml-1" value="Excel" id="btnExcel">');
		    	        $('#divChart').show();
		    	        $('#chartTransBtn').show();

		    	        $('#divTable').html(result.data);

		    	        $('#schGroup').text("조회 대상 : " + $('#selCode option:selected').text());
		    	        $('#schPeriod').text("조회 기간 : " + $('#inputFromDate').val() + " ~ " + $('#inputToDate').val());
						
						chartData(result.list);

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

        // pdf
        $(document).on('click', '#btnPrintPdf', function (){
            var oriTitle = $(document).attr('title');
			$(document).prop('title', 'Hourly Sales_' + getTodayNoHyph());
			window.print();
			$(document).attr('title', oriTitle);
        });
        
        // excel
        $(document).on('click', '#btnExcel', function (){
		    $('#formSearch').attr("action", "<?php echo URL;?>/exportfile/exportExlHourlySales/");
		    $('#formSearch').attr("method", "post");
		    $('#formSearch').submit();
        });
		
	})
</script>
 
	<main role="main" class="flex-shrink-0">
		<div class="container" >
			<h2 class="mt-4 no-print" style="font-weight: bold;">시간별 방문객/매출액</h2>
			<div class="hidden-obj" ><!-- screen hidden -->
				<img src="<?php echo IMG_URL; ?>/report_header_hmart.png" style="width: 200px;" alt="hmart-header-logo">
				<h2 style="text-align: center; margin-bottom: 40px; font-weight: bold">Hourly Sales Report</h2>
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
					
					<label class="my-1 ml-2 mr-2" for="selCode">대상 그룹 : </label>
					<select class="custom-select my-1 mr-sm-2" id="selCode" name="selCode">
						<option value="00" selected >00 전체</option>
						<?php if(!empty($ptCodeList)) { foreach ($ptCodeList as $row) {?>
						<option value=<?= $row['ptCode']?> ><?= $row['ptCode'] . ' ' . $row['ptName']?></option>
						<?php } }?>
					</select>
				
					<div class="custom-control custom-checkbox my-1 ml-2 mr-sm-2">
						<input type="checkbox" class="custom-control-input" id="chkMemberOnly" name="chkMemberOnly">
						<label class="custom-control-label" for="chkMemberOnly">Member Only</label>
					</div>
				
					<input type="button" class="btn btn-primary my-1 ml-4" value="Search" id="btnSearch">
				</form>				
			</div>
			
			<!-- Chart -->
			<div class="hidden-obj">
				<span id="schGroup" style="margin-left: 30px; font-weight: bold;"></span>
				<span id="schPeriod" style="float: right; margin-right: 20px; font-weight: bold;"></span>
			</div>
			<div class="bg-white" style="text-align: -webkit-center;">
				<div id="divChart" style="width: 1000px;"></div>
			</div>
			<div id="chartTransBtn" class="bg-white no-print" >
				<button class="btn btn-primary btn-sm mt-1 ml-2 mb-2" onClick="chType('line');">Line</button>
				<button class="btn btn-info btn-sm mt-1 mb-2" onClick="chType('bar');" >Bar</button>
				<button class="btn btn-warning btn-sm mt-1 mb-2" onClick="chType('mix');" >Mix</button>
			</div>			
			
			<!-- List -->
			<div class="my-3 p-3 bg-white rounded shadow-sm" id="divList">
				<div class="media mb-3 no-print">
					<img src="<?php echo IMG_URL; ?>/placeholder_lightblue.png" style="width: 20px; border-radius: 30%" class="align-self-center mr-2" alt="" >
					<div class="media-body">
						<p class="mb-0" style="font-weight: bold; font-size: 1.2rem;">방문객/매출액 현황</p>
					</div>
					<div id="divBtnExport"></div>
				</div>
				
				<div id="divTable" class="section1">
					<table class="table table-hover table-sm table-responsive-md" id="tableHourlySalesList" >
						<thead class="thead-light">
							<tr>
								<th scope="col">시간대</th>
								<th scope="col">고객수</th>
								<th scope="col">시간별 매출액</th>
								<th scope="col">비율</th>
								<th scope="col">객단가</th>
							</tr>
						</thead>
						<tbody>
							<tr><td colspan="5" style="text-align: center; font-size: 18px;">Please search to list</td></tr>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</main>
	
<script type="text/javascript">

	function chartData (list) {
		console.log(list);

		var xData = [];
		var ylData = [];
		var yrData = [];
		
		xData.push("Times");
		ylData.push("Visitors");
		yrData.push("Sales");

		for(var i = 0; i < list.length; i++) {
		    xData.push(parseFloat(list[i].hs_hour));
		    ylData.push(parseFloat(list[i].hs_visitor));
		    yrData.push(parseFloat(list[i].hs_paid));
		}

		var chart = "";
		callChart(xData, ylData, yrData);
	}

	// make chart
	function callChart (xData, ylData, yrData) {
		chart = bb.generate({
			data: {
				x: "Times",
				columns: [
				    xData,
				    ylData,
					yrData
				],
				axes: {
					Times	: "x",
					Visitors: "y",
					Sales	: "y2"
				}
			},
			axis: {
				x: {
					label: {
						text: "Time",
						position: "outer-center"
					}
				},
				y: {
					label: {
						text: "Visitors",
						position: "outer-middle"
					}
				},
				y2: {
					show: true,
					label: {
						text: "Sales",
						position: "outer-middle"
					}
				}
			},
			grid: {
				y: {
					show: true
				}
			},
		    bindto: "#divChart"
		});

// 		setTimeout(function() {
// 			chart.load({
// 		  		columns: [
// 		  		  yrData
// 		  		]
// 		  	});
// 		}, 500);	

// 		setTimeout(function() {
// 			chart.export("image/png", function(dataUrl) {
// 				console.log(dataUrl);
// 				// append an image element
// 				$('#divChartImg').after("<img id='chartImg'>");
// 				$('#chartImg').attr('src', dataUrl);
				
// 			});
// 		}, 500);
			
	} // end callChart

    function getCssRules(styleSheets) {
        var cssRules = [];
        styleSheets.forEach(function (sheet) {
            if (sheet.hasOwnProperty("cssRules")) {
                try {
                    util.asArray(sheet.cssRules || []).forEach(cssRules.push.bind(cssRules));
                } catch (e) {
                    console.log('Error while reading CSS rules from ' + sheet.href, e.toString());
                }
            }
        });
        return cssRules;
    }

	// Chart type change
	function chType(type){
		if("mix" == type) {
			chart.transform("spline", "Sales");
			chart.transform("bar", "Visitors");
			
		} else if ("bar" == type) {
	        chart.transform("bar");
		    
		} else if ("line" == type) {
			chart.transform("line", "Visitors");
			chart.transform("line", "Sales");
		}		
	}	

</script>	
	
	<div id="dialog"></div>
	<?php require 'application/views/_templates/util.php';?>
	<?php require 'application/views/_templates/confirmmodal.php'; ?>