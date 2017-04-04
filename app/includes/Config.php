<?php
	/**
	* 	Config
	* 	Class to start json configurations
	* 	Author: Diogo Cezar <diogo@diogocezar.com>
	*	Year: 2017
	*/

	namespace App\Includes;

	class Config{
		/**
		* Attribute to strore config json location
		*/
		public static $config_json = "../config/config.json";
		/**
		* Attribute to strore project configurations
		*/
		public static $config;
		/**
		* Function to start configuration
		*/
		public static function start(){
			Config::$config = json_decode(file_get_contents(__DIR__ . "/" . Config::$config_json), true)['config'];
		}
	}
	Config::start();
?>