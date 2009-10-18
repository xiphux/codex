{*
 *  toc.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Fic table of contents template
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 *}
<table class="chaptertable">
<thead>
<tr><th class="chapnameheader">Chapter</th><th class="chapviewsheader">Views</th></tr>
</thead>
<tbody>
{foreach from=$chapters item=chap}
 <tr>
  <td class="chapname"><a href="{$SCRIPT_NAME}?u=read&fic={$ficid}&ch={$chap.num}">{if $chap.title}{$chap.title}{else}Chapter {$chap.num}{/if}</a></td>
  <td class="chapviews"><span class="italic">{$chap.views}</span></td>
 </tr>
{foreachelse}
 <tr>
  <td class="chapname"><span class="italic">No chapters</span></td>
  <td class="chapviews"></td>
 </tr>
{/foreach}
</tbody>
</table>
