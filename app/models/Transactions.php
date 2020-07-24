<?php

    class Entry
    {
       function  __construct()
       {
           unset($this->recieptNo);

           unset($this->sn);
       }
    }


    class Transactions extends Query {

        private $location;

        public function setUp($id)
        {
            $this->location = "memberId=$id";

            $this->setTable("transactions");

            $this->setFetchType(PDO::FETCH_CLASS,"Entry");
        }

        public function history()
        {
            return $this->where($this->location)->get()->all();
        }

        public function getHistoryOf($e)
        {
            return $this->where($this->location)->and()
            ->where("purpose=$e")->get()->all();
        }

        public function commitPay($detail)
        {
            $this->where($this->location)->put($detail);
        }
    };

?>