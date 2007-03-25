{*
 *  category.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Category header template
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
 *}
<p>
 <strong>
  <a href="{$SCRIPT_FILE}?u={$catsort}&{$catidtype}={$catid}">{$catname}</a></strong>
  {if $email}
    [<a href="mailto:{$email}">{$email}</a>]
  {/if}
  {if $website}
    [<a href="{$website}">{$website}</a>]
  {/if}
</p>
