<?php

class DB
{

    public $Records, $Con;

    function DB()
    {

    }

    public function Connect()
    {
        $this->Con = mysql_connect(Database_Host, Database_User, Database_Password) or die(mysql_error());
        mysql_select_db(Database_Name) or die(mysql_error());
    }

    public function Execute($strQuery)
    {
        $this->flatExecute($strQuery);
        return mysql_insert_id();
    }

    public function flatExecute($strQuery)
    {
        $this->Connect();
        mysql_query($strQuery) or die(mysql_error());
    }

    public function Returns($strQuery)
    {
        $this->connect();
        $this->Records = mysql_query($strQuery) or die(mysql_error());
        $this->close();
        return $this->Records;
    }

    public function fetchObject($strQuery)
    {
        $this->connect();
        $Result = mysql_query($strQuery) or die(mysql_error());
        $Results = mysql_fetch_object($Result);
        $this->close();
        return $Results;
    }

    public function fetchRecords($queryObj)
    {
        $result = array();
        while ($obj = mysql_fetch_object($queryObj)) {
            $result[] = $obj;
        }
        return (object) $result;
    }

    public function Total($strQuery)
    {
        $this->Connect();
        return mysql_num_rows(mysql_query($strQuery));
    }

    public function Close()
    {
        mysql_close($this->Con);
    }

    public function Lists($args)
    {

        $this->strQuery = $args['Query'];
        $this->TotalRecord = $this->Total($this->strQuery);
        if ($args['SO'])
            $this->strQuery.=" Order by " . $args['SO'];

        if ($args['Num']) {
            if ($args['P']) {
                $this->strQuery.=" LIMIT " . (($args['P'] * $args['Num']) - $args['Num']) . ", " . $args['Num'];
            } else {
                $this->strQuery.=" LIMIT 0," . $args['Num'];
            }
        }


        $Result = $this->Returns($this->strQuery);
        $i = 0;
        while ($Results = mysql_fetch_object($Result)) {
            $Value[$i] = $Results;
            $i++;
        }
        return $Value;
    }

}

?>