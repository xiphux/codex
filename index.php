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

 if ($codex_conf['debug'])
 	error_reporting(E_ALL | E_STRICT);

$ttl = $codex_conf['title'];
/*
 * Append relevant info to title
 */
if (isset($_GET['u'])) {
	switch ($_GET['u']) {
		case "read":
			include_once('include/fic_title.php');
			$ttl .= " :: " . fic_title($_GET['fic']);
			break;
		case "matchup":
			if (isset($_GET['mid'])) {
				include_once('include/matchup_data.php');
				$match = matchup_data($_GET['mid']);
				if ($match)
					$ttl .= " :: " . $match["matchup_name"];
			}
			break;
		case "series":
			if (isset($_GET['sid'])) {
				include_once('include/series_title.php');
				$ttl .= " :: " . series_title($_GET['sid']);
			}
			break;
		case "author":
			if (isset($_GET['aid'])) {
				include_once('include/author_name.php');
				$ttl .= " :: " . author_name($_GET['aid']);
			}
			break;
		case "genre":
			if (isset($_GET['gid'])) {
				include_once('include/genre_name.php');
				$ttl .= " :: " . genre_name($_GET['gid']);
			}
			break;
	}
}
	
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
	if ($_GET['u'] == "read") {
		include_once('include/readfic.php');
		readfic($_GET['fic']);
	} else if ($_GET['u'] == "stats") {
		include_once('include/stats.php');
		stats();
	} else if ($_GET['u'] == "dbperfmon") {
		include_once('include/dbperfmon.php');
		dbperfmon();
	} else if ($_GET['u'] == "search") {
		include_once('include/findfic.php');
		findfic($_POST['search']);
	} else {
		include_once('include/listfics.php');
		$tid = null;
		switch($_GET['u']) {
			case "author":
				$tid = (isset($_GET['aid']) ? $_GET['aid'] : null);
				break;
			case "matchup":
				$tid = (isset($_GET['mid']) ? $_GET['mid'] : null);
				break;
			case "series":
				$tid = (isset($_GET['sid']) ? $_GET['sid'] : null);
				break;
			case "genre":
				$tid = (isset($_GET['gid']) ? $_GET['gid'] : null);
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
