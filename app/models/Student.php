<?php

class tmpStudent{
    public function __construct($cls=null)
    {
        $this->class = $cls;
    }
}

class Student extends Person
{
    use Member;

    public $class;

    public $reportSheet;

    private $classMap = [
        "c1" => "LVL 1",
        "c2" => "LVL 2",
        "c3" => "LVL 3"
    ];

    public function __construct($conn)
    {
        parent::__construct($conn);

        //$this->addDBfields();

        $this->reportSheet = new ReportSheet($conn);

        $this->paymentPort = new Transactions($conn);
    }
    
    public function getClassMap()
    {
        return $this->classMap;
    }

    public function setupClass(Type $var = null)
    {
        $this->class = $this->classMap[$this->getTable()];
    }

    public function getDetails()
    {
        $bool = $this->retrieveData();

        $this->reportSheet->retrieveData();

        $this->paymentPort = $this->paymentPort->history();

        if($bool){
            $this->setupClass();
        };

        return $bool;

    }

    public function register()
    {
        $this->registerMember();

        $this->reportSheet->register();

    }

    public function withdraw()
    {
        $x = $this->withdrawMember();

        $this->reportSheet->destroy();

        return $x;
    }

    public function tmpSetup($id, $class)
    {
        $this->memberId = $id;

        $this->memberLocation();

        $tableMap = array_flip($this->classMap);

        $this->setTable($tableMap[$class]);

        // tmp Setup report
        $this->reportSheet->id = $id;

        $this->reportSheet->tmpSetup($tableMap[$class]);

        $this->paymentPort->setUp($id);

    }


    public function editDetails($data = [])
    {
        return $this->changeMemberDetails($data);
    }


    public function transfer($newClass)
    {
        if (array_search($newClass, $this->classMap)) {

            $prevClass = $this->getTable();

            $this->tmpSetup($this->memberId, $newClass);

            $this->from($prevClass)->where($this->locator)->get()->putInto();

            $this->from($prevClass)->where($this->locator)->remove();

            // Delete ReportSheet and create new one
            $this->reportSheet->transfer(
                $prevClass,
                array_flip($this->classMap)[$newClass]
            );

        } else {

            return false;
        }
    }
}

// //class ReportSheet extends Query {};
// $x = new Student($conn);
// $x->transfer("ct1", "LVL 1", "LVL 3");
// // $x->name = "Chika";

// $x->id = "ccis/23";

// $x->registerMember();

// print_r(["obj" => $x , "vars" => get_class_vars("Student")]);
?>