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
	
	class WPUT {

		static $running;
		static $tests;

		public static function construct() {
			Self::$running = true;
			Self::$tests = array();
		}

		/* Used for asserting a test */
		public static function test($namespace, $label, $test, $continue = true){
			$new = new WPUT_Test();
			$new->run = $test;
			$new->continue = $continue;
			Self::$tests[$namespace][$label] = $new; 
		}

		public static function runTests($namespace_filter = '', $label_filter = '') {

			foreach(Self::$tests as $namespace => $namespace_tests) {

				/* Have we been instructed to only test a certain namespace? */
				if($namespace_filter && $namespace != $namespace_filter)
					continue;

				foreach($namespace_tests as $label => $test) {

					/* Have we been instructed to only test a certain label? */
					if($label_filter && $label != $label_filter)
						continue;

					if(Self::$running) {

						try {
							$result = $test->run();

							if($result === true) {
								Self::log('+', 'limegreen', $namespace, $label);
							}
							elseif($result === false){
								Self::log('-', 'red', $namespace, $label);
								if(!$test->continue)
									Self::endTests();
							}
							elseif(is_string($result)){
								Self::log('?', 'lightblue', $namespace, $label . ' - ' . $result);
							}

						} catch(Exception $e) {
							print_r($e);
							if(!$test->continue)
								Self::endTests();
						}

					}

				}

			}
				
		}

		private static function log($icon, $color, $namespace, $label){
			echo '[' . $namespace .'][<span style="color:' . $color . '">' . $icon . '</span>] ' . $label . PHP_EOL;
		}

		private static function endTests(){
			Self::$running = false;
		}

	}

?>