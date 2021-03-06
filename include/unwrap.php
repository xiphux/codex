<?php
/*
 * unwrap.php
 * Codex: A PHP/MySQL fanfiction database
 * Component: unwrap
 * Attempts to unwrap lines of text
 *
 * Copyright (C) 2009 Christopher Han <xiphux@gmail.com>
 */

function unwrap($str)
{
	global $codex_conf;
	
	$return = "";
	$lines = explode("\n", preg_replace("/([^\n])(\n\s*){2,}\n(\s*[^\n])/","$1\n\n$3",$str));

	$linecount = count($lines);

	$charcount = 0;
	$tablinecount = 0;
	$spacelinecount = 0;
	$noblanklinecount = 0;

	for ($i = 0; $i < $linecount; ++$i) {
		/* space indents to tabs */
		$lines[$i] = preg_replace("/^ {2,}([^ ].*)$/", "\t$1", $lines[$i], 1);

		if (preg_match("/^\t/", $lines[$i]))
			++$tablinecount;

		if (preg_match("/ $/", $lines[$i]))
			++$spacelinecount;

		$charcount += strlen($lines[$i]);

		if (strlen(trim($lines[$i])) > 0)
			++$noblanklinecount;
	}

	$avglen = (int)($charcount / $noblanklinecount);

	$method = "";

	$spacelineratio = $spacelinecount/$noblanklinecount;
	if (($spacelineratio > 0.6) && ($spacelineratio < 0.98)) {
		/*
		 * This string might be unwrappable using
		 * spaces at the ends of lines
		 */
		$return = preg_replace("/ \n/", " ", $str);
		if ($codex_conf['debug'])
			$method = "Spaces at ends of lines";
	} else if (($tablinecount/$noblanklinecount) > 0.20) {
		/*
		 * This string might be unwrappable
		 * using tab/space indents to find paragraphs
		 */
		 $return = preg_replace("/ *\n(\S)/", " $1", $str);
		 if ($codex_conf['debug'])
			$method = "Indents";
	} else if ((($linecount-$noblanklinecount)/$linecount) > 0.10) {
		/*
		 * This string might be unwrappable
		 * using blank lines to find paragraphs
		 */
		$return = preg_replace("/([^\n]) *\n([^\r\s])/", "$1 $2", $str);
		if ($codex_conf['debug'])
			$method = "Blank lines";
	} else if ($avglen > 1) {
		/*
		 * This string might be unwrappable by
		 * attempting to guess line widths
		 */
		$return = preg_replace("/([^\n]{" . (int)$avglen . ",})\n/","$1 ",$str);
		$return = preg_replace("/([\w,]) {2,}([\w,])/", "$1 $2", $return);
		if ($codex_conf['debug'])
			$method = "Line widths";
	}

	if ($codex_conf['debug']) {
		echo "Unwrap method: " . $method . "<br />";
		echo "Line count: " . $linecount . "<br />";
		echo "Indented lines: " . $tablinecount . "<br />";
		echo "Lines ending with spaces: " . $spacelinecount . "<br />";
		echo "Non-blank line count: " . $noblanklinecount . "<br />";
		echo "Average line length: " . $avglen . "<br />";
	}

	return $return;
}

?>
