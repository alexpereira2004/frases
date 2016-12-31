<?php
	echo 'consumo';
	
	$url = "http://10.10.10.29:82/biblioteca/restexample/RestController.php?view=all";
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	curl_setopt($ch, CURLOPT_URL,$url);
	
	$ret = curl_exec($ch);
	
	print_r('<pre>');
	//print_r($ret);
	print_r('</pre>');
			
	curl_close($ch);
?>