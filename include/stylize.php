<?php
/*
 * stylize.php
 * Codex: A PHP/MySQL fanfiction database
 * Component: stylize
 * Attempts to stylize lines of text
 *
 * Copyright (C) 2012 Christopher Han <xiphux@gmail.com>
 */

function stylize($str)
{
	/*
	 * Stylize breaking lines
	 */
	$str = preg_replace("/\s*\n([\s\n])*(([\*\-=\~_<>]|&gt;|&lt;) ?){2,}([\s\n])*\n/","<div class=\"breakline\"></div>", $str);

	/*
	 * Add emphasis for underscores
	 */
	$str = preg_replace("/(\W)_([^\t\n\r\f\a\e>]+?)_(\W)/e", "'$1<span class=\"emphasis\">'.str_replace('_',' ','$2').'</span>$3'", $str);

	/*
	 * Add emphasis for asterisks
	 */
	$str = preg_replace("/([^\*])(\*{1,2})([^\*>\n]*)(\*{1,2})([^\*])/","$1$2<span class=\"emphasis\">$3</span>$4$5", $str);

	/*
	 * Superscript trademark symbol
	 */
	$str = preg_replace("/\^?\(TM\)/i", "<sup>TM</sup>", $str);

	/*
	 * Use real copyright symbol
	 */
	$str = preg_replace("/\(C\)/i", "&copy;", $str);

	return $str;
}
