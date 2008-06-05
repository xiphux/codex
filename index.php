<?php
 ob_start();
 $version = "v03c";
 $codex_appstring = "codex $version";
/*
 *  index.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: PHP viewer script
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */
 	/*
	 * Config
	 */
	include_once('config/codex.conf.php');

	/*
	 * Persistent database connection
	 */
	include_once('include/db.php');

	/*
	 * Instantiate smarty
	 */
 	include_once($codex_conf['smarty_prefix'] . "Smarty.class.php");
	$tpl =& new Smarty;
	$tpl->load_filter('output','trimwhitespace');

	/*
	 * Function library
	 */
	include_once('include/codex.lib.php');


$ttl = $codex_conf['title'];
/*
 * Give the fic title if reading
 */
if ($HTTP_GET_VARS['u'] == "read")
	$ttl .= " :: " . fic_title($HTTP_GET_VARS['fic']);
else if ($HTTP_GET_VARS['u'] == "matchup" && isset($HTTP_GET_VARS['mid'])) {
	$match = matchup_data($HTTP_GET_VARS['mid']);
	if ($match)
		$ttl .= " :: " . $match["matchup_name"];
} else if ($HTTP_GET_VARS['u'] == "series" && isset($HTTP_GET_VARS['sid']))
	$ttl .= " :: " . series_title($HTTP_GET_VARS['sid']);
else if ($HTTP_GET_VARS['u'] == "author" && isset($HTTP_GET_VARS['aid']))
	$ttl .= " :: " . author_name($HTTP_GET_VARS['aid']);
else if ($HTTP_GET_VARS['u'] == "genre" && isset($HTTP_GET_VARS['gid']))
	$ttl .= " :: " . genre_name($HTTP_GET_VARS['gid']);
	
$tpl->clear_all_assign();
$tpl->assign("title",$ttl);
$tpl->assign("body_color",$codex_conf['body_color']);
$tpl->assign("background_color",$codex_conf['background_color']);
$tpl->assign("link_color",$codex_conf['link_color']);
$tpl->assign("lemon_color",$codex_conf['lemon_color']);
$tpl->assign("searchtext_color",$codex_conf['searchtext_color']);
$tpl->assign("focus_color",$codex_conf['focus_color']);
$tpl->display("header.tpl");
/*
 * Determine action via GET variables
 */
if (isset($HTTP_GET_VARS['u'])) {
	if ($HTTP_GET_VARS['u'] == "read")
		readfic($HTTP_GET_VARS['fic']);
	else if ($HTTP_GET_VARS['u'] == "stats")
		stats();
	else if ($HTTP_GET_VARS['u'] == "dbperfmon")
		dbperfmon();
	else if ($HTTP_GET_VARS['u'] == "search")
		findfic($HTTP_POST_VARS['search']);
	else {
		$tid = null;
		switch($HTTP_GET_VARS['u']) {
			case "author":
				$tid = $HTTP_GET_VARS['aid'];
				break;
			case "matchup":
				$tid = $HTTP_GET_VARS['mid'];
				break;
			case "series":
				$tid = $HTTP_GET_VARS['sid'];
				break;
			case "genre":
				$tid = $HTTP_GET_VARS['gid'];
				break;
		}
		listfics($HTTP_GET_VARS['u'],$tid);
	}
} else {
	$tpl->clear_all_assign();
	$tpl->assign("title",$codex_conf['title']);
	if ($codex_conf['stats'])
		$tpl->assign("stats",TRUE);
	if ($codex_conf['dbperfmon'])
		$tpl->assign("dbperfmon",TRUE);
	$tpl->display("root.tpl");
}

$tpl->clear_all_assign();
$tpl->display("footer.tpl");

ob_end_flush();
?>
