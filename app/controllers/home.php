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
                "../static/others/css/home.css",
                "../static/others/css/msg.css"
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
            Tools::redirect_to(".", 500);

        }

        $user->state = 0;
        
        $user->name = /*"obi";*/Tools::cleanInput($_POST["user"]);
        
        $user->pass = /*"123";*/Tools::cleanInput($_POST["pass"]);

        $key = md5($user->name.$user->pass);

        $user->token = Tools::randomizer($key, 3);

        $user->register() ? Tools::redirect_to(".", "500") : Tools::redirect_to(".", "505");
       // echo json_encode($user->register() ? true : false);
       // echo json_encode([$user,random_int(0,27)]);

    }

    public function reset($data=[])
    {
        $user = $this->dbmodel("User");
        
        // Create a validating and sanitizing 
        // function later

        if (!isset($_POST)) 
        {
            Tools::redirect_to(".", 606);

        }

        $user->state = 0;
        
        $user->name = /*"obi";*/Tools::cleanInput($_POST["user"]);

        $user->token = Tools::cleanInput($_POST["token"]);

        $id = $user->verifyToken();

        if ($id)
        {
            $user->id = $id;
            
            $user->pass = /*"123";*/Tools::cleanInput($_POST["pass"]);
            
            $key = md5($user->name.$user->pass);

            $user->token = Tools::randomizer($key, 3);

            $user->resetPassword() ? Tools::redirect_to(".", "600") : Tools::redirect_to(".", "606");

        }
        
        Tools::redirect_to("resetPassword.htm", "606");

        

        
       // echo json_encode($user->register() ? true : false);
       // echo json_encode([$user,random_int(0,27)]);

    }
}

?>