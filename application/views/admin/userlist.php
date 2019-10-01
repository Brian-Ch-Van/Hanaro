<style>
	th {
	  cursor: pointer;
	}
</style>

	<main role="main" class="flex-shrink-0">
	
		<div class="container">
			<h2 class="mt-4" style="font-weight: bold;">사용자 목록</h2>
			<input type="text" id="inputSch" onkeyup="searchList()" placeholder="Search for names.." title="이름을 입력하세요">
			
			<table class="table table-hover table-dark table-sm" id="tableUserList">
				<thead>
					<tr>
						<th scope="col" onclick="sortTable(0)">ID</th>
						<th scope="col" onclick="sortTable(1)">이름</th>
						<th scope="col" onclick="sortTable(2)">영문이름</th>
						<th scope="col" onclick="sortTable(3)">영문성</th>
						<th scope="col" onclick="sortTable(4)">직원번호</th>
						<th scope="col" onclick="sortTable(5)">이메일</th>
						<th scope="col">회사</th>
						<th scope="col">직급</th>
						<th scope="col">승인여부</th>
						<th scope="col">등록일</th>
						<th scope="col">수정</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($userList as $row) {?>
					<tr>
						<td scope="row"><?php echo $row['user_id']?></td>
						<td><?php echo $row['kname']?></td>
						<td><?php echo $row['en_fname']?></td>
						<td><?php echo $row['en_lname']?></td>
						<td><?php echo $row['ep_no']?></td>
						<td><?php echo $row['email']?></td>
						<td><?php echo $row['company']?></td>
						<td><?php echo $row['position']?></td>
						<td><?php echo $row['act_yn']?></td>
						<td><?php echo date("Y-m-d", strtotime($row['rst_date']))?></td>
						<td><a class="btn-sm btn-success" href="profile/getProfInfo/<?php echo $row['user_id']?>">Edit</a></td>
					</tr>
					<?php }?>
				</tbody>
			</table>

		</div>
	</main>
	
<script>
	// 검색 - ui
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

	// sorting - param: sorting column index
	function sortTable(n) {
		var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
		table = document.getElementById("tableUserList");
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
		}	// end while
	}	
</script>	