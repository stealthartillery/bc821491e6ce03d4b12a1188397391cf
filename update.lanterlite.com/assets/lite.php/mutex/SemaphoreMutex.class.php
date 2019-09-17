<?php
/*
*	Pt (PHP Toolkit)
*	Copyright (C) 2008  Dinu Florin
*
*	Pt is free software: you can redistribute it and/or modify
*	it under the terms of the GNU Lesser General Public License as published by
*	the Free Software Foundation, either version 3 of the License, or
*	any later version.
*
*	Pt is distributed in the hope that it will be useful,
*	but WITHOUT ANY WARRANTY; without even the implied warranty of
*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*	GNU Lesser General Public License for more details.
*
*	You should have received a copy of the GNU Lesser General Public License
*	along with Pt.  If not, see <http://www.gnu.org/licenses/>.
*/
/**
*	This file contains the Semaphore mutex implementation.
*	This method uses the Semaphore extension to create a mutex.
*
*	@author		Dinu Florin <contact@florindinu.ro>
*	@package	Core
*	@subpackage	Mutex
*/

/**
*	Semaphore mutex class.
*
*	@author		Dinu Florin <contact@florindinu.ro>
*	@package	Core
*	@subpackage	Mutex
*/
class SemaphoreMutex implements MutexInterface
{
	protected $key = null;
	protected $sem = null;
	
	/**
	*	@see	BasicMutex::canInstantiate()
	*/
	public static function canInstantiate()
	{
		return function_exists('sem_get');
	}
	
	/**
	*	Constructor.
	*
	*	@see	BasicMutex::__construct()
	*/
	public function __construct($name)
	{	
		$this->key = abs(crc32($name));
		$this->sem = sem_get($this->key, 1, 0666, 1);
		if($this->sem === false) throw new MutexException('Error geting semaphore');
	}
	
	/**
	*	Lock the mutex.
	*
	*	@see	BasicMutex::lock()
	*/
	public function lock()
	{	
		if(!sem_acquire($this->sem))
		{
			throw new MutexException('Error locking mutex');
		}
	}
	
	/**
	*	Unlock the mutex.
	*
	*	@see	BasicMutex::unlock()
	*/
	public function unlock()
	{
		if(!sem_release($this->sem))
		{
			throw new MutexException('Error unlocking mutex');
		}
	}
}