<?php
/*
 *  codex.conf.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: PHP viewer script configuration
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

/*
 * smarty_prefix
 * This is the prefix where smarty is installed.
 * (including trailing slash)
 * If an absolute (starts with /) path is given,
 * Smarty.class.php will be searched for in that directory.
 * If a relative (doesn't start with /) path is given,
 * that subdirectory inside the php include dirs will be
 * searched.  So, for example, if you specify the path as
 * "/usr/share/Smarty/" then the script will look for
 * /usr/share/Smarty/Smarty.class.php.
 * If you specify the path as "smarty/" then it will search
 * the include directories in php.ini's include_path directive,
 * so it would search in places like /usr/share/php and /usr/lib/php:
 * /usr/share/php/smarty/Smarty.class.php,
 * /usr/lib/php/smarty/Smarty.class.php, etc.
 * Leave blank to just search in the root of the php include directories
 * like /usr/share/php/Smarty.class.php, /usr/lib/php/Smarty.class.php, etc.
 */
$codex_conf['smarty_prefix'] = "smarty/";

/*
 * adodb_prefix
 * This is the prefix where adodb is installed.
 * Behaves the same way as smarty_prefix, but specifies
 * location of adodb_inc.php.
 */
$codex_conf['adodb_prefix'] = "adodb/";

 /*
  * Database connection settings
  */
 $codex_conf['db_type'] = "mysqli";
 $codex_conf['db_host'] = "localhost";
 $codex_conf['db_user'] = "codex";
 $codex_conf['db_pass'] = "hzt2xJFcsfwLw56H";
 $codex_conf['database'] = "codex";

 /*
  * Persistent database connection
  * Persistent database conections will remain
  * open and be reused, instead of reconnecting each
  * time a page loads.  However, it could cause problems
  * on a heavily loaded server with lots of connections
  * left open.
  */
 $codex_conf['persist'] = FALSE;

 /*
  * Table prefix
  * In case you have an extra string appended
  * to the front of the table names to separate
  * them from other tables, put it here.
  * So, for example, setting the prefix to
  * "codex_" would make the table names
  * "codex_fics", "codex_fic_author", etc.
  * If you don't want a prefix just leave it empty.
  */
 $codex_conf['prefix'] = "";

 /*
  * Adodb cache
  * Whether to use ADOdb caching
  * Note: caching is only recommended if your database server
  * is much slower than your web server, or your database server
  * is very overloaded.  Otherwise it could reduce performance.
  */
 $codex_conf['adodbcache'] = FALSE;

 /*
  * Adodb cache dir
  * Where adodb will cache its queries
  */
 $ADODB_CACHE_DIR = "cache";

 /*
  * Adodb cache timeout
  * Number of seconds a query will be cached for
  */
 $codex_conf['secs2cache'] = 10;

 /*
  * Base path containing fic text files
  * Can be an absolute path or relative path
  * Don't forget trailing slash
  */
 $codex_conf['basepath'] = "fics/";

 /*
  * This is the string that will be displayed at the top of the page
  * and in the page title.  The variable '$codex_appstring' will
  * expand to the name (codex) and version. '$codex_version' will
  * expand to the version only
  */
 $codex_conf['title'] = "centraldogma :: $codex_appstring";

 /*
  * If enabled, a 'stats' link will appear on the main page with
  * various system / database statistics
  */
 $codex_conf['stats'] = TRUE;

 /*
  * If enabled, the stats page will call 'OPTIMIZE' on each table
  * before displaying information
  */
 $codex_conf['optimize'] = TRUE;

 /*
  * If enabled, lemon fics will be shown.
  */
 $codex_conf['lemons'] = TRUE;

 /*
  * Spellcheck
  * If enabled, spelling will be dynamically fixed.
  * See below for patterns.
  */
 $codex_conf['spellcheck'] = TRUE;

 /*
  * Spellcheck dictionary
  * List of spelling errors to fix, in perl regexp form.
  * The pattern is the array key, and the replacement is the
  * value.  So $spellcheck["/foo/"] = "bar" will replace all
  * occurrences of "foo" with "bar".
  */
 $spellcheck["/([Dd])efinate/"] = "$1efinite";
 $spellcheck["/([Dd])ependant/"] = "$1ependent"; // Not technically wrong, but still pisses me off
 $spellcheck["/([Dd])iscribe/"] = "$1escribe";
 $spellcheck["/([Dd])issapoint/"] = "$1isappoint";
 $spellcheck["/([Dd])issapear/"] = "$1isappear";
 $spellcheck["/Irregardless/"] = "Regardless";
 $spellcheck["/irregardless/"] = "regardless";
 $spellcheck["/,br>/"] = "\n";
 $spellcheck["/([Tt])hw /"] = "$1he ";
 $spellcheck["/&lt;?/"] = "<";
 $spellcheck["/&gt;?/"] = ">";

 /*
  * Debug
  * Show debug messages
  * Warning: debugging dumps a lot of information on the web page,
  * some of it sensitive database information.  Do not enable this
  * unless something is very wrong, and do not allow other users
  * to access the site with debugging on.
  */
 $codex_conf['debug'] = FALSE;

 /*
  * session_key
  * The key inside the session variable to use for session data
  */
 $codex_conf['session_key'] = "codex";

