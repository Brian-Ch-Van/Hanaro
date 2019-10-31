<?php 
	$splitFileName = explode('\\', __FILE__); 
	require 'application/views/_templates/authvalid.php';
?>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#draggable" ).draggable();
    $( "#droppable" ).droppable({
      drop: function( event, ui ) {
        $(this).addClass( "ui-state-highlight" ).find( "p" ).html( "Success!" );
      }
    });
  } );
  </script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
  </script>

	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h1>sales/salesmain.php</h1>
			
<div id="draggable" class="ui-widget-content">
  <p>Drag Source</p>
</div>
 
<div id="droppable" class="ui-widget-header">
  <p>Drop Area </p>
</div>


		</div>
	</main>