<?php

class Controller 
{
    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index()
    {
        Tools::isloggedIn();

        echo "Page not in use click <a href='dashboard'>Here </a>";
    }
        
    static function rootpath($src)
    {
        global $rootDir;
        
        //print_r($rootDir.$src);
        return $rootDir.$src;

    }
    
    function model($model_name)
    {
        // This would load up the model required

        $model_name = ucfirst($model_name);

        if (file_exists("../app/models/".$model_name.".php"))
        {
            require_once "../app/models/".$model_name.".php";

            return new $model_name;
        }

    }
    
    function dbmodel($model_name)
    {
        // This would load up the model required

        $model_name = ucfirst($model_name);

        if (file_exists("../app/models/".$model_name.".php"))
        {
            return new $model_name($this->conn);
        }

    }

    function view ($page_path, $data = [])
    {
        // This would load up the required view
        
        if (file_exists("../app/views/".$page_path.".php"))
        {
            $partial_path = explode("/", $page_path)[0];
            
            //require_once "../app/views/partials/".$partial_path."/head.php";
            
            require_once "../app/views/".$page_path.".php";
            
            //require_once "../app/views/partials/".$partial_path."/tail.php";
            
        }
    }

    function logout()
    {
        Tools::endSession(300);
    }

    function viewEXT(
        $page, $title, $data, 
        $CSSsources = [], $BodyAttr = [], 
        $JSHeaderSources = [], $JSsources = [] )
    {
        $partials = explode("/", $page)[0];

        if (file_exists("../app/views/".$page.".php"))
        {
            require_once "../app/views/partials/header.php";

            if (file_exists("../app/views/partials/".$partials."/nav.php"))
            {
                require_once "../app/views/partials/".$partials."/nav.php";
            }
            
            require_once "../app/views/".$page.".php";
            
            require_once "../app/views/partials/footer.php";
            
        }
    }
}

?>