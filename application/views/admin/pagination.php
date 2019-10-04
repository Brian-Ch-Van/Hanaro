<?php
$data = mysql_query("SELECT no FROM list ORDER BY no DESC");
$num = mysql_num_rows($data);

$page = ($_GET['page'])?$_GET['page']:1;
$list = 10;
$block = 3;

$pageNum = ceil($num/$list); // 총 페이지
$blockNum = ceil($pageNum/$block); // 총 블록
$nowBlock = ceil($page/$block);

$s_page = ($nowBlock * $block) - 2;
if ($s_page <= 1) {
	$s_page = 1;
}
$e_page = $nowBlock*$block;
if ($pageNum <= $e_page) {
	$e_page = $pageNum;
}


echo "현재 페이지는".$page."<br/>";
echo "현재 블록은".$nowBlock."<br/>";

echo "현재 블록의 시작 페이지는".$s_page."<br/>";
echo "현재 블록의 끝 페이지는".$e_page."<br/>";

echo "총 페이지는".$pageNum."<br/>";
echo "총 블록은".$blockNum."<br/>";

for ($p=$s_page; $p<=$e_page; $p++) {
	?>

    <a href="<?=$PHP_SELP?>?page=<?=$p?>"><?=$p?></a>

<?php
}
?>
<div>
    <a href="<?=$PHP_SELP?>?page=<?=$s_page-1?>">이전</a>
    <a href="<?=$PHP_SELP?>?page=<?=$e_page+1?>">다음</a>
</div>


<?php
$s_point = ($page-1) * $list;


$real_data = mysql_query("SELECT * FROM TB_USMNF ORDER BY rst_date DESC LIMIT $s_point,$list");

for ($i=1; $i<=$num; $i++) {
    $fetch = mysql_fetch_array($real_data);
?>

    <div>
        <?= $fetch['list_no'] ?>
    </div>

<?php
    if ($fetch == false) {
        exit;
    }
}
?>

