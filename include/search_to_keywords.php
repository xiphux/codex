<?php
/*
 * search_to_keywords.php
 * Codex: A PHP/MySQL fanfiction database
 * Component: search_to_keywords
 * Break search query into keywords
 *
 * Copyright (C) 2009 Christopher Han <xiphux@gmail.com>
 */

function search_to_keywords($search = null)
{
	if (strlen($search) < 1)
		return;

	$words = explode(" ", $search);

	if (count($words) <= 1)
		return;

	$keywords = array();

	$keywords['default'] = array();
	$keywords['and'] = array();
	$keywords['not'] = array();

	foreach ($words as $word) {
		if (substr_compare($word, "+", 0, 1) === 0) {
			$tmp = substr($word, 1);
			if (strlen($tmp) > 0)
				$keywords['and'][] = $tmp;
		} else if (substr_compare($word, "-", 0, 1) === 0) {
			$tmp = substr($word, 1);
			if (strlen($tmp) > 0)
				$keywords['not'][] = $tmp;
		} else {
			if (strlen($word) > 0)
				$keywords['default'][] = $word;
		}
	}

	return $keywords;
}
