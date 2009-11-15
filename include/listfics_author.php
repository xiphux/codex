<?php
/*
 *  listfics_author.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: listfics_author
 *  List fics by author
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */
include_once('defs.php');
include_once('highlight.php');
include_once('printfic.php');
include_once('printcategory.php');
include_once('author_fic.php');

function listfics_author($searchid = null, $page = 1, $highlight = 0, $searchstring = null)
{
	global $tables, $tpl, $cache, $codex_conf;

	$outkey = "output_listfics_author_" . $searchid . "_" . $highlight . "_" . md5($searchstring) . "_" . $page;

	$out = $cache->Get($outkey);
	if (!$out) {
		$out = "";

		$key = "listfics_author";
		$q = "SELECT a1.id,a1.name,a1.email,a1.website,COUNT(f1.id) AS count FROM " . $tables['authors'] . " AS a1 JOIN " . $tables['fic_author'] . " AS fa ON a1.id = fa.author_id LEFT JOIN " . $tables['fics'] . " AS f1 ON fa.fic_id = f1.id WHERE ((a1.name IS NOT NULL) OR (a1.email IS NOT NULL))";
		/*
		 * User only wants one author
		 */
		if (isset($searchid)) {
			$q .= " AND a1.id = $searchid";
			$key .= "_" . $searchid;
		} else {
			$q .= " GROUP BY a1.id ORDER BY a1.name";
		}
		$al = $cache->Get($key);
		if (!$al) {
			$al = DBGetArray($q);
			$cache->Set($key, $al);
		}

		/*
		 * Enumerate author list
		 */
		$displayed = 0;
		$start = ($page - 1) * $codex_conf['itemsperpage'] + 1;
		$end = $page * $codex_conf['itemsperpage'];
		$shownext = false;
		foreach ($al as $row) {
			if (($displayed + $row['count']) < $start) {
				$displayed += $row['count'];
			} else if ($displayed >= $end) {
				$shownext = true;
				break;
			} else {

				if ($highlight == CODEX_AUTHOR && $searchstring) {
					highlight($row['name'],$searchstring);
					highlight($row['email'],$searchstring);
				}
				$out .= printcategory("author", "aid", $row['id'], (isset($row['name']) ? $row['name'] : $row['email']), $row['email'], $row['website']);
				
				$offset = $start - $displayed - 1;
				if ($offset < 0)
					$offset = 0;
				$count = $end - $displayed - $offset;
				$fl = author_fic($row['id'], $count, $offset);
				while (!$fl->EOF) {
					$out .= printfic($fl->fields['id'],FALSE,$highlight,$searchstring);
					$fl->MoveNext();
					++$displayed;
				}
				$displayed += $offset;

				if (($count + $offset) < $row['count']) {
					$shownext = true;
					break;
				}
			}
		}

		if ($shownext || ($page > 1)) {
			if ($shownext)
				$tpl->assign("pagernext", ($page+1));
			if ($page > 1)
				$tpl->assign("pagerprev", ($page-1));
			$tpl->assign("pagerdest", "author");
			if (isset($searchid))
				$tpl->assign("pagerauthorid", $searchid);
			$pagerout = $tpl->fetch("pager.tpl");
			$out = $pagerout . $out . $pagerout;
		}

		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
