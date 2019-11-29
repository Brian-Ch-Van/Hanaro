  
	<script type="text/javascript">

	</script>
	
		<div>
			<h2 style="font-weight: bold;">Encryption Manage</h2>
			
			<div style="width:500px; background-color: #dfebf7; padding:10;">
				<div>
					<div>
						<p style="font-weight: bold; font-size: 1.2rem;">Input Text</p>
					</div>
				</div>
				
				<form method="post" id="formInfo" action="<?php echo URL; ?>/system/getEncrypted/">
					<div>
						<div style="padding: 10;">
							<label for="inputPlainText">Plain Text : </label>
							<input type="text" style="font-size: 20px; padding: 3;" id="inputPlainText" name="inputPlainText" placeholder="Text">
						</div>
						<div style="padding: 10;">
							<label for="inputEncrypted">Encrypted : </label>
							<input type="text" style="font-size: 20px; padding: 3;" id="inputEncrypted" name="inputEncrypted" placeholder="Encrypted" >
						</div>
					</div>
					
					<div style="padding: 10;">
						<button type="submit" id="btnSave" style="width: 100px; height: 30px;">Check</button>
					</div>
				</form>
			</div>
		</div>
	
