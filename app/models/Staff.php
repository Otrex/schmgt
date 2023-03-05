<?php

class tmpStaff {};

class Staff extends Person
{
    use Member;

    public $position;

    public $salary;

    public function __construct($conn)
    {
        parent::__construct($conn);

        $this->addDBfields("office", "salary", "type");

        $this->paymentPort = new Transactions($conn);
    }

    public function getDetails()
    {
        $bool = $this->retrieveData();

        return $bool;

    }

    public function register()
    {
        return $this->registerMember();
    }

    public function withdraw()
    {
        return $this->withdrawMember();
    }

    public function tmpSetup($id, $cls = "staff")
    {
        $this->memberId = $id;

        $this->memberLocation();

        $this->setTable($cls);

        // tmp Setup report
        $this->paymentPort->setUp($id);

    }


    public function editDetails($data = [])
    {
        return $this->changeMemberDetails($data);
    }
}

?>