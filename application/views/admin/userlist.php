
<style>
.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
}

.pagination a.active {
  background-color: dodgerblue;
  color: white;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
</style>

	<script type="text/javascript">
		$(document).ready(function () {

			// 빠른 검색창 enter submit 방지
			$('#inputSch').keydown( function() {
				if (event.keyCode === 13) {
					event.preventDefault();
				};
			});

			// 테이블 필드 별 tooltip 처리
			$('td').tooltip({
			    delay: { "show": 500, "hide": 100 }
			});
			
		});
	</script>

	<main role="main" class="flex-shrink-0">
		<div class="container">

			<h2 class="mt-4" style="font-weight: bold;">사용자 목록</h2>
			<form class="mb-1 pt-2 pr-2 pl-2" method="post" id="formSearch" style="background-color:#e5e8ec;" action="<?php echo URL;?>/admin/userList/">
				<input class="col-md-12" type="text" id="inputSch" onkeyup="searchList()" placeholder="빠른 검색 - 이름을 입력하세요" title="이름을 입력하세요">
				
				<div class="form-row">
					<div class="form-group col-md-3">
						<input type="text" class="form-control" id="inputName" name="inputName" placeholder="이름" value="<?php if(!empty($schData['inputName'])){echo $schData['inputName']; } ?>">
					</div>
					<div class="form-group col-md-3">
						<input type="text" class="form-control" id="inputFname" name="inputFname" placeholder="영문이름" value="<?php if(!empty($schData['inputFname'])){echo $schData['inputFname']; } ?>">
					</div>
					<div class="form-group col-md-2">
						<input type="text" class="form-control" id="inputLname" name="inputLname" placeholder="영문성" value="<?php if(!empty($schData['inputLname'])){echo $schData['inputLname']; } ?>">
					</div>
					<div class="form-group col-md-3">
						<input type="text" class="form-control" id="inputCompany" name="inputCompany" placeholder="회사" value="<?php if(!empty($schData['inputCompany'])){echo $schData['inputCompany']; } ?>">
					</div>
					<div  class="form-group col-md-1">
						<button type="submit" class="btn btn-primary" id="btnSearch">Search</button>
					</div>
				</div>
			</form>
			
			<table class="table table-hover table-dark table-sm table-responsive-md" id="tableUserList">
				<colgroup>
					<col width="6%" />
                    <col width="10%" />
					<col width="11%" />
					<col width="9%" />
					<col width="7%" />
					<col width="*" />
					<col width="11%" />
					<col width="6%" />
					<col width="7%" />
					<col width="10%" />
					<col width="5%" />
				</colgroup>
				
				<thead>
					<tr>
						<th scope="col" onclick="sortTable(0)">ID</th>
						<th scope="col" onclick="sortTable(1)">이름</th>
						<th scope="col" onclick="sortTable(2)">영문이름</th>
						<th scope="col" onclick="sortTable(3)">영문성</th>
						<th scope="col" onclick="sortTable(4)">직원번호</th>
						<th scope="col" onclick="sortTable(5)">이메일</th>
						<th scope="col" onclick="sortTable(6)">회사</th>
						<th scope="col">직급</th>
						<th scope="col">승인여부</th>
						<th scope="col">등록일</th>
						<th scope="col">수정</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($userList as $row) {?>
					<tr>
						<td scope="row" title="<?=$row['user_id']?>"><?= $row['user_id']?></td>
						<td title="<?=$row['kname']?>"><?= htmlspecialchars($row['kname'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td title="<?=$row['en_fname']?>"><?= htmlspecialchars($row['en_fname'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td title="<?=$row['en_lname']?>"><?= htmlspecialchars($row['en_lname'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td title="<?=$row['ep_no']?>"><?= htmlspecialchars($row['ep_no'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td title="<?=$row['email']?>"><?= htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td title="<?=$row['company']?>"><?= htmlspecialchars($row['company'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td title="<?=$row['position']?>"><?= htmlspecialchars($row['position'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td title="<?=$row['act_yn']?>"><?= $row['act_yn']?></td>
						<td title="<?=$row['rst_date']?>"><?= date("Y-m-d", strtotime($row['rst_date']))?></td>
						<td><a class="btn-sm btn-success" href="profile/getProfInfo/<?php echo $row['user_id']?>">Edit</a></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
			
			<div class="pagination justify-content-center mb-2">

				<a href="<?php echo URL;?>/admin/userList?page=<?=$startPage-1?>">&laquo;</a>
				
				<?php for ($p = $startPage; $p <= $endPage; $p++) {
						if ($p == $page) {
				?>
				<a href="<?php echo URL;?>/admin/userList?page=<?=$p?>" class="active"><?=$p?></a>
				<?php 	} else {?>
				<a href="<?php echo URL;?>/admin/userList?page=<?=$p?>"><?=$p?></a>
				<?php 	}
					}
				?>
				
				<a href="<?php echo URL;?>/admin/userList?page=<?=$endPage+1?>">&raquo;</a>
				
				<!-- 
				<a href="#">&laquo;</a>
				<a href="#">1</a>
				<a class="active" href="#">2</a>
				<a href="#">3</a>
				<a href="#">4</a>
				<a href="#">5</a>
				<a href="#">6</a>
				<a href="#">&raquo;</a>
				 -->
			</div>
			<!-- pagin version 2 
			<nav aria-label="paging">
				<ul class="pagination justify-content-center">
					<li class="page-item disabled">
						<span class="page-link">Previous</span>
					</li>
					<li class="page-item">
						<a class="page-link" href="#">1</a>
					</li>
					<li class="page-item active" aria-current="page">
						<span class="page-link">
							2<span class="sr-only">(current)</span>
						</span>
					</li>
						<li class="page-item">
							<a class="page-link" href="#">3</a>
						</li>
						<li class="page-item">
						<a class="page-link" href="#">Next</a>
					</li>
				</ul>
			</nav>
			-->		

		</div>
	</main>
	
<script>
	// 빠른 검색 - ui, 이름으로 검색
	function searchList () {
		var input, filter, table, tr, th, td, i, txtValue;
		input = document.getElementById("inputSch");
		filter = input.value.toUpperCase();
		table = document.getElementById("tableUserList");
		tr = table.getElementsByTagName("tr");
		
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[1];	// 한글 이름

			if (td) {
				txtValue = td.textContent || td.innerText;
				
				if (txtValue.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
				} else {
					tr[i].style.display = "none";
				}
			}       
		}
	}
	
</script>	
