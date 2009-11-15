<?php
/*
 *  index.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: PHP viewer script
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

 $starttime = microtime(true);

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
include_once('include/xxcache/xxcache.php');
$cache = GetXXCache($codex_conf['cachetype']);
if ($cache->GetCacheType() === XXCACHE_MEMCACHE) {
	$cache->SetAddress($codex_conf['memcached_address']);
	$cache->SetPort($codex_conf['memcached_port']);
	$cache->SetPersist($codex_conf['memcached_persist']);
	$cache->SetNamespace("codex_");
} else if ($cache->GetCacheType() === XXCACHE_EACCELERATOR) {
	$cache->SetNamespace("codex_");
} else if ($cache->GetCacheType() === XXCACHE_FILECACHE) {
	$cache->SetCacheDir($codex_conf['filecache_dir']);
}
$cache->Open();

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
		case "show":
			include_once('include/printfic.php');
			echo printfic($_GET['fic']);
			break;
		case "read":
			include_once('include/readfic.php');
			include_once('include/fic_title.php');
			include_once('include/chapter_title.php');
			include_once('include/chapter_exists.php');
			include_once('include/chapter_count.php');
			$ttl .= " :: " . fic_title($_GET['fic']);
			if (isset($_GET['ch'])) {
				$chttl = chapter_exists($_GET['fic'], $_GET['ch']);
				if ($chttl) {
					$chttl = chapter_title($_GET['fic'], $_GET['ch']);
					if ($chttl)
						$ttl .= " :: " . $chttl;
					else if (chapter_count($_GET['fic']) > 1)
						$ttl .= " :: " . "Chapter " . $_GET['ch'];
				}
			}
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
			echo listfics_title((isset($_GET['pg']) ? $_GET['pg'] : 1));
			break;
		case "author":
			include_once('include/listfics_author.php');
			if (isset($_GET['aid'])) {
				include_once('include/author_name.php');
				$ttl .= " :: " . author_name($_GET['aid']);
			}
			echo listfics_author((isset($_GET['aid']) ? $_GET['aid'] : null), (isset($_GET['pg']) ? $_GET['pg'] : 1));
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
			echo listfics_series((isset($_GET['sid']) ? $_GET['sid'] : null), (isset($_GET['pg']) ? $_GET['pg'] : 1));
			break;
		case "genre":
			include_once('include/listfics_genre.php');
			if (isset($_GET['gid'])) {
				include_once('include/genre_name.php');
				$ttl .= " :: " . genre_name($_GET['gid']);
			}
			echo listfics_genre((isset($_GET['gid']) ? $_GET['gid'] : null), (isset($_GET['pg']) ? $_GET['pg'] : 1));
			break;
		case "changetheme":
			include_once('include/root.php');
			$_SESSION[$codex_conf['session_key']]['theme'] = $_POST['theme'];
			root();
			break;
		case "cacheflush":
			include_once('include/root.php');
			$cache->Clear();
			if ($cache->Clear() === TRUE)
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
$headerout = $cache->Get($headerkey);
if (!$headerout) {
	$tpl->clear_all_assign();
	$tpl->assign("title",$ttl);
	$tpl->assign("theme", $theme);
	$headerout = $tpl->fetch("header.tpl");
	$cache->Set($headerkey, $headerout);
}
echo $headerout;

echo $main;

if ($codex_conf['debug']) {
	echo '<hr /><span class="italic"><span class="label">Database queries:</span> ' . $querycount . '</span>';
	echo '<br /><span class="italic"><span class="label">Execution time:</span> ' . (microtime(true)-$starttime) . '</span>';
	echo '<div class="bottompadding"></div>';
}

$footerout = $cache->Get("output_footer");
if (!$footerout) {
	$tpl->clear_all_assign();
	$footerout = $tpl->fetch("footer.tpl");
	$cache->Set("output_footer", $footerout);
}
echo $footerout;

$cache->Close();

ob_end_flush();

?>
