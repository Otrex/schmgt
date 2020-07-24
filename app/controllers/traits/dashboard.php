<?php

trait StudentDashboard
{
    public function getStudentsByClasses()
    {
        Tools::isloggedIn();

        $students = [];

        $school = $this->dbmodel("StudentFactory");

        $dummy = $_POST["classes"];#["LVL 1", "LVL 2", "LVL 3"];
        
        foreach ($dummy as $value) {

            array_push($students, ...$school->getClassStudents($value));

        }

        $data = Tools::retrievePicture($students, "profile");
        
        echo json_encode($data);
    }

    public function editReportBook()
    {
        Tools::isloggedIn();
        
        $school = $this->dbmodel("StudentFactory");

        $school->createTmpStudent($dummy["memberId"], $dummy["class"]);
        
        unset($dummy["class"]);

        unset($dummy["memberId"]);

        $school->reportSheet->enterScores($dummy);

        return true;
    }

    public function editSingleReportEntry()
    {
        Tools::isloggedIn();
        
        $school = $this->dbmodel("StudentFactory");

        $school->createTmpStudent($dummy["memberId"], $dummy["class"]);
        
        unset($dummy["class"]);

        unset($dummy["memberId"]);

        return $school->reportSheet->
            enterScore($dummy["subject"], $dummy["scoreType"], $dummy["score"]);

    }

    public function registerStudent()
    {
        Tools::isloggedIn();

        $dummy = [
            "memberId" => "ccis/00002",
            "class" => "LVL 3",
            "name" => "Be Sams",
            "date_of_birth" => "2020-07-01",
            "picture"=>"default.jpg"
        ];

        $school = $this->dbmodel("StudentFactory");

        echo json_encode($school->registerStudent($dummy));
    }


    public function updateStudentDetails()
    {
        Tools::isloggedIn();

        $dummy = [];

        $school = $this->dbmodel("StudentFactory");

        $id = $dummy["memberId"];

        unset($dummy["memberId"]);

        $class = $dummy["class"];

        unset($dummy["class"]);

        echo json_encode($school->
            editDetails($id, $class, $dummy)
        );
    }


    public function withdrawStudent()
    {
        Tools::isloggedIn();

        $dummy = [];

        $school = $this->dbmodel("StudentFactory");

        echo json_encode($school->
            withdrawStudent($dummy["memberId"], $dummy["class"])
        );
    }


    public function getStudent()
    {
        Tools::isloggedIn();

        $dummy = ["memberId" => "ccis/00002", "class" => "LVL 2"];

        $school = $this->dbmodel("StudentFactory");

        echo json_encode($school->
            getStudent($dummy["memberId"], $dummy["class"])
        );

    }
}


/////////////////////////////////////////////////////


trait StaffDashboard
{
    public function getStaffByType()
    {
        Tools::isloggedIn();

        $dummy = ["type" => "t"];

        $school = $this->dbmodel("StaffFactory");

        echo json_encode($school->
            getStaffByType($dummy["type"])
        );

    }

    public function registerStaff()
    {
        Tools::isloggedIn();

        $dummy = [
            "memberId" => "ccis/00002",
            "class" => "LVL 3",
            "name" => "Be Sams",
            "date_of_birth" => "2020-07-01",
            "picture"=>"default.jpg"
        ];

        $school = $this->dbmodel("StaffFactory");

        echo json_encode($school->registerStaff($dummy));
    }


    public function getAllStaff()
    {
        Tools::isloggedIn();

        $school = $this->dbmodel("StaffFactory");

        echo json_encode($school->
            getAllStaff()
        );

    }


    public function getStaff()
    {
        Tools::isloggedIn();

        $school = $this->dbmodel("StaffFactory");

        echo json_encode($school->
            getStaff($dummy["memberId"])
        );
    }

    public function updateStaffDetails()
    {
        Tools::isloggedIn();

        $dummy = [];

        $school = $this->dbmodel("StaffFactory");

        $id = $dummy["memberId"];

        unset($dummy["memberId"]);

        echo json_encode($school->
            editDetails($id, $dummy)
        );
    }


    public function withdrawStaff()
    {
        Tools::isloggedIn();

        $dummy = [];

        $school = $this->dbmodel("StaffFactory");

        echo json_encode($school->
            withdrawStaff($dummy["memberId"])
        );
    }


}

/**
 * upload
 */
trait UploadDashboard
{
        
    public function updatePicture()
    {
        //$owner = Tools::getPosted()["Id"];
        print_r(["post" => $_POST, "file"=>$_FILES]);

        $upload = Tools::uploadFile("profilePicture", "images/profile/");

        print_r($upload); die();

        if ($upload)
        {
            // $rec = $this->
            //     dbmodel("SchoolFactory");

            //$rec->editData($owner, ["picture"=>"'".$upload."'"]);

            $data = ["picture"=>"'".$upload."'"];
            
            $db = $this->dbmodel("SchoolFactory");
        
            $result = $db->findId($data["Id"])->edit($data);

            echo "1";
            
        } else {

            echo "0";
        }
        
    }
}


?>