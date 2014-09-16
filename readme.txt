=== Speech Bubble (吹き出しプラグイン) ===
Contributors: snb arisoude-nakatta,Mamoru Fukuda
Tags:Speech Bubble Posts
Requires at least: 3.7.1
Tested up to: 3.7.1
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy to add Speech bubbles in your post.


== Description ==
You can easily add speech bubble ornament in your post, without direct HTML&CSS coding.

<h3>Features</h3>
<ul>
<li>Ornament your posts with speech bubbles (like Chat,Act,lect.,etc)</li>
<li>9 pattern speech bubbles are available (at version 1.0)</li>
<li>Fit narrow frame automatically</li>
<li>By short code, use speech bubble.</li>
<li>Quickly use them without using direct HTML&CSS code and database</li>
<li>In a post, you can use same speach bubble more easily (Preset Type)</li>
<li>Not support IE8</li>
</ul>

[Example and How to use Page](http://www.arisoude-nakatta.com/wp-speech-bubble-plugin-toc-v-1-0-en/ "Example and How to use")

[Japanse explanation](http://www.arisoude-nakatta.com/wp-speech-bubble-plugin-toc-v-1-0-jp/ "")

== Installation ==

<ol>
<li>See WordPress ControlPanel.</li>
<li>Log in.</li>
<li>Click Plugin->Add New.</li>
<li>Search Speech Bubble Plugin</li>
<li>Click Active Plugin button.</li>
</ol>

You can use Speach bubbles in your post.

== Frequently Asked Questions ==

= How to add new icon  =
Upload to speach-bubble/img/ folder.

= How to use "Quick" type short code  =

Write the below example to post by "Text mode".

<code>
[speech_bubble type="std" subtype="a" icon="1.jpg" name="A san" ]Ask something. [/speech_bubble]
[speech_bubble type="std" subtype="b" icon="2.jpg" name="B san" ]Answer something.[/speech_bubble]
[speech_bubble type="std" subtype="c" icon="1.jpg" name="A san" ]Think something. [/speech_bubble]
[speech_bubble type="std" subtype="d" icon="2.jpg" name="A san" ]Think something, too.[/speech_bubble]
</code>

<p>type:    std, fb, fb-flat,ln,ln-flat,pink, rtail,drop, think</p>
<p>subtype: a,b,c,d </p>
<p>icon:    Use images in "speach-bubble/img/" folder.</p>

<br>
= How to use "ID preset" type short code  =
 Write the below example to post by "Text mode".

<code>
[speech_bubble_preset]
{sb_id=11:type=std ,subtype=left1,icon=1.jpg,name=Antonio}
{sb_id=22A:type=st d, subtype=right1,icon=2.jpg,name=Sebastian}
{sb_id=33:type=std ,subtype=left2,icon=1.jpg,name=Antonio}
{sb_id=44:type=st d, subtype=right2,icon=2.jpg,name=Sebastian}
{SPEECH_BUBBLE_DELIMITER}
[speech_bubble_id sb_id=11]Ask something. [/speech_bubble_id]
[speech_bubble_id sb_id=22A]Answer something.[/speech_bubble_id]
[speech_bubble_id sb_id=33]Think something. [/speech_bubble_id]
[speech_bubble_id sb_id=44]Think something, too.[/speech_bubble_id]
[/speech_bubble_preset]</code>

<p>subtype: a,b,c,d,L1,R1,L2,R2,left1,right1,left2,right2 </p>
<p>This {:} section is for preset id. Write this section from [speech_bubble_useid] to {SPEECH_BUBBLE_DELIMITER}.</p>
<br>

= These short code doesn't work well. Why? =
<p> We think it cause maybe by miss type.</p>
<p>Use Developer tools -> element and Search next message in html (for example in chrome)</p>
<ul>
<li>"SB_ALERT_TYPE_MISSING"</li>
<li>"SB_ALERT_SUBTYPE_MISSING"</li>
<li>"SB_ALERT_ICON_EXTENSION_MISSING"</li>
<li>"SB_ALERT_DELIMITER_MISSING"</li>
</ul>
<p>These code will help you.</p>
<br>

= These short code doesn't work well. Why? (in ID preset type) =
<p> We think it maybe cause by miss type, too. But ID preset type is more complicated. </p>
<p>And, then we prepare the analysing flag for preset type. Input like,</p>
<code>
[speech_bubble_preset id_analysis="ON"]
{sb_id=11:type=ste ,subtype=left1,icon=1.jpg,name=Antonio}
{SPEECH_BUBBLE_DELIMITER}
[speech_bubble_id sb_id=11]Ask something. [/speech_bubble_id]
[/speech_bubble_preset]
</code>
Show the analysed result like below in your post.
<code>
---SPEECH_BUBBLE_ID_ANALYSIS_START---
sb_id=0001
=>type="std" subtype="a" icon="1.jpg" name="A san"
sb_id=0002
=>type="std" subtype="b" icon="2.jpg" name="B san"
sb_id=11
=>type="SB_ALERT_TYPE_MISSING" subtype="a" icon="1.jpg" name="Antonio"
---SPEECH_BUBBLE_ID_ANALYSIS_END---
</code>

<p>In this example, I do miss type type=<strong>"ste"</strong>(std:correct), and show type="SB_ALERT_TYPE_MISSING".</p>
<p>sb_id=0001 and sb_id=0002 are default preset id.</p>
<p> Also use id_analysis = "OFF", If this flag is off, this short code work as normal ID preset type.</p>
<br>


= Using ID preset type, line's oreder is little bit upset. Why? =
<p>We know this sympton, and couldn't pursue the exact cause of it. One of example is below,</p>

<code>
FIRST
[speech_bubble_preset id_analysis="ON"]
{sb_id=11:type=std,subtype=left1,icon=1.jpg,name=Antonio}
{SPEECH_BUBBLE_DELIMITER}
SECOND
[speech_bubble_id sb_id=11]Ask something. [/speech_bubble_id]
[/speech_bubble_preset]
THIRD
</code>

Result of above code.
<code>
SECOND
"SpeechBubble"
FIRST
THIRD
</code>

<p>We have Two solution for this</p>

Solution 1. Use all FIRST,SECOND,THIRD  in speech_bubble_preset shortcode.
<code>
[speech_bubble_preset id_analysis="ON"]
{sb_id=11:type=std,subtype=left1,icon=1.jpg,name=Antonio}
{SPEECH_BUBBLE_DELIMITER}
FIRST
SECOND
THIRD
[speech_bubble_id sb_id=11]Ask something. [/speech_bubble_id]
[/speech_bubble_preset]
</code>

Solution 2. Use FIRST,SECOND in speech_bubble_preset shortcode, and THIRD is used in lower outside of shortcode.
<code>
[speech_bubble_preset id_analysis="ON"]
{sb_id=11:type=std,subtype=left1,icon=1.jpg,name=Antonio}
{SPEECH_BUBBLE_DELIMITER}
FIRST
SECOND
[speech_bubble_id sb_id=11]Ask something. [/speech_bubble_id]
[/speech_bubble_preset]
THIRD(outside of shortcode)
</code>



== Screenshots ==
1. Example, using  type="std".
1. Fit narrow frame automatically, use type="std". 
1. Short code sample
1. Using type="drop", please try other type!


== Upgrade Notice ==

Make back up of added images by yourself.

== Changelog ==

= var 1.0.2 - Bug Fix =
<ul>
<li>subtype L1,R1,L2,R2 and left1, rigth1, left2, right2 were unavailable in single shortcode.</li>
</ul>

= var 1.0.0 - Newly created =
<ul>
<li>9 design patterns are available</li>
<li>9 pattern :std, fb, fb_flat,ln,ln_flat,pink, rtail,drop, think</li>
<li>2 type short codes are available</li>
<li>2 type : "Quick", "ID preset"</li>
</ul>

