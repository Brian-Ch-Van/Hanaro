<?php
/**
 *
 * @author		: BrianC
 * @create		: 2019. 7. 15.
 * @desc		: 제품 정보 모델
 *
 */

class ProductModel 
{
	function __construct($db) 
	{
		// 파라미터로 받아온 DB Connection 객체를 model class 자신의 property로 set
		$this->dbCon = $db;
			
	}
	
	// product list
	public function getProdList () 
	{
		$sql = "select top 100
					pd_cd
					, pd_name
					, (select a.pc_description from tb_productcategory a where a.pc_cd = pd_category) pd_category_name
					, pd_price1
					, pd_remark
				from tb_product";
		
		$query = $this->dbCon->prepare($sql);
		$query->execute();
		
		return $query->fetchAll();
	}
	
}