<?php
/*
 *  highlight.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: highlight
 *  Highlight a substring in another string with a <span> tag
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function highlight(&$string, $substr, $type = "searchtext")
{
	if (strlen($string) < 1)
		return;
	$string = "<span>" . $string . "</span>";
	$string = preg_replace("/(>[^<]*)(" . quotemeta($substr) . ")/i","$1<span class=\"" . $type . "\">$2</span>",$string);
	$string = preg_replace("/<span>/","",$string);
	$string = substr($string,0,-7);
}

?>
