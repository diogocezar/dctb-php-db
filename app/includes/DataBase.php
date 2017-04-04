<?php
	/**
	* 	Config
	* 	Class to control database
	* 	Author: Diogo Cezar <diogo@diogocezar.com>
	*	Year: 2017
	*/

	namespace App\Includes;

	class DataBase{
		/**
		* Attribute to store type of database
		*/
		public static $type;
		/**
		* Attribute to store host of database
		*/
		public static $host;
		/**
		* Attribute to store name of database
		*/
		public static $base;
		/**
		* Attribute to store user of database
		*/
		public static $user;
		/**
		* Attribute to store password of database
		*/
		public static $pass;
		/**
		* Attribute to store the connection string
		*/
		public static $conn_string;
		/**
		* Attribute to store pdo object
		*/
		public static $pdo;

		/**
		* Private Constructor
		*/
		private function __construct(){}

		/**
		* Method to Connect Database
		*/
		public static function connect(){
			DataBase::$type = Config::$config['database']['type'];
			DataBase::$user = Config::$config['database']['user'];
			DataBase::$host = Config::$config['database']['host'];
			DataBase::$base = Config::$config['database']['base'];
			DataBase::$pass = Config::$config['database']['pass'];

			DataBase::$conn_string  = DataBase::$type;
			DataBase::$conn_string .= ":host="   . DataBase::$host;
			DataBase::$conn_string .= ";dbname=" . DataBase::$base;

			try{
				DataBase::$pdo = new \PDO(DataBase::$conn_string, DataBase::$user, DataBase::$pass);
	        	DataBase::$pdo->exec("SET CHARACTER SET utf8");
				DataBase::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e) {
				die(DataBase::error($e->getMessage()));
			}
		}

		/**
		* Method to Get Item or Items from table
		*/
		public static function get($table, $id = false){
			if(!isset($table))
				die(DataBase::error("Nenhuma tabela foi selecionada."));
			$sql   = "SELECT * FROM " . $table;
			$array = array();
			if($id != false){
				$sql .= " WHERE id = ?";
			}
			$rs  = DataBase::$pdo->prepare($sql);
			$rs->bindParam(1, $id);
			try{
				if($rs->execute()){
					if($rs->rowCount() > 0){
						return $rs->fetchAll();
					}
					else{
						return null;
					}
				}
			}
			catch (PDOException $e) {
				die(DataBase::error($e, $sql));
			}
		}

		/**
		* Method to save [insert/update] items from table
		*/
		public static function save($table, $data){
			if(empty($data) || empty($table)){
				die(DataBase::error("Os dados, ou tabela não estão preenchidos corretamente."));
			}
			$array = array();
			if(empty($data['id'])){
				foreach ($data as $key => $value){
					if($value != "NOW()" && $value != "CURTIME()")
	            		$insert[] = ':' . $key;
	            	else
	            		$insert[] = $value;
				}
	        	$insert = implode(',', $insert);
	        	$fields = implode(',', array_keys($data));
	        	$sql = "INSERT INTO `".$table."` (".$fields.") VALUES (".$insert.")";
				$rs = DataBase::$pdo->prepare($sql);
	        	foreach ($data as $key => $value)
	        		if($value != "NOW()" && $value != "CURTIME()")
	            		$rs->bindValue(':' . $key, $value);
				try{
					$rs->execute();
					return DataBase::$pdo->lastInsertId();
				}
				catch (PDOException $e) {
					die(DataBase::error($e, $sql));
				}
			}
			else{
				$updates = array_filter($data, function ($value) {
				    return null !== $value;
				});
				$values = array();
				$set    = "";
				foreach ($updates as $key => $value){
					if($key != "id")
						if($value != "NOW()" && $value != "CURTIME()")
	    					$set .= ' '.$key.' = :'.$key.',';
	    				else
	    					$set .= ' '.$key.' = '.$value.',';
				}
				$set = rtrim($set, ',');
				$sql = "UPDATE `".$table."` SET". $set ." WHERE id = :id_where";
				$rs = DataBase::$pdo->prepare($sql);
				foreach ($data as $key => $value){
					if($key != "id")
						if($value != "NOW()" && $value != "CURTIME()")
	            			$rs->bindValue(':' . $key, $value);
				}
				$rs->bindValue(':id_where', $data['id']);
				try{
					$rs->execute();
				}
				catch (PDOException $e) {
					die(DataBase::error($e, $sql));
				}
			}
			return true;
		}

		/**
		* Method to delete item
		*/
		public static function delete($table, $id){
			if(empty($table) || empty($id)){
				die(DataBase::error("A tabela ou id não estão preenchidos corretamente."));
			}
			$sql = "DELETE FROM `".$table."` WHERE id = :id_delete";
			$rs = DataBase::$pdo->prepare($sql);
			$rs->bindValue(':id_delete', $id);
			try{
				$rs->execute();
			}
			catch (PDOException $e) {
				die(DataBase::error($e, $sql));
			}
			return true;
		}

		/**
		* Method to execute a SQL
		*/
		public static function sql($sql, $binds = false){
			if(!isset($sql))
				die(DataBase::error("O SQL está vazio."));
			$rs = DataBase::$pdo->prepare($sql);
			if($binds != false){
				foreach ($binds as $key => $value)
					$rs->bindValue(':'. $key, $value);
			}
			try{
				$rs->execute();
				if($rs->rowCount() > 0){
					return $rs->fetchAll();
				}
				else{
					return null;
				}
			}
			catch (PDOException $e) {
				die(DataBase::error($e, $sql));
			}
		}

		/**
		* Method to display an error
		*/
		public static function error($msg, $sql = false){
			$console  = "<pre>";
			$console .= "<h1>HOUVE UM ERRO NO SISTEMA</h1>";
			$console .= "<br/>";
			if($sql != false){
				$console .= "<h2>[SQL]</h2><br/>" . $sql;
				$console .= "<br/><br/>";
			}
			$console .= "<h2>[ERRO]</h2><br/>" . $msg;
			$console .= "</pre>";
			return $console;
		}
	}
?>