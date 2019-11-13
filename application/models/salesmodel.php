<?php 

/**
 * 
  * @desc		: Sales 관련 DB Model
  * @creator	: BrianC
  * @date		: 2019. 11. 7.
  * @Version	: 
  * @history	: 최초 생성
  *
 */
Class SalesModel {
	
	function __construct($db) 
	{
		$this->dbCon = $db;
		
		$this->loginUserId = $_SESSION['user_id'];
	}
	

	/**
	 * 
	  * @Method Name	: selDailySales
	  * @desc			: 일별 판매 내역 조회 - with 절은 기존 Hanaro 쿼리 사용
	  * @creator		: BrianC
	  * @date			: 2019. 11. 7.
	  * @return 
	 */
	public function selDailySales ($srchDate) 
	{
		$sql = "with ds as (
					SELECT 
						tProd, tDate, prodName, prodKname, pName, ptCode as pCode, pType, ptName,  
						SUM(tQty) AS tQty, SUM(CASE WHEN tType = '22' AND tFree = 1 THEN 0 ELSE tAmt END) AS tAmt,  
						SUM(tGst) AS tGst, SUM(tPst) AS tPst, SUM(tHst) AS tHst  
					FROM (vw_tfTran LEFT JOIN vw_mfProd ON tProd = prodId) LEFT JOIN vw_mfPtype ON tPtype = pType  
					WHERE tDate BETWEEN :fromDate And :toDate  
						AND tType NOT IN ('31','33','34','35')  
					GROUP BY tDate, ptCode, pType, tProd, prodName, prodKname, pName, ptName
				)
				select 
					tDate						ds_date
					, round(sum(tQty), 2)		ds_qty
					, round(sum(tAmt), 2)		ds_amt
					, round(sum(tHst), 2)		ds_hst
					, round(sum(tGst), 2)		ds_gst
					, round(sum(tPst), 2)		ds_pst
					, round(sum(tAmt)+sum(tHst)+sum(tGst)+sum(tPst), 2)	ds_totalAmt
				from ds
				group by tDate
				order by tDate
				";
		
		$query = $this->dbCon->prepare($sql);
		
		$query->bindValue(':fromDate', $srchDate['inputFromDate']);
		$query->bindValue(':toDate', $srchDate['inputToDate']);
		$query->execute();
		
		return $query->fetchAll();
	}
	
	/**
	 * 
	  * @Method Name	: selDailySalesByDate
	  * @desc			: 일별 판매 내역 조회 > 해당 날짜 상세 - with 절은 기존 Hanaro 쿼리 사용(날짜 조건만 변경)
	  * @creator		: BrianC
	  * @date			: 2019. 11. 8.
	  * @return 
	 */
	public function selDailySalesByDate ($date)
	{
		$sql = "with ds as (
					SELECT 
						tProd, tDate, prodName, prodKname, pName, ptCode as pCode, pType, ptName,  
						SUM(tQty) AS tQty, SUM(CASE WHEN tType = '22' AND tFree = 1 THEN 0 ELSE tAmt END) AS tAmt,  
						SUM(tGst) AS tGst, SUM(tPst) AS tPst, SUM(tHst) AS tHst  
					FROM (vw_tfTran LEFT JOIN vw_mfProd ON tProd = prodId) LEFT JOIN vw_mfPtype ON tPtype = pType  
					WHERE tDate = :date
						AND tType NOT IN ('31','33','34','35')  
					GROUP BY tDate, ptCode, pType, tProd, prodName, prodKname, pName, ptName
				)
				select 
					tDate			ds_date
					, pCode			ds_pcode
					, ptName		ds_ptname
					, round(sum(tQty), 2)		ds_qty
					, round(sum(tAmt), 2)		ds_amt
					, round(sum(tHst), 2)		ds_hst
					, round(sum(tGst), 2)		ds_gst
					, round(sum(tPst), 2)		ds_pst
					, round(sum(tAmt)+sum(tHst)+sum(tGst)+sum(tPst), 2)	ds_totalAmt
				from ds
				group by tDate, pCode, ptName
				order by pCode
				";
		
		$query = $this->dbCon->prepare($sql);
		
		$query->bindValue(':date', $date);
		$query->execute();
		
		return $query->fetchAll();
	}
	
	/**
	 * 
	  * @Method Name	: selDailySalesByType
	  * @desc			: 일별 판매 내역 조회 - Type 별 - with 절은 기존 Hanaro 쿼리 사용(날짜 조건/ptCode 조건만 변경)
	  * @creator		: BrianC
	  * @date			: 2019. 11. 12.
	  * @param  $type
	  * @return 
	 */
	public function selDailySalesByType ($date, $type)
	{
		$sql = "with ds as (
					SELECT 
						tProd, tDate, prodName, prodKname, pName, ptCode as pCode, pType, ptName,  
						SUM(tQty) AS tQty, SUM(CASE WHEN tType = '22' AND tFree = 1 THEN 0 ELSE tAmt END) AS tAmt,  
						SUM(tGst) AS tGst, SUM(tPst) AS tPst, SUM(tHst) AS tHst  
					FROM (vw_tfTran LEFT JOIN vw_mfProd ON tProd = prodId) LEFT JOIN vw_mfPtype ON tPtype = pType  
					WHERE tDate = :date
						AND tType NOT IN ('31','33','34','35')  
						and ptCode = :type
					GROUP BY tDate, ptCode, pType, tProd, prodName, prodKname, pName, ptName
				)
				select 
					tDate						ds_date
					, pType						ds_ptype
					, pName						ds_pname
					, round(sum(tQty), 2)		ds_qty
					, round(sum(tAmt), 2)		ds_amt
					, round(sum(tHst), 2)		ds_hst
					, round(sum(tGst), 2)		ds_gst
					, round(sum(tPst), 2)		ds_pst
					, round(sum(tAmt)+sum(tHst)+sum(tGst)+sum(tPst), 2)	ds_totalAmt
				from ds
				group by tDate, pType, pName
				order by pName
				";
		
		$query = $this->dbCon->prepare($sql);
		
		$query->bindValue(':date', $date);
		$query->bindValue(':type', $type);
		$query->execute();
		
		return $query->fetchAll();
	}
	
	/**
	 * 
	  * @Method Name	: selDailySalesByTypeDetail
	  * @desc			: 일별 판매 내역 - 해당 타입 상세 - with 절은 기존 Hanaro 쿼리 사용(날짜 조건/pType 조건만 변경)
	  * @creator		: BrianC
	  * @date			: 2019. 11. 13.
	  * @param  $date
	  * @param  $ptype
	  * @return 
	 */
	public function selDailySalesByTypeDetail ($date, $ptype)
	{
		$sql = "with ds as (
					SELECT 
						tProd, tDate, prodName, prodKname, pName, ptCode as pCode, pType, ptName  
						, SUM(tQty) AS tQty, SUM(CASE WHEN tType = '22' AND tFree = 1 THEN 0 ELSE tAmt END) AS tAmt,  
						SUM(tGst) AS tGst, SUM(tPst) AS tPst, SUM(tHst) AS tHst  
					FROM (vw_tfTran LEFT JOIN vw_mfProd ON tProd = prodId) LEFT JOIN vw_mfPtype ON tPtype = pType  
					WHERE tDate = :date
						AND tType NOT IN ('31','33','34','35')  
						and pType = :ptype
					GROUP BY tDate, ptCode, pType, tProd, prodName, prodKname, pName, ptName
				)
				select
					tProd			ds_prod
					, tDate			ds_date
					, prodName		ds_prodName
					, prodKname		ds_prodKname
					, pName			ds_pname
					, pCode			ds_pcode
					, pType			ds_ptype
					, ptName		ds_ptName
					, tQty			ds_qty
					, tAmt			ds_amt
					, tHst			ds_hst
					, tGst			ds_gst
					, tPst			ds_pst
					, round(tAmt+tHst+tGst+tPst, 2)	ds_totalAmt
				from ds
				";
		
		$query = $this->dbCon->prepare($sql);
		
		$query->bindValue(':date', $date);
		$query->bindValue(':ptype', $ptype);
		$query->execute();
		
		return $query->fetchAll();
	}

	
}
