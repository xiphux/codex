<?php
/*
 *  listfics_genre.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: listfics_genre
 *  List fics by genre
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

include_once('defs.php');
include_once('highlight.php');
include_once('printfic.php');
include_once('printcategory.php');
include_once('printcategoryunknown.php');

function listfics_genre($searchid = null, $page = 1, $highlight = 0, $searchstring = null)
{
	global $codex_conf, $tables, $tpl, $cache;

	$outkey = "output_listfics_genre_" . $searchid . "_" . $highlight . "_" . md5($searchstring) . "_" . $page;
	if ($codex_conf['lemons'])
		$outkey .= "_lemons";

	$out = $cache->Get($outkey);
	if (!$out) {
		$out = "";

		$key = "listfics_genre";
		$q = "SELECT g1.id,g1.name,f1.id AS fid FROM " . $tables['genres'] . " AS g1 RIGHT JOIN " . $tables['fic_genre'] . " AS fg ON fg.genre_id = g1.id RIGHT JOIN " . $tables['fics'] . " AS f1 ON fg.fic_id = f1.id";
		/*
		 * User only wants one genre
		 */
		if (isset($searchid)) {
			if ($codex_conf['lemons'])
				$q .= " WHERE g1.id = $searchid ORDER BY f1.title";
			else
				$q .= " WHERE g1.id = $searchid AND UPPER(g1.name) NOT LIKE 'LEMON%' ORDER BY f1.title";
			$key .= "_" . $searchid;
		} else {
			if (!$codex_conf['lemons'])
				$q .= " WHERE UPPER(g1.name) NOT LIKE 'LEMON%'";
			$q .= " ORDER BY g1.name, f1.title";
		}
		$gl = $cache->Get($key);
		if (!$gl) {
			$gl = DBSelectLimit($q, $codex_conf['itemsperpage'], (($page - 1) * $codex_conf['itemsperpage']));
			$cache->Set($key, $gl);
		}

		$count = $cache->Get($key . "_count");
		if (!$count) {
			$q = "SELECT COUNT(f1.id) FROM " . $tables['genres'] . " AS g1 RIGHT JOIN " . $tables['fic_genre'] . " AS fg ON fg.genre_id = g1.id RIGHT JOIN " . $tables['fics'] . " AS f1 ON fg.fic_id = f1.id";
			if (isset($searchid)) {
				$q .= " WHERE g1.id = $searchid";
				if (!$codex_conf['lemons'])
					$q .= " AND UPPER(g1.name) NOT LIKE '%LEMON%'";
			} else if (!$codex_conf['lemons']) {
				$q .= " WHERE UPPER(g1.name) NOT LIKE 'LEMON%'";
			}
			$count = DBGetOne($q);
			$cache->Set($key . "_count", $count);
		}

		$previd = -1;

		while (!$gl->EOF) {
			if ($gl->fields['id'] != $previd) {
				$name = $gl->fields['name'];
				if (!isset($name)) {
					$out .= printcategoryunknown();
				} else {
					if ($highlight == CODEX_GENRE && $searchstring)
						highlight($name,$searchstring);
					highlight($name,"Lemon","lemontext");
					$out .= printcategory("genre", "gid", $gl->fields['id'], $name, null, null);
				}
				$previd = $gl->fields['id'];
			}
			$out .= printfic($gl->fields['fid'],TRUE,$highlight,$searchstring);
			$gl->MoveNext();
		}
		$gl->Close();

		$showpager = false;
		if ($page > 1) {
			$showpager = true;
			$tpl->assign("pagerprev", ($page-1));
		}
		if ($count > ($page * $codex_conf['itemsperpage'])) {
			$showpager = true;
			$tpl->assign("pagernext", ($page+1));
		}
		if ($showpager) {
			$tpl->assign("pagerdest", "genre");
			if (isset($searchid))
				$tpl->assign("pagergenreid", $searchid);
			$pagerout = $tpl->fetch("pager.tpl");
			$out = $pagerout . $out . $pagerout;
		}
		
		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
