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
$root_path = analy_dir(__FILE__, 2 /* 设置当前为第几级目录 */);
include_once($root_path."lib.php");

### 操作

$current_path = $path;

$group_dir     = "B - 帮派集会所/";
$arena_dir     = "B - 比武场/";
$holy_land_dir = "S - 守护圣地/";
$ice_fire_land_dir = "J - 决战冰火岛/";
$town_dir      = "C - 城镇/";
$multi_mission_dir = "D - 多人副本/";
$mission_dir   = "F - 副本/";
$challenge_dir = "T - 挑战关卡/";
$trial_dir     = "S - 试炼关卡/";
$shadow_dir    = "Y - 影界/";
$world_dir     = "S - 世界/";
$cross_town_dir= "K - 跨服城镇/";

$ignore_dir = array("Z - 装饰品", "J - 机关");

if (!is_dir($current_path.$town_dir)) {
	$group_dir     = gbk_to_utf8($group_dir);
	$arena_dir     = gbk_to_utf8($arena_dir);
	$holy_land_dir = gbk_to_utf8($holy_land_dir);
	$ice_fire_land_dir = gbk_to_utf8($ice_fire_land_dir);
	$town_dir      = gbk_to_utf8($town_dir);
	$multi_mission_dir = gbk_to_utf8($multi_mission_dir);
	$mission_dir   = gbk_to_utf8($mission_dir);
	$challenge_dir = gbk_to_utf8($challenge_dir);
	$trial_dir     = gbk_to_utf8($trial_dir);
	$shadow_dir    = gbk_to_utf8($shadow_dir);
	$world_dir     = gbk_to_utf8($world_dir);
	$cross_town_dir= gbk_to_utf8($cross_town_dir);

	
	$len = count($ignore_dir);
	for ($i = 0; $i < $len; $i++) {
		$ignore_dir[$i] = gbk_to_utf8($ignore_dir[$i]);
	}
}

$group_dir     = $current_path.$group_dir;
$arena_dir     = $current_path.$arena_dir;
$holy_land_dir = $current_path.$holy_land_dir;
$ice_fire_land_dir = $current_path.$ice_fire_land_dir;
$town_dir      = $current_path.$town_dir;
$multi_mission_dir   = $current_path.$multi_mission_dir;
$mission_dir   = $current_path.$mission_dir;
$challenge_dir = $current_path.$challenge_dir;
$trial_dir     = $current_path.$trial_dir;
$shadow_dir    = $current_path.$shadow_dir;
$world_dir     = $current_path.$world_dir;
$cross_town_dir= $current_path.$cross_town_dir;

$dirs = array(
    $group_dir,
    $arena_dir,
    $holy_land_dir,
    $ice_fire_land_dir,
    $town_dir,
    $multi_mission_dir,
    $mission_dir,
    $challenge_dir,
    $trial_dir,
    $shadow_dir,
    $world_dir,
    $cross_town_dir,
);

for ($i = 0; $i < count($dirs); $i++) {
	$temp = glob($dirs[$i]."*");
	for ($j = 0; $j < count($temp); $j++) {
		
		for ($k = 0; $k < count($ignore_dir); $k++)
			if (strpos($temp[$j], $ignore_dir[$k]) > -1)
				break;
		
		if ($k < count($ignore_dir)) continue;
		
		if (is_dir($temp[$j])) analyse($temp[$j]."/");
	}
}

