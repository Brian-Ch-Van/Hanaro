/**
 * 
 * @author      : BrianC
 * @create      : 2019. 9. 12.
 * @desc        : common js
 *
 */

    /**
     * -------------------------------------------------
     * 문자열이 빈 값인지 체크
     * [],{} 값도 빈값으로 체크, !value 체크로는 셀 수 있는 오류 방지
     * -------------------------------------------------
     * @param str
     * @returns
     */
    function isEmpty(str) {
        
        if( str == "" || str == null || typeof str == undefined || ( str != null && typeof str == "object" && !Object.keys(str).length )) {
            return true;
        } else {
            return false
        }
    }
    
    /**
     * -------------------------------------------------
     * 비밀번호 유효성 체크
     * -------------------------------------------------
     * @param pw
     * @returns
     */    
    function validPassword(pw) {
        var passRule = /^[A-Za-z0-9]{6,13}$/;   //숫자, 문자/ 6~13자리, 대소문자 구분
        
        if(!passRule.test(pw)) {
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * -------------------------------------------------
     * 전화번호 format check, 자동 변환
     * -------------------------------------------------
     * @param event object
     * @returns
     */  
    function phoneNoFormat(e) {
        var inPhNo = $(this).val();
        $(this).attr('maxlength', 12);

        var regNum = /^[0-9]*$/;
        if(!regNum.test(inPhNo)) {
            $(this).val(inPhNo.replace(/[^0-9]/g,""));
        }
        
        var outPhNo = $(this).val().replace(/(^[0-9]{3})([0-9]{3})([0-9]+)/, "$1-$2-$3");
        $(this).val(outPhNo);
    }
    
    /**
     * -------------------------------------------------
     * email format check
     * -------------------------------------------------
     * @param input
     * @returns boolean
     */
    function isValidEmail(email){
        var format = /^((\w|[\-\.])+)@((\w|[\-\.])+)\.([A-Za-z]+)$/;
        
        if (format.test(email)){    // 포맷이 맞으면
            return true;
        }
     
        return false;
    }
    
    /**
     * -------------------------------------------------
     * 공백제거, toUpperCase
     * -------------------------------------------------
     * @param str
     * @returns
     */
    function replaceUpper(inStr) {
        var outStr = inStr.replace(' ', '').toUpperCase();
        
        return outStr;
    }
    
    /**
     * -------------------------------------------------
     * table list sorting
     * -------------------------------------------------
     * @param sorting column index, table ID
     * @returns
     */
    function sortTable(n, tableId) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById(tableId);
        switching = true;
        dir = "asc"; 
        
        while (switching) {
            switching = false;
            rows = table.rows;

            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
    
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch= true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount ++;      
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }   // end while
    }    
    
    /**
     * -------------------------------------------------
     * number format
     * -------------------------------------------------
     * @param number
     * @returns formatted number - 1234.56 -> 1,234.56
     */
    function formatNumber(num) {
        return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }
    
    /**
     * -------------------------------------------------
     * get today format
     * -------------------------------------------------
     * @param 
     * @returns today - yyyy-mm-dd, 2019-01-01
     */
    function getToday () {
        var date  = new Date();
        var today = date.getFullYear() + "-" + ("0"+(date.getMonth()+1)).slice(-2) + "-" + ("0"+date.getDate()).slice(-2);
        
        return today;
    }
    
    
    