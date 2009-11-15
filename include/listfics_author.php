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
include_once('printcategoryunknown.php');

function listfics_author($searchid = null, $page = 1, $highlight = 0, $searchstring = null)
{
	global $tables, $tpl, $cache, $codex_conf;

	$outkey = "output_listfics_author_" . $searchid . "_" . $highlight . "_" . md5($searchstring) . "_" . $page;

	$out = $cache->Get($outkey);
	if (!$out) {
		$out = "";

		$key = "listfics_author";
		$q = "SELECT a1.id,a1.name,a1.email,a1.website,f1.id AS fid FROM " . $tables['authors'] . " AS a1 RIGHT JOIN " . $tables['fic_author'] . " AS fa ON fa.author_id = a1.id RIGHT JOIN " . $tables['fics'] . " AS f1 ON fa.fic_id = f1.id";
		/*
		 * User only wants one author
		 */
		if (isset($searchid)) {
			$q .= " WHERE a1.id = $searchid ORDER BY f1.title";
			$key .= "_" . $searchid;
		} else {
			$q .= " ORDER BY a1.name, a1.email, f1.title";
		}
		$al = $cache->Get($key);
		if (!$al) {
			$al = DBSelectLimit($q, $codex_conf['itemsperpage'], (($page - 1) * $codex_conf['itemsperpage']));
			$cache->Set($key, $al);
		}

		$count = $cache->Get($key . "_count");
		if (!$count) {
			$q = "SELECT COUNT(f1.id) FROM " . $tables['authors'] . " AS a1 RIGHT JOIN " . $tables['fic_author'] . " AS fa ON fa.author_id = a1.id RIGHT JOIN " . $tables['fics'] . " AS f1 ON fa.fic_id = f1.id";
			if (isset($searchid))
				$q .= " WHERE a1.id = $searchid";
			$count = DBGetOne($q);
			$cache->Set($key . "_count", $count);
		}

		$previd = -1;

		while (!$al->EOF) {
			if ($al->fields['id'] != $previd) {
				$name = $al->fields['name'];
				$email = $al->fields['email'];
				if (!(isset($name) || isset($email)))
					$out .= printcategoryunknown();
				else {
					if ($highlight == CODEX_AUTHOR && $searchstring) {
						highlight($name,$searchstring);
						highlight($email,$searchstring);
					}
					$out .= printcategory("author", "aid", $al->fields['id'], (isset($name) ? $name : $email), $email, $al->fields['website']);
				}
				$previd = $al->fields['id'];
			}
			$out .= printfic($al->fields['fid'], false, $highlight, $searchstring);
			$al->MoveNext();
		}
		$al->Close();
		
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
