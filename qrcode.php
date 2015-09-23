<?php
session_start();
include("includes/include.lockPortal.php");
include('phpqrcode/qrlib.php');
QRcode::png($_REQUEST['code'],false,4,8,2);
?>