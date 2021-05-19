<?php
print_r($argv);
define("SPACE", " ");
function calc($path, $operation) {
	$handle = fopen($path, "r");
	$positive = array();
	$negative = array();
	while (!feof($handle)) {
		$buffer = fgets($handle, 4096);
		$row = explode(" ", $buffer);
		eval("\$res = floatval(".implode($operation,$row).");");
		if($res > 0) {
			$positive[] = floatval($row[0]).SPACE.$operation.SPACE.floatval($row[1]).SPACE."=".SPACE.$res;
		} else {
			$negative[] = floatval($row[0]).SPACE.$operation.SPACE.floatval($row[1]).SPACE."=".SPACE.$res;
		}
	}
	fclose($handle);
	
	if(count($positive) > 0) {
		file_put_contents("positive.txt", implode(PHP_EOL,$positive));
	}
	if(count($negative) > 0) {
		file_put_contents("negative.txt", implode(PHP_EOL, $negative));
	}
}
calc("test.txt","*");