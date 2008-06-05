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
	$string = "<span>" . $string . "</span>";
	$string = eregi_replace("(>[^<]*)(" . quotemeta($substr) . ")","\\1<span class=\"" . $type . "\">\\2</span>",$string);
	$string = eregi_replace("<span>","",$string);
	$string = substr($string,0,-7);
}

?>
