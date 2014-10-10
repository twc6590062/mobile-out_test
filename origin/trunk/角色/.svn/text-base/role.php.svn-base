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

# 倒地起身
define("ARISEN", "arisen");
# 攻击
define("ATTACK", "attack");
# 被击
define("BEATEN", "beaten");
# 格挡
define("BLOCK", "block");
# 鞠躬
define("BOW", "bow");
# 抱宝箱
define("CLASP", "clasp");
# 画
define("DRAW", "draw");
# 趴
define("GROVEL", "grovel");
# 守卫
define("GUARD", "guard");
# 操作
define("HANDLE", "handle");
# 操作
define("HURT", "hurt");
# 城镇待机
define("IDLE", "idle");
# 跳跃
define("JUMP", "jump");
# 踢
define("KICK", "kick");
# 跪
define("KNEEL", "kneel");
# 笑
define("LAUGH", "laugh");
# 躺
define("LIE", "lie");
# 躺着
define("LYING", "lying");
# 采矿
define("MINING", "mining");
# 跑
define("RUN", "run");
# 坐
define("SIT", "sit");
# 坐2
define("SIT2", "sit2");
# 坐3
define("SIT3", "sit3");
# 技能
define("SKILL", "skill");
# 技能
define("SKILL2", "skill2");
# 蹲下
define("SQUAT", "squat");
# 破甲
define("SUNDER", "sunder");
# 战场待机
define("STANDBY", "standby");
# 挣扎
define("STRUGGLE", "struggle");
# 拜师
define("TRAINEE", "trainee");
# 倒地
define("TUMBLE", "tumble");
# 法术
define("MAGIC", "magic");
# 走
define("WALK", "walk");
# 胜利
define("WIN", "win");

define("BOTTOM", "bottom");
define("LEFT_BOTTOM", "left_bottom");
define("LEFT_TOP", "left_top");
define("LEFT", "left");
define("RIGHT_BOTTOM", "right_bottom");
define("RIGHT_TOP", "right_top");
define("RIGHT", "right");
define("TOP", "top");

$actions = array(
	ARISEN, ATTACK, BEATEN, BLOCK, BOW, CLASP, DRAW, GROVEL, GUARD,
	HANDLE, HURT, IDLE, JUMP, KICK, KNEEL, LAUGH, LIE, LYING, MAGIC, MINING,
	RUN, SIT, SIT2, SIT3, SKILL, SKILL2, SQUAT, STANDBY, STRUGGLE, SUNDER,
	TRAINEE, TUMBLE, WIN, WALK
);

$faces = array(
	BOTTOM, LEFT_BOTTOM, LEFT_TOP, LEFT,
	RIGHT_BOTTOM, RIGHT_TOP, RIGHT, TOP
);

$in_map = array(IDLE, RUN, WALK);
$in_war = array(
	ATTACK,
	BEATEN, BLOCK,
	GUARD,
	LAUGH,
	MAGIC,
	SKILL, SKILL2, STANDBY, SUNDER,
	WIN
);
$in_drama = array(
	ARISEN,
	BOW,
	CLASP,
	DRAW,
	GROVEL,
	HANDLE, HURT,
	JUMP,
	KICK, KNEEL,
	LIE, LYING,
	MINING,
	SIT, SIT2, SIT3, SQUAT, STRUGGLE,
	TRAINEE, TUMBLE
);

$current_path = $path;

$animal_dir  = "animal/";
$monster_dir = "monster/";
$npc_dir     = "npc/";
$player_dir  = "player/";
$pet_dir     = "pet/";

$monster_war_dir  = "monster_war/";
$player_war_dir   = "player_war/";
$ghost_shield_dir = "ghost_shield/";

$player_realm_dir = "player_realm/";

$jsfls = array();
$flash_path = '"D:\Program Files\Adobe\Adobe Flash CS5.5\Flash.exe" ';

$jsfl_content = "";

$dirs = array(
	$animal_dir,
	$monster_dir,
	$npc_dir,
	$player_dir,
	$pet_dir,
	$monster_war_dir,
	$player_war_dir,
	$ghost_shield_dir,
	$player_realm_dir
);
for ($i = 0; $i < count($dirs); $i++) {
	$temp = glob($current_path.$dirs[$i]."*");
	for ($j = 0; $j < count($temp); $j++) {
		if (is_dir($temp[$j])) analyse($temp[$j]."/");
	}
}

