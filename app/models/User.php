<?php
   // require_once "Connection.php";
    
   // require_once "Query.php";
    
    class User extends Query
    {
        public $name = "";
        
        public $pass = "";
        
        public $token = "1";
        
        public $state = "0";
        
        public $gatePass = null;
        
        public function __construct($conn)
        {
            parent::__construct($conn);
            
            $this->setTable("users");
        }
        
        public function verify()
        {
            $usr = $this->where("name=$this->name")->and()->where("pass=$this->pass")->get()->one();
            
            if (isset($usr) && !empty($usr))
            {
                $this->state = "1";

                $this->id = $usr["userId"];
    
                $this->where("userId=".$this->id)->edit(["state"=> $this->state]);
                    
                return true;

            }

            return false;
        }
        
        public function resetPassword ()
        {
            //$user = $user." and ".$this->token;
            
            $reset = array(
                "pass" => $this->pass
            );
            
            if ($this->where("name=$this->name")->edit($reset))
            {
                return true;
            }
            
            return false;
        }
        
        public function getDetails()
        {
            return $this->where("userid=$this->gatePass")->get()->one();
        }

        public function register()
        {
            $reg = array(
                "name" => $this->name,
                "pass" => $this->pass,
                "state" => "0"
            );
            
            if ($this->put($reg))
            {
                return true;
            }
            return false;
        }
    }

?>