<?php
	
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

	function wput_admin_page() {
		 // Now display the settings editing screen

		echo '<div class="wrap">';
		echo '<form method="post" action="">';
		echo '<h2>' . __( 'WordPress Unit Testing', 'WP-UT' ) . '</h2>';
		echo '<hr />';

		echo '<select name="select_tests" id="select_tests">';
		echo '<option value="">Run All Tests</option>';

			foreach(WPUT::$tests as $namespace => $namespace_tests) {

				echo '<optgroup label="' . $namespace . '">';
				echo '<option value="' . $namespace . '" style="margin-left:23px;">All Group Tests</option>';

				foreach($namespace_tests as $label => $test) {
					echo '<option value="' . $namespace . '|' . $label . '" style="margin-left:23px;">' . $label . '</option>';
				}

				echo '</optgroup>';

			}

		echo '</select>';
		echo '<input type="submit" class="button">';
		echo '</form>';

		echo '<pre style="background: #000; min-height: 400px; border: 1px #333 solid;-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; scrolling: auto; color: #ccc; display: block; padding: 5px;
">';
		if(isset($_POST['select_tests'])) {

			$test_chosen = explode('|', $_POST['select_tests']);
			WPUT::runTests($test_chosen[0], $test_chosen[1]);
		}
		
		echo '</pre>';

		echo '</div>';
	}

?>