<?php 

class PagingDeal {
	
	public function pagingList ($totalCnt, $list, $block ) 
	{
		$page = 1;	// 현재 페이지
		if(isset($_GET['page']) && !empty($_GET['page'])) {
			$page = $_GET['page'];
		}
		
		$pageNum = ceil($totalCnt/$list);	// 총 페이지 수
		$blockNum = ceil($pageNum/$block);	// 총 블록 수
		$nowBlock = ceil($page/$block);		// 현재 블록
		
		$startPage = ($nowBlock * $block) - ($block-1);	// 각 블록의 시작 페이지
		if($startPage <= 1) {
			$startPage = 1;
		}
		
		$endPage = $nowBlock * $block;		// 각 블록의 끝 페이지
		if($pageNum <= $endPage) {
			$endPage = $pageNum;
		}
		
		$startRow = ($page-1) * $list;		// 페이징에서 조회 할 시작 row
		
		return $startRow;
	}
	
	
}



