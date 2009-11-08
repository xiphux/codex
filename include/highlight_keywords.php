<?php
/*
 * highlight_keywords.php
 * Codex: A PHP/MySQL fanfiction database
 * Component: highlight_keywords
 * Loop through and highlight all keywords in a string
 *
 * Copyright (C) 2009 Christopher Han <xiphux@gmail.com>
 */

function highlight_keywords(&$string, $keywords, $type = "searchtext", $skipparens = false)
{
	if (!isset($keywords))
		return;

	if (isset($keywords['default'])) {
		foreach ($keywords['default'] as $word) {
			highlight($string, $word, $type, $skipparens);
		}
	}

	if (isset($keywords['and'])) {
		foreach ($keywords['and'] as $word) {
			highlight($string, $word, $type, $skipparens);
		}
	}
}
