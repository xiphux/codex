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
<p><span class="underline label">System statistics:</span>
<br /><span class="label">Server: </span>{$server}
<br /><span class="label">Uname: </span>{$uname}
<br /><span class="label">Uptime (days): </span>{$uptime_days}
<br /><span class="label">Load average: </span>{$loadavg}
</p>
{if $cachestats}
<p><span class="underline label">{$cachetype} statistics:</span>
{foreach from=$cachestats key=type item=value}
<br /><span class="label">{$type}: </span>{$value}
{/foreach}
</p>
{/if}
<p><span class="underline label">Data statistics:</span>
<br /><span class="label">Fics: </span>{$fics}
<br /><span class="label">Chapters: </span>{$chapters}
<br /><span class="label">Authors: </span>{$authors}
<br /><span class="label">Genres: </span>{$genres}
<br /><span class="label">Series: </span>{$series}
<br /><span class="label">Characters: </span>{$characters}
<br /><span class="label">Matchups: </span>{$matchups}
</p>
<p><span class="underline label">Database statistics:</span></p>
{foreach from=$tablelist item=table}
<p>
<span class="label">Table: </span>{$table.Name}<br />
{if $table.Engine}
<span class="label">Engine: </span>{$table.Engine}<br />
{/if}
{if $table.Type}
<span class="label">Type: </span>{$table.Type}<br />
{/if}
{if $table.Version}
<span class="label">Version: </span>{$table.Version}<br />
{/if}
{if $table.Row_format}
<span class="label">Row format: </span>{$table.Row_format}<br />
{/if}
{if $table.Rows}
<span class="label">Rows: </span>{$table.Rows}<br />
{/if}
{if $table.Avg_row_length}
<span class="label">Average row length: </span>{$table.Avg_row_length}<br />
{/if}
{if $table.Data_length}
<span class="label">Data length: </span><span title="{$table.Data_length}">{$table.Data_length}</span><br />
{/if}
{if $table.Max_data_length}
<span class="label">Max data length: </span><span title="{$table.Max_data_length}">{$table.Max_data_length}</span><br />
{/if}
{if $table.Index_length}
<span class="label">Index length: </span><span title="{$table.Index_length}">{$table.Index_length}</span><br />
{/if}
{if $table.Data_free}
<span class="label">Data free: </span>{$table.Data_free}<br />
{/if}
{if $table.Auto_increment}
<span class="label">Auto increment: </span>{$table.Auto_increment}<br />
{/if}
{if $table.Create_time}
<span class="label">Create time: </span>{$table.Create_time}<br />
{/if}
{if $table.Update_time}
<span class="label">Update time: </span>{$table.Update_time}<br />
{/if}
{if $table.Check_time}
<span class="label">Check time: </span>{$table.Check_time}<br />
{/if}
{if $table.Collation}
<span class="label">Collation: </span>{$table.Collation}<br />
{/if}
{if $table.Checksum}
<span class="label">Checksum: </span>{$table.Checksum}<br />
{/if}
{if $table.Create_options}
<span class="label">Create options: </span>{$table.Create_options}<br />
{/if}
{if $table.Comment}
<span class="label">Comment: </span>{$table.Comment}<br />
{/if}
{if $table.total_size}
<span class="label">Total size: </span><span title="{$table.total_size}">{$table.total_size}</span><br />
{/if}
</p>
{/foreach}
<p><span class="label">Total database size: </span><span title="{$dbsize}">{$dbsize}</span></p>
