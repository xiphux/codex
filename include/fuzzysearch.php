<?php
/*
 *  fuzzysearch.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: fuzzysearch
 *  Attempt to perform a fuzzy search
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 */

function fuzzysearch($haystack, $needle)
{
	global $codex_conf;
	$stripchars = array( ".", ",", ";", ":", "|", "[", "]", "{", "}", "(", ")", "=", "+", "!", "@", "#", "$", "%", "^", "&", "*", "/", "\\", "<", ">", "?");
	$haystack = str_replace($stripchars,"",$haystack);
	$haystack = strtolower($haystack);
	$needle = strtolower($needle);
	$words = explode(" ",$haystack);
	foreach ($words as $word) {
		if (levenshtein($word, $needle) <= $codex_conf['fuzzysearchthreshold'])
			return TRUE;
	}
	return FALSE;
}

?>
