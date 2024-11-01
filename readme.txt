=== Cubilis Fastbooker - Wordpress plugin ===

Contributors: stardekk
Tags: stardekk, cubilis, logis manager, logismanager, Fastbooker, booker, hospitality, hostel, travel, bed & breakfast, cubilis booking engine
Requires at least: 3.0.1
Tested up to: 6.1
Stable tag: 2.4.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Cubilis Fastbooker widget allows you to easily integrate the Cubilis Booking Engine on your website. Using this widget, visitors are able to find available rooms based on their arrival and departure date. An active Cubilis subscription is required, please contact sales@stardekk.be if you don't have an activate account yet.

== Installation ==

1. Download and extract the stardekk-cubilis-fastbooker.zip file.
2. Place the stardekk-cubilis-fastbooker folder into wp-content/plugins.
3. In the Wordpress admin page, activate the plugin in the plugin menu.
4. Configure your Fastbooker plugin in the new Cubilis menu.
4.1. The Cubilis identifier is a unique identity provided by Stardekk. If you don't have a Cubilis identifier, please contact stardekk on web.support@stardekk.be.
5. Place a Cubilis Fastbooker widget on your page by going to the widget menu.
5.1 Within the available widgets you will now see Cubilis Fastbooker Widget.
5.2 You can now drag this widget to the appropriate place within your template.
5.3 Once you have dragged the widget into the template, you can configure widget colors and title.
5.4 Click on 'save' and then the Cubilis Fastbooker will be active on your web page in the desired section.

== Changelog ==

1. v1.0.0 Fix javascript target _blank (fullscreen integration)
1. v1.0.1 Fix shortlocale
1. v1.0.2 Fix css height for internet explorer
1. v1.0.3 Fix changelog for version 1.0.2
1. v1.0.4 Fix internalization when plugin loaded
1. v1.0.5 Tested for Wordpress 4.4.2
1. v1.0.6 Added dynamic plugin dir for enqueue assets
1. v1.0.7 Added fix ui-datepicker css (z-index 999999 !important)
1. v1.0.8 Refactor is url exists function
1. v1.0.9 Change dutch translation 'reservatie' to 'reservering'
1. v2.0.0 Updated user interface for better user experience and updated datepicker widget with more options and a clearer datepicker calender.
1. v2.1.0 Security check, bug fixes and small rewrite of scripts and style enqueues to work better with some plugins.
1. v2.1.1 Fixed default color sheme for fastbooker
1. v2.1.2 Fixed text-domain name
1. v2.1.3 Fixed discount code bug where discount code would not go through
1. v2.2.0 Added multi language support for the widget title. (Can be used by installing a language plugin like WPML or Polylang)
1. v2.2.1 Added some default styling so other non well specified css from external stylehseets overwrites ours
1. v2.2.2 Fixed a bug where the selectbox for the default language would not show the stored default language in the database 
1. v2.3.0 Fixed a critical bug with the date format where dates under 10 would not get a preceeding zero
1. v2.4.0 Fixed a critical bug with the date format where selecting two dates in different months would only use the first date's month