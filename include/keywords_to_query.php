<?php
/*
 * keywords_to_query.php
 * Codex: A PHP/MySQL fanfiction database
 * Component: keywords_to_query
 * Convert keyword array into SQL criteria
 *
 * Copyright (C) 2009 Christopher Han <xiphux@gmail.com>
 */

include_once('keyword_to_subquery.php');

function keywords_to_query($keywords, $casesensitive = false)
{
	if (!isset($keywords))
		return;

	$query = "";

	if (isset($keywords['default'])) {
		foreach ($keywords['default'] as $word) {
			if (strlen($word) > 0) {
				$tmpquery = keyword_to_subquery($word);

				if (strlen($query) > 0)
					$query .= ' AND ';

				$query .= 'id = ANY ' . $tmpquery;
			}
		}
	}

	if (isset($keywords['and'])) {
		foreach ($keywords['and'] as $word) {
			if (strlen($word) > 0) {
				$tmpquery = keyword_to_subquery($word);

				if (strlen($query) > 0)
					$query .= ' AND ';

				$query .= 'id = ANY ' . $tmpquery;
			}
		}
	}

	if (isset($keywords['not'])) {
		foreach ($keywords['not'] as $word) {
			if (strlen($word) > 0) {
				$tmpquery = keyword_to_subquery($word);

				if (strlen($query) > 0)
					$query .= ' AND ';

				$query .= 'NOT id = ANY ' . $tmpquery;
			}
		}
	}

	return $query;
}
