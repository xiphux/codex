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
{foreach from=$tablelist item=table}
<p>
<strong>Table: </strong>{$table.Name}<br />
{if $table.Engine}
<strong>Engine: </strong>{$table.Engine}<br />
{/if}
{if $table.Type}
<strong>Type: </strong>{$table.Type}<br />
{/if}
{if $table.Version}
<strong>Version: </strong>{$table.Version}<br />
{/if}
{if $table.Row_format}
<strong>Row format: </strong>{$table.Row_format}<br />
{/if}
{if $table.Rows}
<strong>Rows: </strong>{$table.Rows}<br />
{/if}
{if $table.Avg_row_length}
<strong>Average row length: </strong>{$table.Avg_row_length}<br />
{/if}
{if $table.Data_length}
<strong>Data length: </strong><span title="{$table.Data_length}">{$table.Data_length}</span><br />
{/if}
{if $table.Max_data_length}
<strong>Max data length: </strong><span title="{$table.Max_data_length}">{$table.Max_data_length}</span><br />
{/if}
{if $table.Index_length}
<strong>Index length: </strong><span title="{$table.Index_length}">{$table.Index_length}</span><br />
{/if}
{if $table.Data_free}
<strong>Data free: </strong>{$table.Data_free}<br />
{/if}
{if $table.Auto_increment}
<strong>Auto increment: </strong>{$table.Auto_increment}<br />
{/if}
{if $table.Create_time}
<strong>Create time: </strong>{$table.Create_time}<br />
{/if}
{if $table.Update_time}
<strong>Update time: </strong>{$table.Update_time}<br />
{/if}
{if $table.Check_time}
<strong>Check time: </strong>{$table.Check_time}<br />
{/if}
{if $table.Collation}
<strong>Collation: </strong>{$table.Collation}<br />
{/if}
{if $table.Checksum}
<strong>Checksum: </strong>{$table.Checksum}<br />
{/if}
{if $table.Create_options}
<strong>Create options: </strong>{$table.Create_options}<br />
{/if}
{if $table.Comment}
<strong>Comment: </strong>{$table.Comment}<br />
{/if}
{if $table.total_size}
<strong>Total size: </strong><span title="{$table.total_size}">{$table.total_size}</span><br />
{/if}
</p>
{/foreach}
<p><strong>Total database size: </strong><span title="{$dbsize}">{$dbsize}</span></p>
