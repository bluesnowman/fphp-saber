<?php
 
/**
 * Copyright 2014 Blue Snowman
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
 
namespace Saber\Control\Monad\Choice {

	use \Saber\Control;
	use \Saber\Core;
 
	class Cons extends Control\Monad\Choice {
 
		protected $x;
		protected $xs;
		protected $f;

		public function __construct(Core\Any $x, Control\Monad\Choice $xs) {
			$this->x = $x;
			$this->xs = $xs;
			$this->f = null;
		}

		public function end() {
			if (!$this->xs()->end() && ($this->f !== null)) {
				return $this->f($this->x);
			}
			return false;
		}

		public function otherwise(callable $procedure) {
			$this->f = function($x) use ($procedure) {
				$procedure($x);
				return true;
			};
			return Control\Monad\Choice::cons($this->x, $this);
		}

		public function unless(Core\Any $y, callable $procedure) {
			$this->f = function($x) use ($y, $procedure) {
				if (!$y->__equals($x)) {
					$procedure($x);
					return true;
				}
				return false;
			};
			return Control\Monad\Choice::cons($this->x, $this);
		}

		public function when(Core\Any $y, callable $procedure) {
			$this->f = function($x) use ($y, $procedure) {
				if ($y->__equals($x)) {
					$procedure($x);
					return true;
				}
				return false;
			};
			return Control\Monad\Choice::cons($this->x, $this);
		}

	}
 
}
