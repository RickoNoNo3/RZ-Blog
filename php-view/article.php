<?php
# 2020 Jan. 26th
# @Author RickoNoNo3
# ------------------------- WARNING --------------------------
#  THIS PHP SCRIPT CAN ONLY RUN IN SYSTEM CALL MODEL !!
#    ARGS CAN ONLY BE RECEIVED FROM SYSTEM EXEC
#    AND THE OUTPUT STREAM SHOULD BE STDOUT !!
#  IT'S USED BY GOLANG BACKEND SERVER.
#
# @Param $argv[1] => A filename related to $FILELOC(in config.php)

require_once(dirname(__FILE__) . '/html/artView.php');
require_once(dirname(__FILE__) . '/lib/md.php');

LoadArtViewHeader(ArtTitle($argv[1]));

if (isset($argv[1])) {
	$file = @file_get_contents($argv[1]);
	MdParser($argv[1]);
} else {
	echo 'Wrong Arguments';
}
LoadArtViewFooter();