function analyse ($dir) {
	global $is_win;
	
	## 主地图
	
	$base = "base.png";
	$base_path = $dir.$base;
	if (! file_exists($base_path)) {
		print (($is_win ? "找不到地图文件:" : gbk_to_utf8("找不到地图文件:")).$dir.$base."。\r\n");
		return;
	}
	
	## 读取配置文件
	
	$config = array();
	
	$base_tops_coord = "";
	$base_bottoms_name = "";
	
	$base_txt_path = $dir."base.txt";
	if (file_exists($base_txt_path)) {
		$base_txt = file_get_contents($base_txt_path);
		$arr = explode("\r\n", $base_txt);
		
		for ($i = 0; $i < count($arr); $i++) {
			$item = $arr[$i];
			$temp = explode("|||", $arr[++$i]);
			
			if ($item == "[size]") {
				$config[] = "[size]\r\n".$temp[0];
			}
			elseif ($item == "[base_tops_coord]") {
				if (count($temp) == 2 && my_hash($temp[0]) == $temp[1]) {
					$base_tops_coord = $temp[0];
				}
				else {
					$base_tops_coord = "";
				}
			}
			elseif ($item == "[base_bottoms_name]") {
				if ($arr[$i] != "" && my_hash($temp[0]) == $temp[1]) {
					$base_bottoms_name = $temp[0];
				}
				else {
					$base_bottoms_name = "";
				}
			}
			elseif ($item == "[start_point]") {
				$config[] = "[start_point]\r\n".$temp[0];
			}
			elseif ($item == "[paths_compress]") {
				$config[] = "[paths]\r\n".$temp[0];
			}
			else if ($item == "[gear]") {
				$config[] = "[gear]\r\n".$temp[0];
			}
		}
	}
	
	$tops = array();
	$tops_coord = array();
	$bottoms_name = array();
	
	if ($base_tops_coord != "") {
		$base_tops_coord = explode(";", $base_tops_coord);
		for ($i = 0; $i < count($base_tops_coord); $i++) {
			$temp = explode(":", $base_tops_coord[$i]);
			if (file_exists($dir.$temp[0])) {
				$tops[] = $temp[0];
				$tops_coord[] = explode(",", $temp[1]);
			}
		}
	}
	
	if ($base_bottoms_name != "")
		$bottoms_name = explode(";", $base_bottoms_name);
	
	#var_export($tops);
	#var_export($tops_coord);
	#var_export($bottoms_name);
	#print "\n\n";
	
	## 创建jsfl, as类
	$content_path = create_jsfl($dir, $base, $tops, $bottoms_name);
	$content_path = create_as($dir, $base, $tops, $tops_coord, $bottoms_name);
	
	## 创建config.txt
	
	file_put_contents($content_path."config.txt", join("\r\n", $config));
}

function create_content ($dir) {
	global $current_path;
	
	$content_path = $current_path."map_fruits/";
	
	if (! is_dir($content_path)) mkdir($content_path, 0777);
	
	return $content_path;
}

function create_jsfl ($dir, $base, $tops, $bottoms_name) {
	global $current_path, $path_prefix;
	
	$content_path = create_content($dir);
	
	$content_path = $content_path.str_replace($current_path, "", $dir);
	if (! is_dir($content_path)) {
		mkdir($content_path, 0777, true);
	}
	
	$list = array();
	$list[] = "\"".replace_backslash($dir.$base)."\"";
	
	for ($i = 0; $i < count($tops); $i++) {
		$list[] = "\"".replace_backslash($dir.$tops[$i])."\"";
	}
	
	for ($i = 0; $i < count($bottoms_name); $i++) {
		$list[] = "\"".replace_backslash($dir.$bottoms_name[$i])."\"";
	}
	
	$has_war = file_exists($path_prefix.$dir."war.png");
	$has_name = file_exists($path_prefix.$dir."name.png");
	
	var_export($list);
	print "\n";
	
	$jsfl = '
var path = "'.$content_path.'";
var list = ['.join(",\n", $list).']

fl.createDocument();
var dom = fl.getDocumentDOM();
dom.docClass = "Map";

dom.sourcePath = "./;'.$content_path.'";

for (var i = 0; i < list.length; i++) {
	dom.importFile("'.$path_prefix.'" + list[i], true);
}

var items = dom.library.items;
for (var i = 0; i < items.length; i++) {
	item = items[i];
	
	item.compressionType = "photo";
	item.quality = item.name == "base.png" ? 70 : 40;
	
	item.linkageExportForAS = true;
	item.linkageExportInFirstFrame = true;
	item.linkageClassName = item.name.replace(".png", "");
	item.linkageBaseClass = "flash.display.BitmapData";
}

dom.exportSWF("'.$path_prefix.'" + path + "map.swf", true);

fl.trace(path + "map.swf" + " ok");

fl.closeDocument(dom, false);

/// mini

fl.createDocument();
var dom = fl.getDocumentDOM();

var file = "'.$path_prefix.$dir."mini.png".'";

dom.importFile(file, true);

items = dom.library.items;
var item = items[0];

item.compressionType = "photo";
item.quality = 70;

dom.addItem({x : 0, y : 0}, item);

dom.selectAll();
dom.selection[0].x = 0;
dom.selection[0].y = 0;

dom.exportSWF("'.$path_prefix.$content_path."mini.swf".'");

fl.trace("'.$path_prefix.$content_path.'mini.swf ok");

fl.closeDocument(dom, false);

/// war background

if ('.($has_war ? "true" : "false").') {
	fl.createDocument();
	var dom = fl.getDocumentDOM();
	
	var file = "'.$path_prefix.$dir."war.png".'";
	
	dom.importFile(file, true);
	
	items = dom.library.items;
	var item = items[0];
	
	item.compressionType = "photo";
	item.quality = 70;
	
	dom.addItem({x : 0, y : 0}, item);
	
	dom.selectAll();
	dom.selection[0].x = 0;
	dom.selection[0].y = 0;
	
	dom.exportSWF("'.$path_prefix.$content_path."war.swf".'");
	
	fl.trace("'.$path_prefix.$content_path.'war.swf ok");
	
	fl.closeDocument(dom, false);
}


/// town name

if ('.($has_name ? "true" : "false").') {
	fl.createDocument();
	var dom = fl.getDocumentDOM();
	
	var file = "'.$path_prefix.$dir."name.png".'";
	
	dom.importFile(file, true);
	
	items = dom.library.items;
	var item = items[0];
	
	item.compressionType = "photo";
	item.quality = 70;
	
	dom.addItem({x : 0, y : 0}, item);
	
	dom.selectAll();
	dom.selection[0].x = 0;
	dom.selection[0].y = 0;
	
	dom.exportSWF("'.$path_prefix.$content_path."name.swf".'");
	
	fl.trace("'.$path_prefix.$content_path.'name.swf ok");
	
	fl.closeDocument(dom, false);
}
';
	
	file_put_contents($content_path."map.jsfl", IS_WIN ? $jsfl : utf8_to_gbk($jsfl));
	
	return $content_path;
}

