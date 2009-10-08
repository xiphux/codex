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
    <td class="main"><strong>Title: </strong></td>
    <td>{if $chaptercount > 0}<a href="{$SCRIPT_NAME}?u=read&fic={$fic.id}">{$fic.title}</a>{else}{$fic.title}{/if}</td>
  </tr>
  <tr>
    <td><strong>{if count($fic_author) > 1}Authors{else}Author{/if}: </strong></td>
    <td>
      {foreach item=author name=authorfe from=$fic_author}{if !$smarty.foreach.authorfe.first}<br />{/if}
        <a href="{$SCRIPT_NAME}?u=author&aid={$author.author_id}">{if $author.author_name}{$author.author_name}{else}{$author.author_email}{/if}</a>
	{if $author.author_email && !$omitcontact}
	  {if $showemail}
	    &lt;<a href="mailto:{$author.author_email|strip_tags|strip:''}">{$author.author_email}</a>&gt;
	  {else}
	    [<a href="mailto:{$author.author_email|strip_tags|strip:''}">email</a>]
	  {/if}
	{/if}
	{if $author.author_website && !$omitcontact}
	  [<a href="{$author.author_website|strip_tags|strip:''}">{if $showwebsite}{$author.author_website}{else}web{/if}</a>]
	{/if}
      {foreachelse}
        Unknown
      {/foreach}
    </td>
  <tr>
  {if $chaptercount > 1}
  <tr>
    <td><strong>Chapters: </strong></td>
    <td>{$chaptercount}</td>
  </tr>
  {/if}
  <tr>
    <td><strong>Series: </strong></td>
    <td>{foreach item=series name=seriesfe from=$fic_series}{if !$smarty.foreach.seriesfe.first}, {/if}<a href="{$SCRIPT_NAME}?u=series&sid={$series.series_id}">{$series.series_title}</a>{/foreach}</td>
  </tr>
  <tr>
    <td><strong>{if count($fic_genre) > 1}Genres{else}Genre{/if}: </strong></td>
    <td>{foreach item=genre name=genrefe from=$fic_genre}{if !$smarty.foreach.genrefe.first}, {/if}<a href="{$SCRIPT_NAME}?u=genre&gid={$genre.id}">{$genre.name}</a>{/foreach}</td>
  </tr>
  {if $fic_matchup}
    <tr>
      <td><strong>{if count($fic_matchup) > 1 }Matchups{else}Matchup{/if}: </strong></td>
      <td>{foreach item=matchup name=matchupfe from=$fic_matchup}{if !$smarty.foreach.matchupfe.first}, {/if}<a href="{$SCRIPT_NAME}?u=matchup&mid={$matchup.matchup_id}">{$matchup.match1} + {$matchup.match2}</a>{/foreach}</td>
      </tr>
{/if}
{if $fic.sequel_to_title}
  <tr>
    <td><strong>Prequel: </strong></td>
    <td><a href="{$SCRIPT_NAME}?u=show&fic={$fic.sequel_to}">{$fic.sequel_to_title}</a></td>
  </tr>
{/if}
{if $fic.sequels}
  <tr>
    <td><strong>{if count($fic.sequels) > 1}Sequels{else}Sequel{/if}:</strong></td>
    <td>{foreach item=sequel name=sequelfe from=$fic.sequels}{if !$smarty.foreach.sequelfe.first}<br />{/if}<a href="{$SCRIPT_NAME}?u=show&fic={$sequel.id}">{$sequel.title}</a>{/foreach}</td>
  </tr>
{/if}
{if $fic.sidestory_to_title}
  <tr>
    <td><strong>Sidestory to: </strong></td>
    <td><a href="{$SCRIPT_NAME}?u=show&fic={$fic.sidestory_to}">{$fic.sidestory_to_title}</a></td>
  </tr>
{/if}
{if $fic.sidestories}
  <tr>
    <td><strong>{if count($fic.sidestories) > 1}Sidestories{else}Sidestory{/if}:</strong></td>
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
