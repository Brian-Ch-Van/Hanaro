<?php 

/**
 * 
  * @desc		: 페이징 처리 클래스
  * @creator	: BrianC
  * @date		: 2019. 11. 4.
  * @Version	: 
  * @history	: 
  *
 */
class PagingDeal {
	
	public function pagingList ($totalCnt, $list, $block ) 
	{
		$page = 1;	// 현재 페이지
		if(isset($_GET['page']) && !empty($_GET['page'])) {
			$page = $_GET['page'];
		}
		
		// define
		$pageNum = ceil($totalCnt/$list);
		$blockNum = ceil($pageNum/$block);	
		$nowBlock = ceil($page/$block);		
		
		$startPage = ($nowBlock * $block) - ($block-1);	
		if($startPage <= 1) {
			$startPage = 1;
		}
		
		$endPage = $nowBlock * $block;		
		if($pageNum <= $endPage) {
			$endPage = $pageNum;
		}
		
		$startRow = ($page-1) * $list;		
		
		return $startRow;
	}
	
	
}



