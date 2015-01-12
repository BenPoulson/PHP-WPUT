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
		WPUT::construct();
		
	}

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
		});

	}

?>