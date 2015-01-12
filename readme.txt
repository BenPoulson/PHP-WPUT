=== WordPress Unit Testing (WPUT) ===
Contributors: (this should be a list of wordpress.org userid's)
Tags: TDD, Unit Testing, Testing
Requires at least: 3.0.1
Tested up to: 4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WPUT is a simple way of adding Unit Tests into WordPress

== Description ==

**WPUT** is a simple way of adding Unit Tests into [WordPress](http://wordpress.org "WordPress"). Just install the plugin, add in your tests, then navigate to the WP-UT tab within the admin menu.

Hook into the `init` through any method you choose, and start adding tests!

    add_action('init', 'example_tests');
	add_action('admin_init', 'example_tests');
	function example_tests() {
	
		/* Check using WP's version checker, to see if we're up to date */
		WPUT::test('CoreTests', 'WordPress up-to-date', function(){
			return file_get_contents('http://api.wordpress.org/core/version-check/1.0/?version=' . get_bloginfo('version')) == 'latest';
		});
		/* Is the uploads folder writable? */
		WPUT::test('CoreTests', 'Upload Folder Writable', function(){
			return is_writable(WP_CONTENT_DIR);
		});
		/* Check to see if 10 is greater than 5 */
		WPUT::test('ExamplePlugin', 'Simple Test 1', function(){
			return 10 > 5;
		});
		/* Check to see if 1 == 2 */
		WPUT::test('ExamplePlugin', 'Simple Test 2', function(){
			return 1 == 2;
		});
		/* Pass back a string instead of a boolean */
		WPUT::test('ExamplePlugin', 'Simple Test 3', function(){
			return "Extra string to pass back";

	}


== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the `wp-unit-testing` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place the sample tests into your functions.php
4. Navigate to the WP-UT option on the WordPress admin menu, and run some tests

== Frequently Asked Questions ==

= What can I add unit tests to? =

Anything you can hook into `init`! This includes your `functions.php` file and any plugin files.

== Screenshots ==

1. Add in your unit tests into your functions.php or the plugin you're developing
2. Navigate to WP-UT in the admin menu sidebar, and choose which test(s) you'd like to run
3. We ran all the tests!

== Changelog ==

= 0.1 =
* Initial version