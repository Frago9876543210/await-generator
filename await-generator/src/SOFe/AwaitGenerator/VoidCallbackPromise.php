<?php

/*
 * await-generator
 *
 * Copyright (C) 2018 SOFe
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

declare(strict_types=1);

namespace SOFe\AwaitGenerator;

use Throwable;

class VoidCallbackPromise extends AbstractPromise{
	/** @var Await */
	protected $await;

	public function __construct(Await $await){
		$this->await = $await;
	}

	public function resolve($value) : void{
		parent::resolve($value);
		if($this->cancelled){
			return;
		}
		if($this->await->isSleeping()){
			$this->await->recheckPromiseQueue();
		}
	}

	public function reject(Throwable $value) : void{
		parent::reject($value);
		if($this->cancelled){
			return;
		}
		if($this->await->isSleeping()){
			$this->await->recheckPromiseQueue();
		}
	}
}
