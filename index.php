<?php
session_start();
$base_dir=rtrim(str_replace('\\', '/', __DIR__),'/');
require "config.php";
require "route.php";
$ob=new Route();
$ob->doRoute();
?>