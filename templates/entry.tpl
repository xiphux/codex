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
    <td><a href="{$SCRIPT_NAME}?u=read&fic={$fic_id}">{$fic_title}</a></td>
  </tr>
  <tr>
    <td><strong>Author: </strong></td>
    <td>
      {foreach item=author name=authorfe from=$fic_author}{if !$smarty.foreach.authorfe.first}<br />{/if}
        <a href="{$SCRIPT_NAME}?u=author&aid={$author.author_id}">{$author.author_name}</a>
	{if $author.author_email}
	  [<a href="mailto:{$author.author_email}">{$author.author_email}</a>]
	{/if}
	{if $author.author_website}
	  [<a href="{$author.author_website}">{$author.author_website}</a>]
	{/if}
      {foreachelse}
        Unknown
      {/foreach}
    </td>
  <tr>
  <tr>
    <td><strong>Chapters: </strong></td>
    <td>{$chaptercount}</td>
  </tr>
  <tr>
    <td><strong>Series: </strong></td>
    <td>{foreach item=series name=seriesfe from=$fic_series}{if !$smarty.foreach.seriesfe.first}, {/if}<a href="{$SCRIPT_NAME}?u=series&sid={$series.series_id}">{$series.series_title}</a>{/foreach}</td>
  </tr>
  <tr>
    <td><strong>Genre: </strong></td>
    <td>{foreach item=genre name=genrefe from=$fic_genre}{if !$smarty.foreach.genrefe.first}, {/if}<a href="{$SCRIPT_NAME}?u=genre&gid={$genre.genre_id}">{$genre.genre_name}</a>{/foreach}</td>
  </tr>
  {if $fic_matchup}
    <tr>
      <td><strong>Matchup: </strong></td>
      <td>{foreach item=matchup name=matchupfe from=$fic_matchup}{if !$smarty.foreach.matchupfe.first}, {/if}<a href="{$SCRIPT_NAME}?u=matchup&mid={$matchup.matchup_id}">{$matchup.match1} + {$matchup.match2}</a>{/foreach}</td>
    </tr>
  {/if}
  {if $fic_comments}
    <tr>
      <td></td>
      <td>
        <span class="italic">{$fic_comments}</span>
      </td>
    </tr>
  {/if}
</table>
</p>
