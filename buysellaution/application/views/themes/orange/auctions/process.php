<?php	
	ob_start( 'ob_gzhandler' );	
	echo $data['callback']."(".json_encode($array).")";
	ob_end_flush();
?>
