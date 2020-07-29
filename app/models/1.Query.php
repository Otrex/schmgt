<?php

trait subQueries
{
    private $tmp;

    public function and()
    {
        $this->sql .= " and ";

        $this->key = true;

        return $this;
    }

    public function or()
    {
        $this->sql .= " or ";

        $this->key = true;

        return $this;
    }

    public function from($table)
    {
        $this->tmp = $this->table;

        $this->table = $table;

        return $this;
    }

    private function resetTable ()
    {
        $this->table = $this->tmp;
    }

    public function all()
    {
        //echo $this->sql;

        return $this->performQuery(1);
    }

    public function one()
    {
        $this->sql = $this->sql." limit 1;";

        //echo $this->sql;

        $ans = $this->performQuery(1);

        return $ans ? $ans[0] : null;
    }

    public function about($var)
    {
        $this->sql = $this->sql." limit $var; ";

        echo $this->sql;

        return $this->performQuery(1);
    }

    public function where( $condition , $comp = "=")
    {
        $params = array_map('trim', explode($comp,$condition));

        $s = " where ";

        if (isset($this->key))
        {
            unset($this->key);

            $s = "";
        }

        $s = $s.$params[0].$comp.Query::typeSetter($params[1]);

        $this->sql = $this->sql.$s;

        return $this;

    }

}


trait basicQueries
{
    public function get(...$columns)
    {
        if (empty($columns))
        {
            $columns = ["*"];
        }
        $s = implode(",", $columns);

        $this->sql = "select ".$s.
                     " from ".
                     $this->table.
                     $this->sql;

        return $this;
    }

    public function edit($data)
    {
        $dataValues = [];
            
        foreach ($data as $key => $value){

            array_push($dataValues, $key.'='.Query::typeSetter($value));

        }
        
        $dataValues = implode(
            ",", $dataValues
        );

        $this->sql = "update ".
                    $this->table.
                    " set ".$dataValues.
                    $this->sql;

        //echo $this->sql;

        return $this->performQuery();
    }

    public function putInto (...$var)
    {
        $into = implode(",", $var);

        $this->resetTable();

        $this->sql = "insert into ".
                     $this->table." ".
                     (empty($into) ? "":"(".$into.") ")
                     .$this->sql;

        //echo $this->sql;
        return $this->performQuery();

    }

    public function put($data = [])
    {
        $this->sql = $this->preparePutSQL(array_keys($data), $this->table);

        //echo $this->sql;

        return $this->performQuery($data);
    }

    public function remove()
    {

        
        $this->sql = "delete from ".$this->table.(empty($this->sql) ?" ": "").$this->sql;
        
        if (isset($this->tmp))
        {
            $this->resetTable();
        }
        //echo $this->sql;
        return $this->performQuery();
    }
}



//////////////////////////////////////////////////////////////////////////
trait queryTools
{
    private $fetchType = [PDO::FETCH_ASSOC];

    public function setFetchType(...$data)
    {
        $this->fetchType = $data;
    }

    public static function new($conn, $t)
    {
        $q = new Query($conn);
        
        $q->table = $t;
        
        return $q;
    }

    public static function typeSetter($var)
    {
        if (is_numeric($var)) {
            return intval($var);
        }

        if (is_string($var)) {
            return Query::quotify($var);
        }

    }

    public static function judgeDataType($var)
    {
        if (is_numeric($var)) {
            return PDO::PARAM_INT;
        }

        if (is_string($var)) {
            return PDO::PARAM_STR;
        }
    }

    public static function quotify($s)
    {
        return "'".trim($s)."'";
    }

    private static function preparePutSQL($data, $table)
    {
        $fields = implode(",", $data);
            
        $holders = ":".implode(',:',$data);
        
        $sql = sprintf(
        "insert into %s (%s) values (%s) ",
            $table,
            $fields,
            $holders
        );

        return $sql;
    }
}


///////////////////////////////////////////////////////////////
class Query 
{
    use subQueries, basicQueries, queryTools;

    public $conn;

    private $table;

    protected $sql = "";

    public function __construct ($conn)
    {
        $this->conn = $conn;
    }

    public function setTable($t)
    {
        $this->table = $t;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function clearSQL(Type $var = null)
    {
        $this->sql = "";
    }

    public function lastElement($fields)
    {
        for ($i = 0;$i<count($fields);$i++)
        {
            $fields[$i]="max(".$fields[$i].")";
        }
        
        return $this->get($fields)->one();
    }

    public function getFieldNames()
    {
        return array_keys($this->get()->one());
    }

    
    private function perform($type = false)
    {
       // echo $this->sql."<br>";
        try {
            
            $stmt = $this->conn->prepare($this->sql);

            if (is_object($type)){

                $stmt = $type;

            }

            // if (is_bool($type)) {
            //     //echo "entrerd";
            //     $stmt = $this->conn->prepare($this->sql);

            // } else {

            //     if (is_object($type)){

            //         $stmt = $type;

            //     }
                
            // }

            $success = $stmt->execute();

            
            $this->clearSQL();

            return is_object($type) || is_bool($type) ? $success : $stmt->fetchall(...$this->fetchType);
            
        } catch (PDOException $e){

            $this->clearSQL();
            
            die($e);

        }
    }

    private function performQuery($type = 0)
    {
        // Type 0 returns Output
        //echo "$this->sql";
        if ($type == 0)
        {
            return $this->perform();
        }

        if ($type == 1)
        {
            return $this->perform(1);
        }

        $stmt = $this->conn->prepare($this->sql);
            
        foreach ($type as $field => $entry)
        {
            $stmt->bindValue(
                ":".$field,
                $entry, Query::judgeDataType($entry)
            );
        }

        return $this->perform($stmt);

        // switch ($type) {
        //     case 0:

        //         return $this->perform();

        //     case 1:

        //         return $this->perform(true);

        //     default:
                
        //         $stmt = $this->conn->prepare($this->sql);
            
        //         foreach ($type as $field => $entry)
        //         {
        //             $stmt->bindValue(
        //                 ":".$field,
        //                 $entry, Query::judgeDataType($entry)
        //             );
        //         }

        //         return $this->perform($stmt);

        // }

    }

}

?>