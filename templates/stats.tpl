{*
 *  stats.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Stats page system info template
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 *}
<p><strong><span class="underline">{$appstring}</span></strong>:
<br />Copyright (c) {$cdate} <a href="mailto:{$cauthor_email}">{$cauthor}</a>
<br />Distributed under the terms of the <a href="http://www.gnu.org/licenses/gpl.html">GNU General Public License</a>, v2 or later
</p>
<p><strong><span class="underline">System statistics:</span></strong>
<br /><strong>Server: </strong>{$server}
<br /><strong>Uname: </strong>{$uname}
<br /><strong>Uptime (days): </strong>{$uptime_days}
<br /><strong>Load average: </strong>{$loadavg}
</p>
{if $cachestats}
<p><strong><span class="underline">{$cachetype} statistics:</span></strong>
{foreach from=$cachestats key=type item=value}
<br /><strong>{$type}: </strong>{$value}
{/foreach}
</p>
{/if}
<p><strong><span class="underline">Data statistics:</span></strong>
<br /><strong>Fics: </strong>{$fics}
<br /><strong>Chapters: </strong>{$chapters}
<br /><strong>Authors: </strong>{$authors}
<br /><strong>Genres: </strong>{$genres}
<br /><strong>Series: </strong>{$series}
<br /><strong>Characters: </strong>{$characters}
<br /><strong>Matchups: </strong>{$matchups}
</p>
<p><strong><span class="underline">Database statistics:</span></strong></p>
