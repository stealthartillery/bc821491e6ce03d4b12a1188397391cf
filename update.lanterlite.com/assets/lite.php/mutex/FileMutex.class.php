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
*	This file contains the File mutex implementation.
*	This method uses the Semaphore extension to create a mutex.
*
*	@author		Dinu Florin <contact@florindinu.ro>
*	@package	Core
*	@subpackage	Mutex
*/

/**
*	File mutex class.
*
*	@author		Dinu Florin <contact@florindinu.ro>
*	@package	Core
*	@subpackage	Mutex
*/
class FileMutex implements MutexInterface
{
	protected $fileName	= null;	//The lock file.
	protected $file		= null;	//The file pointer.
	
	protected static $dir 	= null;		//The directory where we store the lock files.
	
	/**
	*	@see	BasicMutex::canInstantiate()
	*/
	public static function canInstantiate()
	{
		return function_exists('flock');	//It will return true in every normal case.
	}
	
	/**
	*	Constructor.
	*
	*	@see	BasicMutex::__construct()
	*/
	public function __construct($name)
	{			
		//Check the temp dir
		if(is_null(self::$dir))
		{
			self::$dir = self::getTempDir().DIRECTORY_SEPARATOR.'pt-locks';
			if(!file_exists(self::$dir)) 
			{
				if(!@mkdir(self::$dir) && !file_exists(self::$dir)) 
				{
					throw new MutexException("Failed to create lock directory {self::$dir}");
				}
			}
		}
		
		$this->fileName = self::$dir.DIRECTORY_SEPARATOR.md5($name).'.lock';
		touch($this->fileName, time());
	}
	
	/**
	*	Lock the mutex.
	*
	*	@see	BasicMutex::lock()
	*/
	public function lock()
	{	
		$this->file = fopen($this->fileName, 'r');
		if($this->file === false) 
		{
			throw new MutexException("Error opening lock file {$this->fileName}");
		}
		
		if(!flock($this->file, LOCK_EX))
		{
			throw new MutexException("Error locking mutex");
		}
	}
	
	/**
	*	Unlock the mutex.
	*
	*	@see	BasicMutex::unlock()
	*/
	public function unlock()
	{	
		if(!flock($this->file, LOCK_UN))
		{
			throw new MutexException("Error unlocking mutex");
		}
		fclose($this->file);
	}

	/**
	*	Return the system's temporary directory.
	*
	*	@return	string
	*/
	protected static function getTempDir()
	{
		//Cache the result, this function will only run once per request, for subsequent calls just return the cached value.
		static $tempDir = null;
		if(!is_null($tempDir)) return $tempDir;
		
		if(function_exists('sys_get_temp_dir'))	//Try the new PHP 5 way, it's simpler and more reliable.
		{
			$tempDir = sys_get_temp_dir();
		}
		else
		{
			// Try to get the temp dir from environment variable.
			if(!empty($_ENV['TMP']))
			{
				$tempDir = Util::makeStdPath($_ENV['TMP']);
			}
			elseif(!empty($_ENV['TMPDIR']))
			{
				$tempDir = Util::makeStdPath($_ENV['TMPDIR']);
			}
			elseif(!empty($_ENV['TEMP']))
			{
				$tempDir = Util::makeStdPath($_ENV['TEMP']);
			}
			else //Detect the temp dir by creating a temporary file, this is the worst case.. it's slow and a little awkward
			{
				trigger_error('Util::getTempDir() is resorting to a tempnam hack to determine the system\'s temporary directory, please consider setting the TMP or TMPDIR environment variable', E_USER_NOTICE);
				//Try to use system's temporary directory as the random name shouldn't exist
				$tempFile = tempnam(md5(uniqid(rand(), true)), '');
				if ($tempFile)
				{
					$tempDir = Util::makeStdPath(dirname($temp_file));
					unlink($tempFile);
				}
				else
				{
					throw new GenericException('Can\'t determine the system\'s temporary directory');
				}
			}
		}
		
		//Do this even in production, the permissions could change so it's not suitable for asserts.
		if(!file_exists($tempDir)) throw new GenericException('Can\'t determine the system\'s temporary directory');
		if(!is_readable($tempDir)) throw new GenericException("The temporary directory {$tempDir} is not readable"); 
		if(!is_writable($tempDir)) throw new GenericException("The temporary directory {$tempDir} is not writable"); 
		
		return $tempDir;
	}
}