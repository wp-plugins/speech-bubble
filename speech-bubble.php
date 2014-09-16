<?php
/*
Plugin Name: Speech bubble (ふきだしプラグイン)
Description: Speech bubble (ふきだしプラグイン) can easily add speech bubble ornament in your post, without direct HTML&CSS coding. 
ふきだしプラグインは簡単に記事にふきだしを追加することが可能です。ショートコードを用いるため直接的なHTMLとCSSのコーディングは不要です。
Version: 1.0.2
Author: Masashi Sonobe, Mamoru Fukuda
License: GPLv2 or later
*/


/*
Copyright (C) 2014 Masashi Sonobe, Mamoru Fukuda

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

require_once dirname( __FILE__ ) . '/classes/SnbSpeechBubble.php';

new SnbSpeechBubble();
