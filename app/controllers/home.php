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
            [],
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
        
        $user->name = "obi";#Tools::stringify($_POST["user"]);
        
        $user->pass = "123";#Tools::cleanInput($_POST["pass"]);
        
        if ($user->verify())
        {
            echo "Successful";

            Tools::makeSession($user->id);
            
            //print_r($_SESSION);
            Tools::redirect_to_dashboard();
            
        } else {

            Tools::redirect_to_home(404);
            //echo "Failed";
            // Ajax would handle if not
            // Tools::redirect("home");
        }
        //echo "working";
       // print_r($user);
    }
}

?>