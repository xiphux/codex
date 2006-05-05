{*
 *  root.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Root page template
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Library General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 *
 *  $Id: root.tpl 370 2006-03-08 20:08:20Z xiphux $
 *}
<p>
{$title}
{if $stats}
  <br />[<a href="{$SCRIPT_NAME}?u=stats">stats</a>]
{/if}
{if $dbperfmon}
  <br />[<a href="{$SCRIPT_NAME}?u=dbperfmon">dbperfmon</a>]
{/if}
</p>
<p>Sort by:<br />
<a href="{$SCRIPT_NAME}?u=title">Title</a><br />
<a href="{$SCRIPT_NAME}?u=author">Author</a><br />
<a href="{$SCRIPT_NAME}?u=series">Series</a><br />
<a href="{$SCRIPT_NAME}?u=genre">Genre</a><br />
<a href="{$SCRIPT_NAME}?u=matchup">Matchup</a><br />
</p>
<p>Search for:<br />
<form action="{$SCRIPT_NAME}?u=search" method="post">
<input type="text" name="search" />
<input type="submit" name="submit" value="Search" />
</form>
</p>
