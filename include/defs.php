<?php
/*
 *  defs.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Definitions
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

 define('CODEX_TITLE',1);
 define('CODEX_AUTHOR',2);
 define('CODEX_SERIES',4);
 define('CODEX_GENRE',8);
 define('CODEX_MATCHUP_1',16);
 define('CODEX_MATCHUP_2',32);
 define('CODEX_ALL', CODEX_TITLE | CODEX_AUTHOR | CODEX_SERIES | CODEX_GENRE | CODEX_MATCHUP_1 | CODEX_MATCHUP_2);

?>
