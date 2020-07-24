<?php

    class Fee extends Controller 
    {
        public function pay()
        {
            Tools::isloggedIn();

            $_POST = Tools::getPosted();

            $data = [
                "payer"=> Tools::cleanInput($_POST["payer"]),
                "amt"=>  Tools::cleanInput($_POST["amt"]),
                "purpose" =>   Tools::cleanInput($_POST["purpose"]),
                "recieptNo"=>  Tools::cleanInput($_POST["recieptNo"]),
                "medium"=>   Tools::cleanInput($_POST["medium"])
            ];
            print_r($data);die();
            $payc = $this->dbmodel("Payment");
            
            $payc->setUp($data["payer"]);
            
            $out = $payc->pay($data["amt"], $data["purpose"], $data["medium"], $data["recieptNo"]);

            return $out;
        }
        
        public function getUnpaid()
        {
            Tools::isloggedIn();

            $data = [];
        
            $srch = $this->
            dbmodel("StudentFactory");
            
            $data = $srch->getAllDeptors();

            $data = Tools::retrievePicture($data, "profile");
            
            echo json_encode($data);
        }
        
        public function getPaymentHistory()
        {
            Tools::isloggedIn();

            $data = [
                "payerId"=>$_POST["id"]
            ];
            
            $payc = $this->dbmodel("Payment");
            
            $payc->setUp($data["payerId"]);
            
            return json_encode(
                $payc->history()
            );
            
        }
    }
?>