<?php
// bq[2HG1uwkuX7q(0

$is_hosted= false;
$protocol= ($is_hosted)? "https":"http";
$force_https= ($protocol==='https')? true: false;


$mysqli = new mysqli("localhost","root","","restapi");
if($mysqli->connect_errno>0)
{
    die('Server Error');
}

?>