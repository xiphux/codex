<?php
/*
 *  toc.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: toc
 *  Display a fic's table of contents
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

include_once('fic_chapters.php');
include_once('printfic.php');

function toc($id)
{
	global $tpl, $cache;

	$outkey = "output_toc_" . $id;

	$out = $cache->get($outkey);
	if (!$out) {
		$out = printfic($id);

		$chapters = fic_chapters($id);
		$tpl->assign("ficid", $id);
		$tpl->assign("chapters", $chapters);
		$out .= $tpl->fetch("toc.tpl");
		
		$cache->set($outkey, $out);
	}
	return $out;
}

?>
