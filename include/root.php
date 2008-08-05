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
	global $tpl, $codex_conf;
	$tpl->clear_all_assign();
	$tpl->assign("title",$codex_conf['title']);
	if ($codex_conf['stats'])
		$tpl->assign("stats",TRUE);
	if ($codex_conf['dbperfmon'])
		$tpl->assign("dbperfmon",TRUE);
	$tpl->assign("selectedtheme",(isset($_SESSION[$codex_conf['session_key']]['theme']) ? $_SESSION[$codex_conf['session_key']]['theme'] : $codex_conf['theme']));
	$tpl->assign("themes",listthemes());
	$tpl->display("root.tpl");
}

?>