/*
 * theme
 * This is the default theme to use
 * Specified as the name of a css file in css/themes,
 */
$codex_conf['theme'] = "dark.css";

/*
 * unwrap
 * Attempt to unwrap fics marked as word-wrapped
 */
$codex_conf['unwrap'] = TRUE;

 /*
  * cachetype
  * Type of cache to use
  * Valid values are:
  *  "memcache" = connect to memcached, refer to
  *               config options below beginning
  *               with "memcached"
  *  "eaccelerator" = use eaccelerator caching
  *                   must have eaccelerator
  *                   installed with shared memory
  *                   enabled
  *  "filecache" = use on-disk cache
  *                refer to config options below
  *                beginning with "filecache"
  *  Any other unrecognized value (such as FALSE,
  *  null, "off", "none", etc) will disable cache
  */
 $codex_conf['cachetype'] = "off";

 /*
  * filecache_dir
  * Directory to store filecache data
  * Make sure to include trailing slash!
  * Paths that do not start with a slash will
  * be relative to the index.php file
  * This directory must exist and be writable
  * by the webserver!
  * Only used if cachetype is "filecache"
  */
 $codex_conf['filecache_dir'] = "cache/";

 /*
  * Memcached address
  * Address of memcached server
  * Only used if cachetype is "memcache"
  */
 $codex_conf['memcached_address'] = "127.0.0.1";

 /*
  * Memcached port
  * Port of memcached server
  * Only used if cachetype is "memcache"
  */
 $codex_conf['memcached_port'] = 11211;

 /*
  * Memcached persist
  * Whether to use a persistent connection to Memcached
  * Only used if cachetype is "memcache"
  */
 $codex_conf['memcached_persist'] = FALSE;

 /*
  * Fuzzy search threshold
  * If search produces no exact results, it will attempt
  * a fuzzy search with this threshold of acceptable
  * character differences between searched and matched
  * word.
  * Please note that fuzzy search can be computationally
  * expensive.  Set this to 0 to disable fuzzy search.
  */
 $codex_conf['fuzzysearchthreshold'] = 2;

 /**
  * Stylize
  *
  * Attempt to translate common text emphasis into HTML
  * styles.  For example, surrounding underscores:
  *  _good_
  * would be italicized.
  */
 $codex_conf['stylize'] = TRUE;

 /**
  * Show email
  *
  * Whether to show the email of the author.  If false,
  * will just show an 'email' link rather than displaying
  * the full email address
  */
 $codex_conf['showemail'] = TRUE;

 /**
  * Show website
  *
  * Whether to show the website address of the author.
  * If false, will just show a 'web' link rather than
  * displaying the full web address
  */
 $codex_conf['showwebsite'] = TRUE;

 /**
  * Pad lines
  *
  * If set to true, will attempt to pad lines of densely
  * packed text with extra line breaks to aid readability
  */
 $codex_conf['padlines'] = TRUE;

?>
