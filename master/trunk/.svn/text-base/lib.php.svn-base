<?php
date_default_timezone_set("Asia/Shanghai");

define("IS_WIN", PHP_OS == "WINNT");
$path_prefix = IS_WIN ? "file:///" : "file://";

### 头部，必须包含

if (! function_exists("analy_dir")) {
	function analy_dir ($path, $l) {
		$path = str_replace("\\", "/", $path);
		while ($l-- > 0)
			if (($pos = strrpos($path, "/")) > -1)
				$path = substr($path, 0, $pos);
	
		return $path."/";
	}
}

$top_path = analy_dir(__FILE__, 1 /* 设置当前为第几级目录 */);
include_once($top_path."lib/config.php");

### 操作

print "[".__FILE__."]: ".$top_path."\n";
print str_repeat("=", 80)."\n";

function scan_all_image ($path) {
	$list = glob('{'.$path.'/*.png, '.$path.'/*.jpg}');
	var_export($list);
}

/**
 * gbk 转 utf8
 */
function gbk_to_utf8 ($str) {
	return iconv("gbk", "utf-8", $str);
}

/**
 * utf8 转 gbk
 */
function utf8_to_gbk ($str) {
	return iconv("utf-8", "gbk", $str);
}

?>