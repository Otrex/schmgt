<?php

class StaffFactory extends Query
{
    
    public $staffTypes = ["t", "nt"];

    public function getAllStaff()
    {
        $this->setTable("staff");

        $this->setFetchType(PDO::FETCH_CLASS, "tmpStaff");

        //echo json_encode($this->get()->all());
        return $this->get()->all();
    }

    public function getStaffByType($stype)
    {
        $this->setTable("staff");

        $this->setFetchType(PDO::FETCH_CLASS, "tmpStaff");

        //echo json_encode($this->get()->all());
        return $this->where("type=$stype")->get()->all();
    }

    public function getTotalStaff($type)
    {
        return count($this->getStaffByType($type));
    }

    public function getStaff($id , $cls="staff")
    {
        $std = $this->createTmpStaff($id, $cls);

        return $std->getDetails() ? $std : null;
    }

    public function createTmpStaff($id, $cls)
    {
        $std =  new Staff($this->conn);

        $std->tmpSetup($id, $cls);

        return $std;
    }

    public function search($by, $data)
    {
            
        $this->setTable("staff");

        $this->setFetchType(PDO::FETCH_CLASS, "tmpStaff");

        $ans = $this->where("$by LIKE $data%", " LIKE ")
        ->get("name","date_of_birth","picture")->all();

        return $ans;
    }

    public function editDetails($id, $data)
    {
        $std = $this->createTmpStaff($id);

        return $std->editDetails($data);
    }

    public function withdrawStaff($id, $class="staff")
    {
        $std = $this->createTmpStaff($id, $class);

        return $std->withdraw();

    }

    public function registerStaff($data)
    {
        $std = $this->createTmpStaff($data["memberId"]);

        $fields = $std->dbfields();

        foreach ($fields as $key) {

            $std->$key = $data[$key];  

        }

        return $std->register();
    }
}
?>