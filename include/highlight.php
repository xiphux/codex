<?php
/*
 *  highlight.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: highlight
 *  Highlight a substring in another string with a <span> tag
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function highlight(&$string, $substr, $type = "searchtext", $skipparens = false)
{
	if (strlen($string) < 1)
		return;
	if ($skipparens) {
		preg_match("/([^\(]*)(\([^\(]*\))?([^\(]*)(\([^\(]*\))?/",$string,$regs);
		$cnt = count($regs);
		$str = "";
		for ($i = 1; $i < $cnt; ++$i) {
			$tmp = $regs[$i];
			if (strlen($tmp) > 0) {
				if (substr_compare($tmp,"(",0,1) != 0)
					highlight($tmp, $substr, $type);
				$str .= $tmp;
			}
		}
		$string = $str;
	} else {
		$string = "<span>" . $string . "</span>";
		$string = preg_replace("/(>[^<]*)(" . quotemeta($substr) . ")/i","$1<span class=\"" . $type . "\">$2</span>",$string);
		$string = preg_replace("/<span>/","",$string);
		$string = substr($string,0,-7);
	}
}

?>
