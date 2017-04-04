<?php
	require_once(__DIR__ . '/includes/Config.php');
	require_once(__DIR__ . '/includes/DataBase.php');

	use App\Includes\DataBase as DataBase;
	use App\Includes\Config   as Config;

	class Oracle{
		/**
		* Constuctor
		*/
		public function __construct(){
			DataBase::connect();
		}
		/**
		* Method to get project dist
		*/
		public function getDist(){
			echo Config::$config['dist'];
		}
		/**
		* Method to get item from database
		*/
		public function getItem($id = false){
			if($id != false)
				return DataBase::get('table', $id);
			else
				return DataBase::get('table');
		}
		/**
		* Method to save item on database
		*/
		public function saveItem(){
			$data = array('field' => 'value');
			DataBase::save('table', $data);
		}
	}
	/**
	* Direct access
	*/
	if(isset($_GET['method'])){
		$method = $_GET['method'];
		if(!empty($method)){
			$oracle = new Oracle();
			$oracle->{$method}();
		}
	}
?>