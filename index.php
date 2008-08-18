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
 * Database connection
 */
include_once('include/db.php');

/*
 * Caching
 */
include_once('include/cache.php');

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
			include_once('include/chapter_title.php');
			$ttl .= " :: " . fic_title($_GET['fic']);
			$chttl = chapter_title($_GET['fic'], (isset($_GET['ch']) ? $_GET['ch'] : 1));
			if ($chttl)
				$ttl .= ", " . $chttl;
			echo readfic($_GET['fic'], (isset($_GET['ch']) ? $_GET['ch'] : 0));
			break;
		case "stats":
			include_once('include/stats.php');
			stats();
			break;
		case "search":
			include_once('include/findfic.php');
			echo findfic($_POST['search']);
			break;
		case "title":
			include_once('include/listfics_title.php');
			echo listfics_title();
			break;
		case "author":
			include_once('include/listfics_author.php');
			if (isset($_GET['aid'])) {
				include_once('include/author_name.php');
				$ttl .= " :: " . author_name($_GET['aid']);
			}
			echo listfics_author((isset($_GET['aid']) ? $_GET['aid'] : null));
			break;
		case "matchup":
			include_once('include/listfics_matchup.php');
			if (isset($_GET['mid'])) {
				include_once('include/matchup_data.php');
				$match = matchup_data($_GET['mid']);
				if ($match)
					$ttl .= " :: " . $match["matchup_name"];
			}
			echo listfics_matchup((isset($_GET['mid']) ? $_GET['mid'] : null));
			break;
		case "series":
			include_once('include/listfics_series.php');
			if (isset($_GET['sid'])) {
				include_once('include/series_title.php');
				$ttl .= " :: " . series_title($_GET['sid']);
			}
			echo listfics_series((isset($_GET['sid']) ? $_GET['sid'] : null));
			break;
		case "genre":
			include_once('include/listfics_genre.php');
			if (isset($_GET['gid'])) {
				include_once('include/genre_name.php');
				$ttl .= " :: " . genre_name($_GET['gid']);
			}
			echo listfics_genre((isset($_GET['gid']) ? $_GET['gid'] : null));
			break;
		case "changetheme":
			include_once('include/root.php');
			$_SESSION[$codex_conf['session_key']]['theme'] = $_POST['theme'];
			root();
			break;
		case "cacheflush":
			include_once('include/root.php');
			$cache->clear();
			if ($cache->clear() === TRUE)
				echo "Cache flushed<br /><br />";
			else
				echo "Could not flush cache<br /><br />";
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

$theme = (isset($_SESSION[$codex_conf['session_key']]['theme']) ? $_SESSION[$codex_conf['session_key']]['theme'] : $codex_conf['theme']);
$headerkey = "output_header_" . md5($theme) . "_" . md5($ttl);
$headerout = $cache->get($headerkey);
if (!$headerout) {
	$tpl->clear_all_assign();
	$tpl->assign("title",$ttl);
	$tpl->assign("theme", $theme);
	$headerout = $tpl->fetch("header.tpl");
	$cache->set($headerkey, $headerout);
}
echo $headerout;

echo $main;

$footerout = $cache->get("output_footer");
if (!$footerout) {
	$tpl->clear_all_assign();
	$footerout = $tpl->fetch("footer.tpl");
	$cache->set("output_footer", $footerout);
}
echo $footerout;

ob_end_flush();
?>
