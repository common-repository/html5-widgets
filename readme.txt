=== HTML5 Widgets ===
Contributors: danieliser
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DBATBLEQSEB2W
Tags: html5, widget, aside, section, nav, semantics
Requires at least: 3.0.1
Tested up to: 3.1.3
Stable tag: 0.9.1

This plugin allows you to change the DIV/Container element of each widget to one of the new HTML5 Semantic tags.

== Description ==

With many HTML5 themes out now users will need more control over their widgets to take full advantage of the new HTML5 Semantics. This plugin allows you to change the DIV/Container element of each widget to one of the new HTML5 Semantic tags.

= Tags Available = 
* Aside
* Section
* Nav

If you like the plugin please rate it.

[HTML5 Widgets](http://wizardinternetsolutions.com/plugins/html5-widgets/ "HTML5 Widgets Page - Info, Demo and Discussion") - Info & Feature Discussion

[Wizard Internet Solutions](http://wizardinternetsolutions.com/ "Website Design & Development") - Developers Site

To be notified of plugin updates, [follow us on Twitter](http://twitter.com/wizard_is "Wizard Internet Solutions on Twitter")!

== Installation ==

1. Upload `html5-widgets` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. On the `Widgets` page there will be a new box on each widget to allow you to choose its HTML5 Type.

== Frequently Asked Questions ==

= Will this work on every theme? =
Yes and no. This plugin will work modifying the containers, but themes like 'TwentyTen' use unordered lists `ul` to surround the widget areas and this will fail w3 validation since `<ul>` cannont contain elements other than `<li>`.

= How do you fix the twentyten theme to work with this? =
You can edit the sidebar.php file in the theme editor and remove `<ul class="xoxo">` and `</ul>` for both the primary and secondary widget areas. Leave the `<div>`s and you should now validate. 

== Screenshots ==

1. Widget Admin Options
2. View of Site and Source.

== Changelog ==

= 0.9.1 =
* Fixed issue with replacement method.

= 0.9 =
* Initial Release

== Upgrade Notice ==

= 0.9 =
* Initial Release