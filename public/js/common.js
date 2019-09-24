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
        var passRule = /^[A-Za-z0-9]{6,13}$/;   //숫자, 문자/ 6~13자리
        
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
    
      
    
    