file_put_contents($path."role.jsfl", $jsfl_content);

#file_put_contents($current_path."role_fruits/role.bat", join("\r\n", $jsfls));

##

function analyse ($dir) {
	global $current_path, $path_prefix, $jsfls, $flash_path;
	
	global $monster_dir, $npc_dir, $player_dir, $pet_dir,
	       $monster_war_dir, $player_war_dir, $ghost_shield_dir,
	       $player_realm_dir;
	
	$is_monster = strpos($dir, $current_path.$monster_dir) === 0
	            || strpos($dir, $current_path.$monster_war_dir) === 0;
	$is_npc     = strpos($dir, $current_path.$npc_dir) === 0;
	$is_player  = strpos($dir, $current_path.$player_dir) === 0
	            || strpos($dir, $current_path.$player_war_dir) === 0;
	$is_pet     = strpos($dir, $current_path.$pet_dir) === 0;
	
	$is_realm   = strpos($dir, $current_path.$player_realm_dir) === 0;
	
	$content_path = $current_path."role_fruits/";
	
	if (! is_dir($content_path)) mkdir($content_path, 0777);
	
	$content_path = $content_path.str_replace($current_path, "", $dir);
	if (! is_dir($content_path)) {
		mkdir($content_path, 0777, true);
	}
	
	if (! is_dir($content_path."swf/")) {
		mkdir($content_path."swf/", 0777, true);
	}
	
	##
	
	global $actions, $faces;
	
	$has_standby = false;
	$has_idle = false;
	
	$classes = array();
	
	$jsfl = "";
	
	for ($i = 0; $i < count($actions); $i++) {
		$action = $actions[$i];
		$action_path = $dir.$action."/";
		
		if (! is_dir($action_path)) continue;
		
		$classnames = array();
		$pngs = array();
		$logs = array();
		
		$content_action_path = $content_path.$action."/";
		#print $content_action_path."\n";
		
		for ($j = 0; $j < count($faces); $j++) {
			$face = $faces[$j];
			
			$config_path = $action_path.$faces[$j].".txt";
			$png_path = $action_path.$faces[$j].".png";
			
			$has_config = file_exists($config_path);
			$has_png = file_exists($png_path);
			if (!$has_config || !$has_png) {
				if (!$has_config) array_push($logs, "找不到配置档：".(IS_WIN ? $config_path : utf8_to_gbk($config_path)));
				if (!$has_png) array_push($logs, "找不到角色资源：".(IS_WIN ? $png_path : utf8_to_gbk($png_path)));
				
				continue;
			}
			
			if ($action == STANDBY) $has_standby = true;
			if ($action == IDLE) $has_idle = true;
			
			array_push($pngs, "\"".$png_path."\"");
			
			if (! is_dir($content_action_path)) {
				mkdir($content_action_path, 0777, true);
			}
			
			$frames         = 0;
			$frames_repeat  = "";
			$interval       = 0;
			$name_point     = "0,0";
			$reg_point      = "0,0";
			$config_actions = "";
			
			$config = file_get_contents($config_path);
			$config = explode("\r\n", $config);
			
			for ($k = 0; $k < count($config); $k++) {
				$item = $config[$k];
				
				if ($item == "[frames]") {
					$frames = $config[++$k];
				}
				elseif ($item == "[frames_repeat]") {
					$frames_repeat = $config[++$k];
				}
				elseif ($item == "[interval]") {
					$interval = $config[++$k];
				}
				elseif ($item == "[name_point]") {
					$name_point = $config[++$k];
				}
				elseif ($item == "[reg_point]") {
					$reg_point = $config[++$k];
				}
				elseif ($item == "[actions]") {
					$config_actions = $config[++$k];
				}
			}
			
			array_push($classnames, "avatar_".$face.";");
			
			if (!array_key_exists($action, $classes))
				$classes[$action] = array();
			
			$classes[$action][$face] = array(
				$action,
				$face,
				$frames,
				$frames_repeat,
				$interval,
				$name_point,
				$reg_point,
				$config_actions
				);
			
			file_put_contents(
				$content_action_path."avatar_".$face.".as",
				gbk_to_utf8(get_as(
					$action,
					$face,
					$frames,
					$frames_repeat,
					$interval,
					$name_point,
					$reg_point,
					$config_actions
				))
			);
		}
		
		create_doc_class($content_action_path, $classnames);
		
		$jsfl = $jsfl."\n".create_jsfl($content_path, $pngs, $content_action_path, $path_prefix, $action, $classnames);
		
		@unlink($content_path.$action."_log.txt");
		if (count($logs) > 0) file_put_contents($content_path.$action."_log.txt", join("\r\n", $logs));
	}
	
	# 有城镇待机，无战场待机，则直接取用城镇待机代替战场待机
	if (!$is_npc && $has_idle && !$has_standby && !$is_realm) {
		$content_action_path = $content_path.STANDBY."/";#str_replace(IDLE."/", STANDBY."/", $content_action_path);
		
		if (! is_dir($content_action_path)) {
			mkdir($content_action_path, 0777, true);
		}
		
		$arr = $classes[IDLE][LEFT_TOP];
		file_put_contents(
			$content_action_path."avatar_".LEFT_TOP.".as",
			gbk_to_utf8(get_as(STANDBY, $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6], $arr[7]))
		);
		
		$arr = $classes[IDLE][RIGHT_BOTTOM];
		file_put_contents(
			$content_action_path."avatar_".RIGHT_BOTTOM.".as",
			gbk_to_utf8(get_as(STANDBY, $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6], $arr[7]))
		);
		
		$classnames = array("avatar_".LEFT_TOP.";", "avatar_".RIGHT_BOTTOM.";");
		$pngs = array(
			"\"".$dir.IDLE."/".LEFT_TOP.".png\"",
			"\"".$dir.IDLE."/".RIGHT_BOTTOM.".png\""
		);
		
		create_doc_class($content_action_path, $classnames);
		
		$jsfl = $jsfl."\n".create_jsfl($content_path, $pngs, $content_action_path, $path_prefix, STANDBY, $classnames);
	}
	
	if ($jsfl) {
		global $jsfl_content;
		$jsfl_content .= $jsfl;
		
		file_put_contents($content_path."avatar.jsfl", $jsfl);
		print $content_path."\n";
	}
}

