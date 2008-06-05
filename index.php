<?php
/*
 *  index.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: PHP viewer script
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

 ob_start();

 	/*
	 * Version
	 */
	include_once('include/version.php');

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
if ($_GET['u'] == "read")
	$ttl .= " :: " . fic_title($_GET['fic']);
else if ($_GET['u'] == "matchup" && isset($_GET['mid'])) {
	$match = matchup_data($_GET['mid']);
	if ($match)
		$ttl .= " :: " . $match["matchup_name"];
} else if ($_GET['u'] == "series" && isset($_GET['sid']))
	$ttl .= " :: " . series_title($_GET['sid']);
else if ($_GET['u'] == "author" && isset($_GET['aid']))
	$ttl .= " :: " . author_name($_GET['aid']);
else if ($_GET['u'] == "genre" && isset($_GET['gid']))
	$ttl .= " :: " . genre_name($_GET['gid']);
	
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
if (isset($_GET['u'])) {
	if ($_GET['u'] == "read")
		readfic($_GET['fic']);
	else if ($_GET['u'] == "stats")
		stats();
	else if ($_GET['u'] == "dbperfmon")
		dbperfmon();
	else if ($_GET['u'] == "search")
		findfic($_POST['search']);
	else {
		$tid = null;
		switch($_GET['u']) {
			case "author":
				$tid = $_GET['aid'];
				break;
			case "matchup":
				$tid = $_GET['mid'];
				break;
			case "series":
				$tid = $_GET['sid'];
				break;
			case "genre":
				$tid = $_GET['gid'];
				break;
		}
		listfics($_GET['u'],$tid);
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