function create_as ($dir, $base, $tops, $tops_coord, $bottoms_name) {
	global $current_path;
	
	##
	
	$content_path = create_content($dir);
	
	$content_path = $content_path.str_replace($current_path, "", $dir);
	if (! is_dir($content_path)) {
		mkdir($content_path, 0777, true);
	}
	
	##
	
	$bottoms = array();
	for ($i = 0; $i < count($bottoms_name); $i++) {
		$bottoms[] = "new ".replace_png($bottoms_name[$i]);
	}
	
	for ($i = 0; $i < count($tops); $i++) {
		$tops[$i] = "new ".replace_png($tops[$i]);
	}
	
	$tops_alpha = array();
	
	for ($i = 0; $i < count($tops_coord); $i++) {
		$tops_alpha[$i] = array_pop($tops_coord[$i]);
		$tops_coord[$i] = "new Point(".join(",", $tops_coord[$i]).")";
	}

	$class = 'package
{
import flash.display.BitmapData;
import flash.display.Sprite;
import flash.geom.Point;
import flash.utils.ByteArray;

/**
 * 地图层次布局
 *
 * |---------------- childIndex = numChildren --------|
 * |
 * |
 * roleLayer ----- roles, npcs, portals, mapTops -----|
 * |
 * |
 * baseLayer --------------- mapBases ----------------|
 * |
 * |
 * bottomLayer ------------ mapBottoms ---------------|
 * |
 * |
 * |--------------------- childIndex ＝ 0 ------------|
 */
public class Map extends Sprite
{
	/**
	 * 远景图
	 */
	public var mapBottoms : Vector.<BitmapData> = Vector.<BitmapData>([
		'.join(",", $bottoms).'
	]);
	
	/**
	 * 主地图
	 */
	public var mapBase : BitmapData = new base;
	
	/**
	 * 近景图
	 */
	public var mapTops : Vector.<BitmapData> = Vector.<BitmapData>([
		'.join(",", $tops).'
	]);
	
	/**
	 * 近景图坐标
	 */
	public var mapTopsCoord : Vector.<Point> = Vector.<Point>([
		'.join(",", $tops_coord).'
	]);

	/**
	 * 近景图是否启用半透明
	 */
	public var mapTopsAlpha : Vector.<Boolean> = Vector.<Boolean>([
		'.join(",", $tops_alpha).'
	]);
}
}';
	
	file_put_contents($content_path."Map.as", $class);
	
	return $content_path;
}

function my_hash ($str) {
	return md5($str."ring");
}

function replace_png ($name) {
	return str_replace(".png", "", $name);
}

function replace_backslash ($str) {
	return str_replace("\\", "/", $str);
}
?>