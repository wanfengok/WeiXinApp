<?php
	//写入到response流
	$fout = fopen('php://output', 'w');
	fputs($fout, "please input your name:<br/>");
	fclose($fout);

	file_put_contents('php://output',"test file_put_contents<br>");

	
?>