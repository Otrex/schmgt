<?php 

	//print_r($config);
	
	class Connection
    {
        public static function start($config)
        {
            require $config;
            
            //print_r($config);
            
            return Connection::connect($config);
        }
        
		public static function connect($config)
		{
			if (array_key_exists("PDO_OBJECT", $config))
			{
				return $config["PDO_OBJECT"];
			}
			
			$dbd = $config["DBDRIVER"].":host="
			       .$config["DBHOST"].":"
			       .$config["DBPORT"].
			       ";dbname=".$config["DBNAME"];
            //die($dbd);
			try 
			{
				return new PDO(
				    $dbd, $config["DBUSER"],
				    $config["DBPASS"]
				);

			}
			catch (PDOException $e)
			{
				
				die("Error::". $e);

			}
			
		}
	}

?>