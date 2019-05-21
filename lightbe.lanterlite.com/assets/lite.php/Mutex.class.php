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
*	This file contains the Mutex class.
*	This class implements locking.
*
*	@author		Dinu Florin <contact@florindinu.ro>
*	@package	Core
*	@subpackage	Mutex
*/

/**
*	Mutex class
*
*	@author	Dinu Florin <contact@florindinu.ro>
*	@package	Core
*	@subpackage	Mutex
*/
final class Mutex
{	
	protected $name				= null;		//The mutex name.
	protected $mutex			= null;		//The mutex implementation.
	protected static $type		= null;		//Mutex implementation type (eg. Semaphore or File).
	protected $locked			= false;	//Mutex state.
	protected $ignoreUserAbort	= null;		//Used to restore the ignore_user_abort setting.

	protected $types = array('Semaphore', 'File');
	
	/**
	*	Constructor.
	*
	*	@param	string	$name	The mutex name.
	*/
	public function __construct($name)
	{
		assert('is_string($name)');
		
		$this->name = $name;
		$path = dirname(__FILE__).DIRECTORY_SEPARATOR;	//Path to ./mutex
		
		if(is_null(self::$type))	//Did we already determine the mutex type?
		{
			foreach($this->types as $type)	//Iterate through the known types
			{	
				$classFile = $path.$type.'Mutex.class.php';
				if(file_exists($classFile))	//Check the class file
				{
					require_once $classFile;
					$className = $type.'Mutex';
					if(class_exists($className))	//Does the class exist?
					{
						$method = array($className, 'canInstantiate');
						if(is_callable($method) && call_user_func($method))	//Can it be instantiated?
						{
							self::$type = $type;
							$this->mutex = new $className($name);
							break;
						} 
					}
				}
			}
			
			if(is_null(self::$type)) 
			{
				throw new MutexException('Sorry but I can\'t create a mutex on this system, please consider installing the Semaphore extension or at least making flock() work.');
			}
		}
		else
		{
			$className = self::$type.'Mutex';
			$this->mutex = new $className($name);
		}
	}
	
	/**
	*	Destructor.
	*/
	public function __destruct()
	{
		$this->unlock();
	}
	
	/**
	*	Return the mutex type. 
	*	A mutex is implemented through different mechanisms depending on what the platform supports. This will
	*	return a string describing what mechanism is used. 
	*
	*	@return	string
	*/
	public function getMutexType()
	{
		return self::$type;
	}
	
	/**
	*	Lock the mutex. This call will block until a lock can be aquired.
	*/
	public function lock()
	{
		if(!$this->locked) //Only lock an unlocked mutex, we don't support recursive mutex'es
		{
			$this->mutex->lock();	//Actual lock
			$this->locked = true;
			
			//We are entering a critical section so we need to change the ignore_user_abort setting so that the 
			//script doesn't stop in the critical section.
			$this->ignoreUserAbort = ignore_user_abort(true);
		}		
	}
	
	/**
	*	Unlock the mutex.
	*/
	public function unlock()
	{
		if($this->locked)	//Only unlock a locked mutex.
		{
			$this->mutex->unlock();	//Actual unlock.
			$this->locked = false;
			
			ignore_user_abort($this->ignoreUserAbort);	//Restore the ignore_user_abort setting.
		}
	}
}

/**
*	Mutex interface.
*
*	@author	Dinu Florin <contact@florindinu.ro>
*	@package	Core
*	@subpackage	Mutex
*/
//Yes, it should be implemented in a separate file to keep in tune with the rest of Pt, but it's in here for optimization purposes.
interface MutexInterface
{
	/**
	*	Constructor.
	*	
	*	@param	string	$name	The mutex name.
	*	@see	Mutex::__construct()
	*/
	public function __construct($name);
	
	/**
	*	Lock the mutex.
	*/
	public function lock();
	
	/**
	*	Unlock the mutex.
	*/
	public function unlock();
	
	/**
	*	Check if this class can be instantiated. This will check if the proper PHP extensions are installed
	*	and if the requirements are met to use the mechanism that this class implements.
	*
	*	@return	boolean
	*/
	public static function canInstantiate();
}

/**
*	Mutex exception.
*/
class MutexException extends Exception 
{
	protected $message = 'Mutex exception';
}