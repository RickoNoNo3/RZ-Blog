<?php
# 2020 Jan. 26th
# @Author RickoNoNo3

require_once(dirname(__FILE__) . '/lib/md.php');

$file = @file_get_contents('php://input');
$mdParser = new Parsedown();
echo $mdParser->text($file);
