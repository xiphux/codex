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
$tpl->display("header.tpl");
/*
 * Determine action via GET variables
 */
if (isset($_GET['u'])) {
	switch ($_GET['u']) {
		case "read":
			include_once('include/readfic.php');
			readfic($_GET['fic']);
			break;
		case "stats":
			include_once('include/stats.php');
			stats();
			break;
		case "dbperfmon":
			include_once('include/dbperfmon.php');
			dbperfmon();
			break;
		case "search":
			include_once('include/findfic.php');
			findfic($_POST['search']);
			break;
		case "title":
			include_once('include/listfics.php');
			listfics($_GET['u'], null);
			break;
		case "author":
			include_once('include/listfics.php');
			listfics($_GET['u'], (isset($_GET['aid']) ? $_GET['aid'] : null));
			break;
		case "matchup":
			include_once('include/listfics.php');
			listfics($_GET['u'], (isset($_GET['mid']) ? $_GET['mid'] : null));
			break;
		case "series":
			include_once('include/listfics.php');
			listfics($_GET['u'], (isset($_GET['sid']) ? $_GET['sid'] : null));
			break;
		case "genre":
			include_once('include/listfics.php');
			listfics($_GET['u'], (isset($_GET['gid']) ? $_GET['gid'] : null));
			break;
		default:
			echo "Unknown action";
			break;
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
