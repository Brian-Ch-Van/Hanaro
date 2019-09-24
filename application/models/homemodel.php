<?php 
/**
 *
 * @author		: BrianC
 * @create		: 2019. 7. 16.
 * @desc		: 홈 화면 모델
 *
 */

class HomeModel {
    
    function __construct($db) {
        
        $this->db = $db;
    }
    
    // 매출 조회
    public function getSales() {
    	$sql = "select
					br_cd
					, (select name from TB_BRMN a where a.cd = b.br_cd) br_name
					, sales_ym
					, sales_amt
				from tb_brsl b";
    	
    	$query = $this->db->prepare($sql);
    	$query->execute();
    	
    	return $query->fetchAll();
    }
    
}

?>