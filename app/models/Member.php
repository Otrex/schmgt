<?php

trait Member
{
    public $memberId;

    public $picture = "default.jpg";

    public $type;

    protected $DBfields = ["memberId", "picture", "name", "date_of_birth"];

    private $locator;

    public function memberLocation()
    {
        $this->locator = "memberId=$this->memberId";
    }

    public function changeMemberDetails($data = [])
    {
        return $this->where($this->locator)->edit($data);
    }

    public function registerMember()
    {
        $data = [];

        foreach ($this->DBfields as $key) {

            $data[$key] = $this->$key ;  

        }

        return $this->put($data);

    }

    public function dbfields()
    {
        return $this->DBfields;
    }
    
    public function retrieveData()
    {
        $data = $this->where($this->locator)->get()->one();

        if (!empty($data))
        {
        
            foreach ($this->DBfields as $key) {

                $k = $key;

                $this->$key = $data[$k];  

            }

            unset($this->conn); 

            return true;
        }

        return false;
    }


    public function withdrawMember()
    {
        return $this->where($this->locator)->remove();
    }

    public function addDBfields(...$data)
    {
        $this->DBfields = array_merge($this->DBfields, $data);
    }
}


?>