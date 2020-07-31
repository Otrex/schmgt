<?php

class StudentFactory extends Query
{
    public function __construct($conn) 
    {
        parent::__construct($conn);

        $std = new Student($this->conn);
        
        $this->classmap = array_flip($std->getClassMap());

    }

    public function getClassStudents($cls)
    {
        $this->setTable($this->classmap[$cls]);

        $this->setFetchType(PDO::FETCH_CLASS, "tmpStudent");

        //echo json_encode($this->get()->all());
        return $this->get()->all();
    }

    public function getStudent($id , $cls)
    {
        $std = $this->createTmpStudent($id, $cls);

        return $std->getDetails() ? $std : null;
    }

    public function createTmpStudent($id, $cls)
    {
        $std =  new Student($this->conn);

        $std->tmpSetup($id, $cls);

        return $std;
    }

    public function search($by, $data)
    {
        $result = [];

        foreach ($this->classmap as $key => $value) {
            
            $this->setTable($value);

            $this->setFetchType(PDO::FETCH_CLASS, "tmpStudent");

            $ans = $this->where("$by LIKE $data%", " LIKE ")
            ->get("name","date_of_birth","picture","memberId")->all();

            array_push($result, ...$ans);
        }

        return $result;
    }

    public function editDetails($id, $class, $data)
    {
        $std = $this->createTmpStudent($id, $class);

        return $std->editDetails($data);
    }

    public function withdrawStudent($id, $class)
    {
        $std = $this->createTmpStudent($id, $class);

        return $std->withdraw();
    }

    public function registerStudent($data)
    {
        $std = $this->createTmpStudent($data["memberId"], $data["class"]);

        $fields = $std->dbfields();

        foreach ($fields as $key) {

            //print($key);
            $std->$key = $data[$key];  

        }

        $std->register();
    }
}

?>