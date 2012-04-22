{*
 *  entry.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Fic data table template
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 *}
<p>
<table>
  <tr>
    <td class="main"><span class="label">Title: </span></td>
    <td>{if $chaptercount > 0}<a href="{$SCRIPT_NAME}?u=read&fic={$fic.id}">{$fic.title}</a>{else}{$fic.title}{/if}</td>
  </tr>
  <tr>
    <td><span class="label">{if count($fic_author) > 1}Authors{else}Author{/if}: </span></td>
    <td>
      {foreach item=author name=authorfe from=$fic_author}{if !$smarty.foreach.authorfe.first}<br />{/if}
        <a href="{$SCRIPT_NAME}?u=author&aid={$author.id}">{if $author.name}{$author.name}{else}{$author.email}{/if}</a>
	{if $author.email && !$omitcontact}
	  {if $showemail}
	    &lt;<a href="mailto:{$author.email|strip_tags|strip:''}">{$author.email}</a>&gt;
	  {else}
	    [<a href="mailto:{$author.email|strip_tags|strip:''}">email</a>]
	  {/if}
	{/if}
	{if $author.website && !$omitcontact}
	  [<a href="{$author.website|strip_tags|strip:''}">{if $showwebsite}{$author.website}{else}web{/if}</a>]
	{/if}
      {foreachelse}
        Unknown
      {/foreach}
    </td>
  <tr>
  {if $chaptercount > 1}
  <tr>
    <td><span class="label">Chapters: </span></td>
    <td>{$chaptercount}</td>
  </tr>
  {/if}
  {if $showviews}
  <tr>
    <td><span class="label">Views: </span></td>
    <td>{$views}</td>
  </tr>
  {/if}
  <tr>
    <td><span class="label">Words:</span></td>
    <td>{$wordcount}</td>
  </tr>
  <tr>
    <td><span class="label">Series: </span></td>
    <td>{foreach item=series name=seriesfe from=$fic_series}{if !$smarty.foreach.seriesfe.first}, {/if}<a href="{$SCRIPT_NAME}?u=series&sid={$series.id}">{$series.title}</a>{/foreach}</td>
  </tr>
  {if count($fic_genre) > 0}
  <tr>
    <td><span class="label">{if count($fic_genre) > 1}Genres{else}Genre{/if}: </span></td>
    <td>{foreach item=genre name=genrefe from=$fic_genre}{if !$smarty.foreach.genrefe.first}, {/if}<a href="{$SCRIPT_NAME}?u=genre&gid={$genre.id}">{$genre.name}</a>{/foreach}</td>
  </tr>
  {/if}
  {if $fic_matchup}
    <tr>
      <td><span class="label">{if count($fic_matchup) > 1 }Matchups{else}Matchup{/if}: </span></td>
      <td>{foreach item=matchup name=matchupfe from=$fic_matchup}{if !$smarty.foreach.matchupfe.first}, {/if}<a href="{$SCRIPT_NAME}?u=matchup&mid={$matchup.id}">{$matchup.matchup_name}</a>{/foreach}</td>
      </tr>
{/if}
{if $fic.sequel_to_title}
  <tr>
    <td><span class="label">Prequel: </span></td>
    <td><a href="{$SCRIPT_NAME}?u=show&fic={$fic.sequel_to}">{$fic.sequel_to_title}</a></td>
  </tr>
{/if}
{if $fic.sequels}
  <tr>
    <td><span class="label">{if count($fic.sequels) > 1}Sequels{else}Sequel{/if}:</span></td>
    <td>{foreach item=sequel name=sequelfe from=$fic.sequels}{if !$smarty.foreach.sequelfe.first}<br />{/if}<a href="{$SCRIPT_NAME}?u=show&fic={$sequel.id}">{$sequel.title}</a>{/foreach}</td>
  </tr>
{/if}
{if $fic.sidestory_to_title}
  <tr>
    <td><span class="label">Sidestory to: </span></td>
    <td><a href="{$SCRIPT_NAME}?u=show&fic={$fic.sidestory_to}">{$fic.sidestory_to_title}</a></td>
  </tr>
{/if}
{if $fic.sidestories}
  <tr>
    <td><span class="label">{if count($fic.sidestories) > 1}Sidestories{else}Sidestory{/if}:</span></td>
    <td>{foreach item=sidestory name=sidestoryfe from=$fic.sidestories}{if !$smarty.foreach.sidestoryfe.first}<br />{/if}<a href="{$SCRIPT_NAME}?u=show&fic={$sidestory.id}">{$sidestory.title}</a>{/foreach}</td>
  </tr>
{/if}
{if $fic.comments}
    <tr>
      <td></td>
      <td>
        <span class="italic">{$fic.comments}</span>
      </td>
    </tr>
  {/if}
</table>
</p>
