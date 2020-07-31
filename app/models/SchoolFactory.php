<?php

class SchoolFactory
{
    public function __construct($conn)
    {
        $this->students = new StudentFactory($conn);

        $this->staffs = new StaffFactory($conn);

    }

    public function getClass($cls)
    {
        $result = (Object)[];

        $result->students = $this->students->getClassStudents($cls);

        $result->teacher = $this->staffs->search("office", $this->students->getTable());

        return $result;
    }

    public function getTotalStudents($cls)
    {
        return count($this->students->getClassStudents($cls));
    }

    public function getTotals_array()   
    {
        $result = [];

        $this->students->classmap;

        foreach ( $this->students->classmap as $key => $value) {

            $result[$key] = $this->getTotalStudents($key);

        }

        foreach ( $this->staffs->staffTypes as $value) {

            $result[$value] = $this->staffs->getTotalStaff($value);

        }

        return $result;

    }

    public function fullSearch($by, $value)
    {
        return array_merge (

            $this->students->search($by, $value),

            $this->staffs->search($by, $value)
        );
    }
}

?>