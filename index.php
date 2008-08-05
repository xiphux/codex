<?php
/*
 *  index.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: PHP viewer script
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

 session_start();

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

	date_default_timezone_set("UTC");

	/*
	 * Instantiate smarty
	 */
 	include_once($codex_conf['smarty_prefix'] . "Smarty.class.php");
	$tpl = new Smarty;
 	$tpl->autoload_filters = array('output' => array('trimwhitespace'));

 if ($codex_conf['debug'])
 	error_reporting(E_ALL | E_STRICT);

$ttl = $codex_conf['title'];

ob_start();

/*
 * Determine action via GET variables
 */
if (isset($_GET['u'])) {
	switch ($_GET['u']) {
		case "read":
			include_once('include/readfic.php');
			include_once('include/fic_title.php');
			$ttl .= " :: " . fic_title($_GET['fic']);
			readfic($_GET['fic']);
			break;
		case "stats":
			include_once('include/stats.php');
			stats();
			break;
		case "search":
			include_once('include/findfic.php');
			findfic($_POST['search']);
			break;
		case "title":
			include_once('include/listfics_title.php');
			listfics_title();
			break;
		case "author":
			include_once('include/listfics_author.php');
			if (isset($_GET['aid'])) {
				include_once('include/author_name.php');
				$ttl .= " :: " . author_name($_GET['aid']);
			}
			listfics_author((isset($_GET['aid']) ? $_GET['aid'] : null));
			break;
		case "matchup":
			include_once('include/listfics_matchup.php');
			if (isset($_GET['mid'])) {
				include_once('include/matchup_data.php');
				$match = matchup_data($_GET['mid']);
				if ($match)
					$ttl .= " :: " . $match["matchup_name"];
			}
			listfics_matchup((isset($_GET['mid']) ? $_GET['mid'] : null));
			break;
		case "series":
			include_once('include/listfics_series.php');
			if (isset($_GET['sid'])) {
				include_once('include/series_title.php');
				$ttl .= " :: " . series_title($_GET['sid']);
			}
			listfics_series((isset($_GET['sid']) ? $_GET['sid'] : null));
			break;
		case "genre":
			include_once('include/listfics_genre.php');
			if (isset($_GET['gid'])) {
				include_once('include/genre_name.php');
				$ttl .= " :: " . genre_name($_GET['gid']);
			}
			listfics_genre((isset($_GET['gid']) ? $_GET['gid'] : null));
			break;
		case "changetheme":
			include_once('include/root.php');
			$_SESSION[$codex_conf['session_key']]['theme'] = $_POST['theme'];
			root();
			break;
		default:
			echo "Unknown action";
			break;
	}
} else {
	include_once('include/root.php');
	root();
}

$main = ob_get_contents();
ob_end_clean();

$tpl->clear_all_assign();
$tpl->assign("title",$ttl);
$tpl->assign("theme", (isset($_SESSION[$codex_conf['session_key']]['theme']) ? $_SESSION[$codex_conf['session_key']]['theme'] : $codex_conf['theme']));
$tpl->display("header.tpl");

echo $main;

$tpl->clear_all_assign();
$tpl->display("footer.tpl");

ob_end_flush();
?>
