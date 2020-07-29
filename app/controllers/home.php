<?php

class Home extends Controller 
{
    public function index($data = [])
    {
        // Sends data to model;
        // Loads up the appropriate Views and the models data

        $this->viewEXT (

            "home/index", 
            "SchoolMgt Site",
            $data,
            [
                "../static/others/css/home.css"
            ]
        );

    }
    
    public function login($data = [])
    {
        $user = $this->dbmodel("User");
        
        // Create a validating and sanitizing 
        // function later

        if (!isset($_POST)) 
        {
            Tools::redirect_to("error", 500);

        }
        
        $user->name = /*"obi";*/Tools::cleanInput($_POST["user"]);
        
        $user->pass = /*"123";*/Tools::cleanInput($_POST["pass"]);
        
        if ($user->verify())
        {
            echo "Successful";

            Tools::makeSession($user->id);
            
            //print_r($_SESSION);
            Tools::redirect_to_dashboard();
            
        } else {

            echo "failed";

            Tools::redirect_to(".", 404);
            //header("Location: error");
           // Tools::redirect_to_home(404);

        }

    }

    public function signup($data=[])
    {
        $user = $this->dbmodel("User");
        
        // Create a validating and sanitizing 
        // function later

        if (!isset($_POST)) 
        {
            Tools::redirect_to("error", 500);

        }
        
        $user->name = /*"obi";*/Tools::cleanInput($_POST["user"]);
        
        $user->pass = /*"123";*/Tools::cleanInput($_POST["pass"]);
        
    }
}

?>