function get_as ($type, $face, $frames, $frames_repeat, $interval, $name_point, $reg_point, $actions) {
	return 'package
{
import flash.display.BitmapData;
import flash.geom.Point;

public class avatar_'.$face.'
{
	// 动作类型
	public var type           : String        = "'.$type.'";
	
	// 人物位图
	public var body           : BitmapData    = new body_'.$face.';
	// 阴影位图
	public var shadow         : BitmapData    = null;
	
	// 帧数
	public var frames         : uint          = '.$frames.';
	// 指定帧重复
	public var framesRepeat   : Vector.<uint> = Vector.<uint>(['.$frames_repeat.']);
	// 帧间隔(单位：毫秒)
	public var interval       : uint          = '.$interval.';
	// 名称位置
	public var namePoint      : Point         = new Point('.$name_point.');
	// 注册点
	public var regPoint       : Point         = new Point('.$reg_point.');
	// 面朝向
	public var face           : String        = "'.$face.'";
	// 动作反应帧
	public var actions        : Vector.<uint> = Vector.<uint>(['.$actions.']);
	
	// 阴影位置
	public var shadowPosition : Point         = null;
}
}';
}

function create_doc_class ($content_action_path, $classnames) {
	$doc_class = 'package maplib
{
import flash.display.Sprite;

public class AvatarBmds extends Sprite
{
	public function AvatarBmds ()
	{
		'.join("\n		", $classnames).'
	}
}
}';
	if (is_dir($content_action_path) && ! is_dir($content_action_path."maplib"))
		mkdir($content_action_path."maplib", 0777);
	if (count($classnames) > 0) file_put_contents($content_action_path."maplib/AvatarBmds.as", $doc_class);
}

