<?php
	$link = mysql_connect('localhost', 'root', 'mylunacom');
      
	if (!$link) {
		die('N�o foi poss�vel conectar: ' . mysql_error());
	}else {
            
            mysql_select_db("bravo_v1", $link);
            //mysql_select_db("db_lv", $link);
        }
        
?>