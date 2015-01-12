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

		public static function initialise() {
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

		public static function assertTrue($boolean, $string = '') {
			return array('result' => $boolean, 'text' => $string);
		}

		public static function assertFalse($boolean, $string = '') {
			return array('result' => !$boolean, 'text' => $string);
		}

		public static function assertNull($object, $string = ''){
			$boolean = ($object == null);
			return array('result' => $boolean, 'text' => $string);
		}

		public static function assertNotNull($object, $string = ''){
			$boolean = ($object != null);
			return array('result' => $boolean, 'text' => $string);
		}

		public static function assertSame($object1, $object2, $string = ''){
			$boolean = ($object1 === $object2);
			return array('result' => $boolean, 'text' => $string);
		}

		public static function assertNotSame($object1, $object2, $string = ''){
			$boolean = ($object1 !== $object2);
			return array('result' => $boolean, 'text' => $string);
		}

		public static function assertEquals($object1, $object2, $string = ''){
			$boolean = ($object1 == $object2);
			return array('result' => $boolean, 'text' => $string);
		}

		public static function assertNotEquals($object1, $object2, $string = ''){
			$boolean = ($object1 != $object2);
			return array('result' => $boolean, 'text' => $string);
		}

		public static function run($namespace_filter = '', $label_filter = '') {

			$total = 0;
			$good = 0;
			$bad = 0;

			Self::log('?', 'lightblue', 'WP-UT', 'Start', date('h:i:s d/m/Y'));
			$time = time();

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

							$attempt = $test->run();

							if($attempt['result'] === true) {
								Self::log('+', 'limegreen', $namespace, $label, $attempt['text']);
								$good++;
							}
							elseif($attempt['result'] === false){
								Self::log('-', 'red', $namespace, $label, $attempt['text']);
								$bad++;
								if(!$test->continue)
									Self::endTests();
							}

							$total++;

						} catch(Exception $e) {
							Self::log('-', 'red', $namespace, $label, $e);
							if(!$test->continue)
								Self::endTests();
						}

					}

				}

			}

			Self::log('?', 'lightblue', 'WP-UT', 'Finish', $good . '/' . $total . ' tests passed in ' . (time() - $time) . ' seconds');
			
				
		}

		private static function log($icon, $color, $namespace, $label, $comment){
			echo '[' . $namespace .'][<span style="color:' . $color . '">' . $icon . '</span>] <span style="color:#999">' . $label;
			if($comment)
				echo ' - ' . $comment;
			echo '</span>' . PHP_EOL;
		}

		private static function endTests(){
			Self::$running = false;
		}

	}

?>