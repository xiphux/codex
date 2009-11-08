<?php
/*
 * keyword_to_subquery.php
 * Codex: A PHP/MySQL fanfiction database
 * Component: keyword_to_subquery
 * Convert single keyword into a subquery union
 *
 * Copyright (C) 2009 Christopher Han <xiphux@gmail.com>
 */

function keyword_to_subquery($keyword, $casesensitive = false)
{
	global $tables;

	if (strlen($keyword) < 1)
		return;
	
	$titlefield = 'fictable.title';
	$authornamefield = 'authortable.name';
	$authoremailfield = 'authortable.email';
	$genrefield = 'genretable.name';
	$seriesfield = 'seriestable.title';
	$char1field = 'char1table.name';
	$char2field = 'char2table.name';
	if (!$casesensitive) {
		$titlefield = 'UPPER(' . $titlefield . ')';
		$authornamefield = 'UPPER(' . $authornamefield . ')';
		$authoremailfield = 'UPPER(' . $authoremailfield . ')';
		$genrefield = 'UPPER(' . $genrefield . ')';
		$seriesfield = 'UPPER(' . $seriesfield . ')';
		$char1field = 'UPPER(' . $char1field . ')';
		$char2field = 'UPPER(' . $char2field . ')';
	}

	if (!$casesensitive)
		$keyword = strtoupper($keyword);

	$titlequery = "SELECT id FROM " . $tables['fics'] . " AS fictable WHERE " . $titlefield . " LIKE '%" . $keyword . "%'";

	$authorquery = "SELECT fic_id AS id FROM " . $tables['fic_author'] . " AS ficauthortable LEFT JOIN " . $tables['authors'] . " AS authortable ON ficauthortable.author_id = authortable.id WHERE " . $authornamefield . " LIKE '%" . $keyword . "%' OR " . $authoremailfield . " LIKE '%" . $keyword . "%'";

	$genrequery = "SELECT fic_id AS id FROM " . $tables['fic_genre'] . " AS ficgenretable LEFT JOIN " . $tables['genres'] . " AS genretable ON ficgenretable.genre_id = genretable.id WHERE " . $genrefield . " LIKE '%" . $keyword . "%'";

	$seriesquery = "SELECT fic_id AS id FROM " . $tables['fic_series'] . " AS ficseriestable LEFT JOIN " . $tables['series'] . " AS seriestable ON ficseriestable.series_id = seriestable.id WHERE " . $seriesfield . " LIKE '%" . $keyword . "%'";

	$matchupquery = "SELECT fic_id AS id FROM " . $tables['fic_matchup'] . " AS ficmatchuptable LEFT JOIN " . $tables['matchups'] . " AS matchuptable ON ficmatchuptable.matchup_id = matchuptable.id LEFT JOIN " . $tables['characters'] . " AS char1table ON matchuptable.character1 = char1table.id LEFT JOIN " . $tables['characters'] . " AS char2table ON matchuptable.character2 = char2table.id WHERE " . $char1field . " LIKE '%" . $keyword . "%' OR " . $char2field . " LIKE '%" . $keyword . "%'";

	$query = '(' . $titlequery . ' UNION DISTINCT ' . $authorquery . ' UNION DISTINCT ' . $genrequery . ' UNION DISTINCT ' . $seriesquery . ' UNION DISTINCT ' . $matchupquery . ')';

	return $query;
}
