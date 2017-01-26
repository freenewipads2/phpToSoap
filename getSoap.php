<?php
require_once("soapClient.php");
if(!empty($_GET['FirstName'])){
  $FirstName = $_GET['FirstName'];
} else {
  die('Missing parameter: FirstName');
}

if(!empty($_GET['LastName'])){
  $LastName = $_GET['LastName'];
} else {
  die('Missing parameter: LastName');
}

//Call
//localhost/getSoap.php?FirstName=example&LastName=example
$user = new soapClient($FirstName,$LastName);
?>
