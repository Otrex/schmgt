<?php

class Dashboard extends Controller 
{
    use StudentDashboard, StaffDashboard, UploadDashboard;

    public function index($data = [])
    {
        // Sends data to model;

        if (Tools::isLoggedIn())
        {
            $user = $this->dbmodel("User");

            $user->gatePass = $_SESSION["usrId"];

            $data = $user->getDetails();

            // Reassigning the User varialble to the current user
            $user = ucfirst($data["name"]);

            $status = $data["state"] ? "online": "offline";

            $title = "Welcome ". $user;

            $this->viewEXT (
                "dashboard/index", $title, $data,
                ["../static/others/css/dashboard.css", "../static/others/css/calender-event.css"],

                [
                    "id" => "main",
                    "ng-app" => "MyDashboard",
                    "ng-init" => "user='".$user."'; state='".$status."'"
                ],
                [
                    "../dependencies/angular/angular.min.js",
                    "../dependencies/angular/angular-route.js"
                   //"https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js",
                   //"https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"
                ],//add the js src to head
                [
                    "../static/dashboard/js/app-init.js",
                    "../static/dashboard/js/app-controllers.js",
                    "../static/dashboard/js/app-directives1.js"
                ]
            );
            //$this->view("dashboard/index", []);
        }
        
    }
    
    public function getTotalMember()
    {
        $school = $this->dbmodel("SchoolFactory");

        echo json_encode($school->getTotals_array());
    }
    // Dummy method
    
    public function search()
    {
        Tools::isloggedIn();

        $dummy = [
            "by" => "memberId",
            "value" => "cc"
        ];

        $school = $this->dbmodel("SchoolFactory");

        echo json_encode($school->fullSearch($dummy["by"], $dummy["value"]));
    }

    public function getClass()
    {
        Tools::isloggedIn();

        $dummy = ["class" => "LVL 1"];
        
        $school = $this->dbmodel("SchoolFactory");

        echo json_encode($school->getClass($dummy["class"]));
    }

}

?>