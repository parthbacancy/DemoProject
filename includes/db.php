<?php ob_start();

$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "";
$db['db_name'] = "demo_app";

foreach($db as $key => $value){
define(strtoupper($key), $value);
}

$connection = mysqli_connect('localhost', 'root','','demo_app');



$query = "SET NAMES utf8";
mysqli_query($connection,$query);

// if($connection) {

// echo "We are connected";

// }
?>