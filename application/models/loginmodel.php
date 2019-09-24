<?php 
/**
 * 
  * @desc		: 로그인 DB 모델
  * @creator	: BrianC
  * @date		: 2019. 9. 12.
  * @Version	: v1.0
  * @history	: 
  *
 */

class LoginModel {
    
    function __construct($db) {
        
        $this->dbCon = $db;
    }
    
    /**
     * 
      * @Method Name	: getUserId
      * @desc			: 사용자 아이디 채번, yymmdd+nnnn
      * @creator		: BrianC
      * @date			: 2019. 9. 13.
      * @return 
     */
    public function getUserId ()
    {
    	$sql = "	select
						CONVERT(varchar,getdate(),12) + RIGHT('0000' + CONVERT(nvarchar(4), ISNULL(case when RIGHT(MAX(user_id),4)='9999' then '1' else RIGHT(MAX(user_id),4) end ,0) + 1), 4) user_id
					from TB_USMNF";
    	
    	$query = $this->dbCon->prepare($sql);
    	$query->execute();
    	
    	return $query->fetch();
    }
    
    /**
     * 
      * @Method Name	: selEmpInfo
      * @desc			: 직원 정보 조회
      * @creator		: BrianC
      * @date			: 2019. 9. 13.
     */
    public function selEmpInfo ($empNo)
    {
    	$sql = "select 
					ep_No			empNo
					, ep_Kname		kName
					, ep_Fname		fName
					, ep_Lname		lName
					, ep_Gender 	gender
					, convert(varchar, ep_Birthday, 112)	birth	--yyyyMMdd
					, ep_TelNo		telNo
					, ep_CellNo		cellNo
				from tb_EmPloyee	
				where lower(ep_No) = lower('{$empNo}')
					and ep_edDate is null -- 재직중 ";
    	
    	$query = $this->dbCon->prepare($sql);
    	$query->execute();
    	
   		return $query->fetch();
    }
    
    /**
     * 
      * @Method Name	: insertUserInfo
      * @desc			: 사용자 정보 입력
      * @creator		: BrianC
      * @date			: 2019. 9. 18.
      * @return 
     */
    public function insertUserInfo ($data)
    {
    	$sql = "INSERT INTO TB_USMNF 
						           (USER_ID 
						           ,KNAME 
						           ,EN_FNAME 
						           ,EN_LNAME 
						           ,EP_NO 
						           ,GENDER 
						           ,BTH_YMD 
						           ,USER_PW 
						           ,PHONE_NO 
						           ,CELL_NO 
						           ,EMAIL 
						           ,ADD_STREET 
						           ,ADD_CITY 
						           ,ADD_PROVINCE 
						           ,POSTAL 
						           ,ACT_YN
								   ,DEL_YN
						           --,REMARK 
						           ,RST_USER 
						           ,RST_DATE 
						           ,LST_UPD_USER 
						           ,LST_UPD_DATE )
						     VALUES
						           (:userId
						           ,:kName
						           ,:fName
						           ,:lName
						           ,:epNo
						           ,:gender
						           ,:birth
						           ,:userPw
						           ,:phoneNo
						           ,:cellNo
						           ,:email
						           ,:addStreet
						           ,:addCity
						           ,:addProvince
						           ,:postal
						           ,'N'			-- ACT_YN
								   ,'N'			-- DEL_YN
						           --,:remark		
						           ,:rstUser	
						           , getdate()
						           ,:lstUpdUser	
						           , getdate())";
    	
    	$query = $this->dbCon->prepare($sql);
    	$query->execute(array(':userId'=>$data['inputUserId'], ':kName'=>$data['inputKname'], ':fName'=>$data['inputFname'], ':lName'=>$data['inputLname'], ':epNo'=>$data['inputEmpNo'], ':gender'=>$data['inputGender'], ':birth'=>$data['inputBirth'], ':userPw'=>$data['inputPw'], ':phoneNo'=>$data['inputPhoneNo'], ':cellNo'=>$data['inputCellNo'], ':email'=>$data['inputEmail'], ':addStreet'=>$data['inputAddStreet'], ':addCity'=>$data['inputAddCity'], ':addProvince'=>$data['inputProvince'], ':postal'=>$data['inputPostal'], ':rstUser'=>$data['inputUserId'], ':lstUpdUser'=>$data['inputUserId']));
    }
    
}

?>