function create_jsfl ($content_path, $pngs, $content_action_path, $path_prefix, $action, $classnames) {
	global $current_path, $in_war, $in_drama, $jsfls, $flash_path;
	
	global $monster_dir, $npc_dir, $player_dir, $pet_dir,
	       $monster_war_dir, $player_war_dir, $ghost_shield_dir,
	       $player_realm_dir;
	
	$is_monster = strpos($content_action_path, $current_path."/role_fruits/".$monster_dir) === 0
	            || strpos($content_action_path, $current_path."role_fruits/".$monster_war_dir) === 0;
	$is_npc     = strpos($content_action_path, $current_path."/role_fruits/".$npc_dir) === 0;
	$is_player  = strpos($content_action_path, $current_path."/role_fruits/".$player_dir) === 0
	            || strpos($content_action_path, $current_path."/role_fruits/".$player_war_dir) === 0;
	$is_pet     = strpos($content_action_path, $current_path."/role_fruits/".$pet_dir) === 0;
	
	$is_realm   = strpos($content_action_path, $current_path."role_fruits/".$player_realm_dir) === 0;
	
	//print $content_action_path."  ".$current_path."role_fruits/".$player_realm_dir."\n";
	
	#print $is_monster." ".$is_npc." ".$is_player." ".$content_path." ".$current_path."\n";
	#$compile_to_one# = $action == IDLE || $action == RUN || $action == WALK ? "true" : "false";
	$compile_to_one
		= in_array($action, $in_war, true)
		  || in_array($action, $in_drama, true)
		  || $is_realm
		? "false"
		: "true";
	
	$jsfl = '
var path = "'.$content_path.'";
var list = ['.join(",\n", $pngs).'];

var compileToOne = '.$compile_to_one.';

if (compileToOne) {

fl.createDocument();
var dom = fl.getDocumentDOM();
//dom.docClass = "Avatar";

dom.sourcePath = "'.$content_action_path.'";
dom.getTimeline().setFrameProperty("actionScript", "import maplib.AvatarBmds;maplib.AvatarBmds;");

for (var i = 0; i < list.length; i++) {
	dom.importFile("'.$path_prefix.'" + list[i], true);
}

var items = dom.library.items;
for (var i = 0; i < items.length; i++) {
	item = items[i];
	
	item.linkageExportForAS = true;
	item.linkageExportInFirstFrame = true;
	item.linkageClassName = "body_" + item.name.replace(".png", "");
	item.linkageBaseClass = "flash.display.BitmapData";
}

dom.exportSWF("'.$path_prefix.'" + path + "swf/'.$action.'.swf", true);

fl.trace("'.$path_prefix.'" + path + "swf/'.$action.'.swf" + " ok");

fl.closeDocument(dom, false);

}

///

if (!compileToOne) {

fl.createDocument();
var dom = fl.getDocumentDOM();

for (var i = 0; i < list.length; i++) {
	var items = dom.library.items;
	var len = items.length;
	for (var j = len - 1; j > -1; j--) {
		dom.library.deleteItem(items[j].name);
	}
	
	dom.sourcePath = "'.$content_action_path.'";
	
	dom.importFile("'.$path_prefix.'" + list[i], true);
	
	items = dom.library.items;
	var item = items[0];
	
	item.linkageExportForAS = true;
	item.linkageExportInFirstFrame = true;
	item.linkageClassName = "body_" + item.name.replace(".png", "");
	item.linkageBaseClass = "flash.display.BitmapData";
	
	dom.getTimeline().setFrameProperty("actionScript", "avatar_" + item.name.replace(".png", "") + ";");
	
	//dom.exportSWF(list[i].replace(/\s*\.png$/, ".swf"), false);
	dom.exportSWF("'.$path_prefix.'" + path + "swf/'.$action.'_" + item.name.replace(".png", ".swf"), true);
	
	fl.trace("'.$path_prefix.'" + path + "swf/'.$action.'_" + item.name.replace(".png", ".swf")+ " ok");
}

fl.closeDocument(dom, false);

}
';
	
	if (count($classnames) > 0) {
		array_push($jsfls, $flash_path."\"".$content_action_path."avatar.jsfl\"");
		#file_put_contents($content_action_path."avatar.jsfl", IS_WIN ? $jsfl : utf8_to_gbk($jsfl));
		
		return (IS_WIN ? $jsfl : utf8_to_gbk($jsfl));
	}
	
	return "";
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