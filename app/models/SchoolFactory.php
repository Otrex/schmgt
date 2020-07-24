<?php

class SchoolFactory extends Query
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

    public function fullSearch($by, $value)
    {
        return array_merge (
            $this->students->search($by, $value),

            $this->staffs->search($by, $value)
        );
    }
}

?>