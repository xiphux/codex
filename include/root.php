<?php
/*
 *  root.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: root
 *  Display root page
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */
include_once('include/listthemes.php');

function root()
{
	global $tpl, $codex_conf, $cache;

	$theme = (isset($_SESSION[$codex_conf['session_key']]['theme']) ? $_SESSION[$codex_conf['session_key']]['theme'] : $codex_conf['theme']);
	$themelist = listthemes();
	$key = "output_root_" . md5($codex_conf['title']) . "_" . md5($theme) . "_" . md5(serialize($themelist));
	if ($codex_conf['stats'])
		$key .= "_stats";
	$rootout = $cache->Get($key);
	if (!$rootout) {
		$tpl->clear_all_assign();
		$tpl->assign("title",$codex_conf['title']);
		if ($codex_conf['stats'])
			$tpl->assign("stats",TRUE);
		$tpl->assign("selectedtheme", $theme);
		$tpl->assign("themes", $themelist);
		if ($cache->GetCacheType() !== XXCACHE_NULL)
			$tpl->assign("cache", TRUE);
		$rootout = $tpl->fetch("root.tpl");
		$cache->Set($key, $rootout);
	}
	echo $rootout;
}

?>
