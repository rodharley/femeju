<?php
$url = "documentos/".$_REQUEST['url'];
$file =$_REQUEST['file'];
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($file).'"'); //<<< Note the " " surrounding the file name
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($url.$file));
readfile($url.$file);
exit();
?>