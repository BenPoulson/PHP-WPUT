<?php
/*
Plugin Name: Wordpress Unit Testing (WP-UT)
Description: Enables unit testing facilities within WordPress
Author: Ben Poulson
Version: 0.1
Author URI: https://benpoulson.me
*/

/*  Copyright (c) 2015 Ben Poulson <ben@netikan.com>
	All rights reserved.
	WPUT is distributed under the GNU General Public License, Version 2,
	June 1991. Copyright (C) 1989, 1991 Free Software Foundation, Inc., 51 Franklin
	St, Fifth Floor, Boston, MA 02110, USA
	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
	ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
	WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
	DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
	ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
	(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
	LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
	ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
	(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
	SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

	defined('ABSPATH') or die('No direct access!');

	require(plugin_dir_path( __FILE__ ) . 'inc/wput.inc.php');
	require(plugin_dir_path( __FILE__ ) . 'inc/wput_test.inc.php');
	require(plugin_dir_path( __FILE__ ) . 'inc/wput_page.inc.php');

	add_action('admin_menu', function(){
		add_menu_page( 'WordPress Unit Testing' , 'WP-UT' , 'manage_options', 'wp-unit-testing.php', 'wput_admin_page');
	});

	add_action('init', 'wput_initialise', 0);
	add_action('admin_init', 'wput_initialise', 0);
	function wput_initialise() {
		WPUT::initialise();
	}

	add_action('init', 'example_tests');
	add_action('admin_init', 'example_tests');
	function example_tests() {

		/* Check using WP's version checker, to see if we're up to date */
		WPUT::test('Core', 'Check WordPress Updates', function(){
			$blog_version = get_bloginfo('version');
			$response = file_get_contents('http://api.wordpress.org/core/version-check/1.0/?version=' . $blog_version);
			return WPUT::assertTrue($response == 'latest');
		});

		/* Do any of our plugins need updating? */
		WPUT::test('Core', 'Check Plugin Updates', function(){
			$plugin_status = get_site_transient('update_plugins');
			$update_count = count($plugin_status->response);
			return WPUT::assertFalse($update_count, $update_count . ' plugin/s to update');
		});

		/* Do any of our themes need updating? */
		WPUT::test('Core', 'Check Theme Updates', function(){
			$theme_status = get_site_transient('update_themes');
			$update_count = count($theme_status->response);
			return WPUT::assertFalse($update_count, $update_count . ' theme/s to update');
		});

		/* Is the uploads folder writable? */
		WPUT::test('Core', 'Upload Folder Writable', function(){
			return WPUT::assertTrue(is_writable(WP_CONTENT_DIR));
		});

		/* Check to see if search engines are encouraged or discouraged */
		WPUT::test('Core', 'Website Public', function(){
			$search = (bool)get_option('blog_public');
			$search_term = ($search ? 'Encouraged' : 'Discouraged');
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

?>
