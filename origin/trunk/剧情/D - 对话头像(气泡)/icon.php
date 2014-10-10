<?php

### 头部，必须包含

function analy_dir ($path, $l) {
	$path = str_replace("\\", "/", $path);
	while ($l-- > 0)
		if (($pos = strrpos($path, "/")) > -1)
			$path = substr($path, 0, $pos);
	
	return $path."/";
}

$path      = analy_dir(__FILE__, 1 /* 当前目录 */);
$root_path = analy_dir(__FILE__, 3 /* 设置当前为第几级目录 */);
include_once($root_path."lib.php");

### 操作

# 表情配置
$emotion = array(
	array("悲伤", "Sad"),
	array("怒", "Anger"),
	array("笑", "Laugh"),
);
$hash = array();
for ($i = 0; $i < count($emotion); $i++) {
	if (IS_WIN)
		$hash[iconv("utf-8", "gbk", $emotion[$i][0])] = $emotion[$i][1];
	else
		$hash[$emotion[$i][0]] = $emotion[$i][1];
}
$emotion = $hash;

$dbi = new DBI();
$dbi->connect();

$hash = array();

$records = $dbi->query('select * from `town_npc`');
$len = count($records);
for ($i = 0; $i < $len; $i++) {
	$row = $records[$i];
	$hash[IS_WIN ? iconv("utf-8", "gbk", $row["name"]) : $row["name"]] = $row["sign"];
}
$records = $dbi->query('select * from `role`');
$len = count($records);
for ($i = 0; $i < $len; $i++) {
	$row = $records[$i];
	$hash[IS_WIN ? iconv("utf-8", "gbk", $row["name"]) : $row["name"]] = $row["sign"];
}
$records = $dbi->query('select * from `enemy_role`');
$len = count($records);
for ($i = 0; $i < $len; $i++) {
	$row = $records[$i];
	$hash[IS_WIN ? iconv("utf-8", "gbk", $row["name"]) : $row["name"]] = $row["sign"];
}

$dbi -> close();

### 生成jsfl

if (! is_dir($path."swf/")) mkdir($path."swf/", 0777);

$list = glob($path.'*.png');

$from = array();
$to   = array();

$len = count($list);
for ($i = 0; $i < $len; $i++) {          
	$filename = basename(basename($list[$i], ".png"), ".jpg");
	$arr = explode("-", $filename);
	$filename = trim($arr[1]);
	
	if ($filename == "") continue;
	
	$arr = explode("_", $filename);
	$filename = $arr[0];
	
	if (array_key_exists($filename, $hash)) {
		//print $filename." ".$hash[$filename]."\n";
		//copy($list[$i], $path."swf/".$signs[$index].".png");
		
		$suffix = "";
		if (isset($arr[1]) && array_key_exists($arr[1], $emotion)) {
			$suffix = $emotion[$arr[1]];
		}
		
		$from[] = $list[$i];
		$to[]   = dirname($list[$i])."/swf/".$hash[$filename].$suffix.".swf";
		
	}
	else {
		$from[] = $list[$i];
		$to[]   = dirname($list[$i])."/swf/".$filename.".swf";
	}
}

#var_export($from);
#var_export($to);

$jsfl = '
var from = ["'.join('", '."\n".'"', $from).'"];
var to   = ["'.join('", '."\n".'"', $to).'"];

fl.createDocument();
var dom = fl.getDocumentDOM();

for (var i = 0; i < from.length; i++) {
	var items = dom.library.items;
	var len = items.length;
	for (var j = len - 1; j > -1; j--) {
		dom.library.deleteItem(items[j].name);
	}
	
	dom.importFile("'.$path_prefix.'" + from[i], true);
	
	items = dom.library.items;
	var item = items[0];
	
	item.linkageExportForAS = true;
	item.linkageExportInFirstFrame = true;
	item.linkageClassName = "IconLeft";
	item.linkageBaseClass = "flash.display.BitmapData";
	
	dom.exportSWF("'.$path_prefix.'" + to[i], true);
	
	fl.trace(to[i] + " ok");
}

fl.closeDocument(dom, false);

';

file_put_contents($path."icon.jsfl", IS_WIN ? $jsfl : iconv("utf-8", "gbk", $jsfl));
?>