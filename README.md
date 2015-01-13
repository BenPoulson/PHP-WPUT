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
		WPUT::test('Core', 'Check for WordPress Updates', function(){
			$blog_version = get_bloginfo('version');
			$response = file_get_contents('http://api.wordpress.org/core/version-check/1.0/?version=' . $blog_version);
			return WPUT::assertTrue($response == 'latest');
		});

		/* Do any of our plugins need updating? */
		WPUT::test('Core', 'Check for Plugin Updates', function(){
			$plugin_status = get_site_transient('update_plugins');
			$update_count = count($plugin_status->response);
			$update_string = ($update_count ? $update_count . ' plugin/s to update!' : '' );
			return WPUT::assertFalse($update_count, $update_string);
		});

		/* Do any of our themes need updating? */
		WPUT::test('Core', 'Check for Theme Updates', function(){
			$theme_status = get_site_transient('update_themes');
			$update_count = count($theme_status->response);
			$update_string = ($update_count ? $update_count . ' theme/s to update!' : '' );
			return WPUT::assertFalse($update_count, $update_string);
		});

		/* Is the uploads folder writable? */
		WPUT::test('Core', 'Upload Folder Writable', function(){
			return WPUT::assertTrue(is_writable(WP_CONTENT_DIR));
		});

		/* Check to see if search engines are encouraged or discouraged */
		WPUT::test('Core', 'Website Public', function(){
			$search = (bool)get_option('blog_public');
			$search_term = ($search ? 'Encouraged' : 'Discouraged!');
			return WPUT::assertTrue($search, 'Searching is ' . $search_term);
		});

		/* Check to see if 10 is greater than 5 */
		WPUT::test('Example', 'Simple Test 1 - (10 < 5) == false', function(){
			return WPUT::assertFalse(10 < 5);
		});

		/* Check to see if 1 == 2 */
		WPUT::test('Example', 'Simple Test 2 - (1 == 2) == false', function(){
			return WPUT::assertFalse(1 == 2);
		});
	}
