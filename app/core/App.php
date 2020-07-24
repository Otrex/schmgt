<?php 

class App 
{

    public static function start($route_file, $config)
    {
        $app = new App();
        
        $app->conn = Connection::start("../config/".$config);

        $app->setDBAttr();
    
        Router::load("../config/".$route_file)
            ->direct(
                Request::uri(), 
                Request::method(),
                $app->conn
            );
            
    }
    
    public function setDBAttr()
    {
        $this->conn->setAttribute(
	        PDO::ATTR_DEFAULT_FETCH_MODE,
	        PDO::FETCH_ASSOC
	    );
    }

}

?>