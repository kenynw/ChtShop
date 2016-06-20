<?php
require_once "getSdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();
print_r ($signPackage);
?>