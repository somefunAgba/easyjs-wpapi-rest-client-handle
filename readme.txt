=== node-WPAPI wp Global Handle for the WP REST-API ===
Contributors: oluwasegun27
Donate link: oluwasegun.somefun@yahoo.co.uk 
Tags: wpapi, basic authentication, cookie authentication, node-wpapi, js client, wp rest-api
Requires at least: 4.8
Tested up to: 4.8.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

# node-WPAPI wp Global Handle
== Description ==
-Access the WP REST API in any javascript file using the 'wp' global object directly.
-WP Cookies and Basic Authentication handler for the WP REST API, using NODE-WP-API client. It is used for development,
debugging purposes, and if user likes, maybe for production.
-It uses Cookie Authentication when the admin is logged in to WP but switches to Basic Authentication when the admin is logged out of WP.

# Warning:
/**
 * This plugin includes code from the JSON Basic Authentication Plugin.
 * So JSON Basic Authentication plugin must not be installed else WP throws a conflict.
**/

## Install
== Installation ==
1. Download the plugin into your plugins directory.
2. Go to Plugins Dashboard. Activate 'NODE-WPAPI JS-CLIENT Install and Authentication'
3. The Plugin is now activated, under it are the links: Settings | Deactivate | Edit
4. Click on this Settings link or on the Wordpress Dashboard, Click on the "Node-WPAPI Authentication" 
sub-menu of the Settings menu.
5. Enter any Administrator username and password, to validate Basic Authentication.
6. Go to your live site. e.g: http://wpsite.com or http://localhost:8080
7. Check your browser console: If your administrator's name is Matt, then you should see a console output:
"Matt! I am set to access the WP REST-API!"
8. You are all set. 
9. Open any .js script and start accessing the WP REST API via the node-wpapi client

		e.g : To get all the posts on your wordpress model site. 
		wp.posts().embed().get().then(function( response ) {
			console.log( response );
			//do something with returned data
		    }); 

* See http://wp-api.org/node-wpapi/ for more info.
N.B: 
-Mozilla Browser Console: Tools > Web Developer > Web Console
-Chrome Browser Console: More Tools > Dveloper Tools > Console

== Frequently Asked Questions ==

=What is the REST-API?=

* Check up : https://developer.wordpress.org/rest-api/

=Why should I use node-wpapi.js client?=

* Check up: http://wp-api.org/node-wpapi/

=What does this plugin do?=
## Use:
* Accesses the node-wpapi's 'wpapi.js' functionality
* Then makes variable 'wp' globally accessible and authenticated for use in all WP .js scripts to access the WP REST API
* both when an admin. user is logged in and out of WP.
== Screenshots ==

1. nodewpapi-console.png
2. nodewpapi-options-page.png

== Changelog ==

= 1.0 =
** First version : 
* Installs the node-wpapi.js CLIENT
* Serves as a Cookie and Basic Authentication handler for the WP REST API, using the node-wpapi client
* Access the WP REST API in any javascript file using the 'wp' global object directly.


== Upgrade Notice ==

= 1.0 =
This is the first version of this plugin.


