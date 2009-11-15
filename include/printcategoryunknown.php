<?php
/*
 *  printcategoryunknown.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: printfic
 *  Print out an unknown category header for a fic listing
 *
 *  Copyright (C) 2009 Christopher Han <xiphux@gmail.com>
 */

function printcategoryunknown()
{
	global $cache, $tpl;

	$key = "output_printcategoryunknown";

	$out = $cache->Get($key);
	if (!$out) {
		$tpl->clear_all_assign();
		$tpl->assign("unknown", true);
		$out = $tpl->fetch("category.tpl");
		$cache->Set($key, $out);
	}
	return $out;
}
