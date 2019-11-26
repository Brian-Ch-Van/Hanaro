<script type="text/javascript">

/**
 * calender default set
 */
	$.datepicker.setDefaults({
	    dateFormat: 'yy-mm-dd' 		// input format - yyyyMMdd
	    ,showOtherMonths: true 
	    ,showMonthAfterYear:true	
	    ,changeYear: true
	    ,changeMonth: true
	    //,showOn: "both" 			  
	    //,buttonImage: "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif"
	    //,buttonImageOnly: true
	    //,buttonText: "날짜선택"
	    ,yearSuffix: "년"
	    ,monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'] 
	    ,monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'] 
	    ,dayNamesMin: ['일','월','화','수','목','금','토'] 
	    ,dayNames: ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'] 
	    //,minDate: "-20Y" //최소 선택일자(-1D:하루전, -1M:한달전, -1Y:일년전)
	    //,maxDate: "+1Y" //최대 선택일자(+1D:하루후, -1M:한달후, -1Y:일년후)
		//,yearRange: "-50:+1"		// 년도 range
	});

/**
 * dialog to confirm, verify
 */
    $("#dialog").dialog({
        autoOpen : false,
        title : 'Warning',
        width : "500",  
        height : "200",  
        modal : true,   
        resizeable : false,
        open: function() {
	        var item = $(this).data('item');
            var bodyText = $(this).data('bodyText');
            $(this).html(item + bodyText);
          },
        buttons : { 
            "confirm" : function() {
                $(this).dialog("close");
                $('#' + $(this).data('id')).focus();
            }
        },
        show: {
            effect: "fade",
            duration: 100
        },
        hide: { 
            effect: "fade",
            duration: 100
        }
    });	
		
</script>