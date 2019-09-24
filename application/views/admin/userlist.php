
	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h2 class="mt-4" style="font-weight: bold;">사용자 목록</h2>
			
			<table class="table table-hover table-dark">
				<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">이름</th>
						<th scope="col">영문이름</th>
						<th scope="col">영문성</th>
						<th scope="col">직원번호</th>
						<th scope="col">승인여부</th>
						<th scope="col">삭제여부</th>
						<th scope="col">등록일</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($userList as $row) {?>
					<tr>
						<th scope="row"><?php echo $row['user_id']?></th>
						<td><?php echo $row['kname']?></td>
						<td><?php echo $row['en_fname']?></td>
						<td><?php echo $row['en_lname']?></td>
						<td><?php echo $row['ep_no']?></td>
						<td><?php echo $row['act_yn']?></td>
						<td><?php echo $row['del_yn']?></td>
						<td><?php echo $row['rst_date']?></td>
					</tr>
					<?php }?>
				</tbody>
			</table>

		</div>
	</main>