<?php
/*
 *  listfics_title.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: listfics_title
 *  List fics by title
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */
include_once('defs.php');
include_once('printfic.php');

function listfics_title($page = 1, $highlight = 0, $searchstring = null)
{
	global $tables, $cache, $codex_conf, $tpl;

	if ($page < 1)
		$page = 1;

	$outkey = "output_listfics_title_" . $highlight . "_" . md5($searchstring) . "_" . $page;

	$out = $cache->Get($outkey);
	if (!$out) {
		$out = "";

		$fl = $cache->Get("listfics_title_" . $page);
		if (!$fl) {
			$fl = DBSelectLimit("SELECT id FROM " . $tables['fics'] . " ORDER BY title", $codex_conf['itemsperpage'], (($page - 1) * $codex_conf['itemsperpage']));
			$cache->Set("listfics_title", $fl);
		}

		$count = $cache->Get("listfics_title_count");
		if (!$count) {
			$count = DBGetOne("SELECT COUNT(id) FROM " . $tables['fics']);
			$cache->Set("listfics_title_count", $count);
		}

		while (!$fl->EOF) {
			$out .= printfic($fl->fields['id'],TRUE,$highlight,$searchstring);
			$fl->MoveNext();
		}
		$fl->Close();

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
			$tpl->assign("pagerdest", "title");
			$pagercontent = $tpl->fetch("pager.tpl");
			$out = $pagercontent . $out . $pagercontent;
		}

		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
