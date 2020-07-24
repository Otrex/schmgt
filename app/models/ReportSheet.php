<?php
//require("Query.php");

class Subject 
{
    public $name;

    public $testScores = [];

    public $examScore;

}

class ReportSheet extends Query
{
    public $subjects = [];

    public $id;

    private $key;

    protected $tableMap = [
        "c1" => "sc1",
        "c2" => "sc2",
        "c3" => "sc3"
    ];

    public function setupClass($cls)
    {
        # takes the array map to sets its table
        $this->setTable($this->tableMap[$cls]);

        $this->key = "memberId=$this->id";
    }

    public function tmpSetup($cls)
    {
        # takes the array map to sets its table
        $this->setTable($this->tableMap[$cls]);

        $this->key = "memberId=$this->id";
    }

    public function transfer($oldClass, $newCls)
    {
        $this->register();

        $this->setupClass($newCls);

        $this->from($this->tableMap[$oldClass])->where($this->key)->remove();
        
    }

    public function enterScore($sub, $scoreType, $score)
    {
        # for score type, 0 --> test1, 1--->test2, 2----> exam
        //print_r($this->get($sub)->where($this->key)->one());
        $prev = json_decode(
            $this->get($sub)->where($this->key)->one()[$sub]
        );

        $prev[$scoreType] = intval($score);

        return $this->where($this->key)->edit([$sub => json_encode($prev)]);

    }

    public function enterScores($scores)
    {
        # $x = [subname =>[score, score, score], ...]
        
        return $this->where($this->key)->put($scores);
    }

    public function register()
    {
        return $this->put(["memberId"=>$this->id]);
    }


    public function destroy()
    {
        return $this->where("memberId=$this->id")->remove();
    }

    public function retrieveData()
    {
        $exempt = ["sn","memberId", "total", "average"];

        $data = $this->where("memberId=$this->id")->get()->one();

        //print_r($data);
        if (!empty($data))
        {
            foreach ($data as $name => $score) {
                
                if (array_search($name, $exempt))
                {
                    continue;
                }

                //echo $name;

                $sub = new Subject();

                $sub->name = $name;

                if (empty($score)){ continue; }
                    
                   
                $scoreA = json_decode($score);
                
                $sub->testScores = array_slice($scoreA, 0,2);

                $sub->examScore = $scoreA[2];

                array_push($this->subjects, $sub);

            }
        }
    }
}


?>