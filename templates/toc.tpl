{*
 *  toc.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Fic table of contents template
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 *}
<div>
{$fic.fic_title} by {foreach item=author name=authorfe from=$author}{if !$smarty.foreach.authorfe.first}, {/if}{$author.author_name}{foreachelse}Unknown{/foreach}
</div>
<ul>
{foreach from=$chapters item=chap}
<li><a href="{$SCRIPT_NAME}?u=read&fic={$fic.fic_id}&ch={$chap.num}">{if $chap.title}{$chap.title}{else}Chapter {$chap.num}{/if}</a></li>
{foreachelse}
<li>No chapters</li>
{/foreach}
</ul>
