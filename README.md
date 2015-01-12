#Wordpress Unit Testing (WPUT)

**WPUT** is a simple way of adding Unit Tests into [WordPress](http://wordpress.org "WordPress"). Just install the plugin, add in your tests, then navigate to the WP-UT tab within the admin menu.

----------


Code Examples
-------------

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
