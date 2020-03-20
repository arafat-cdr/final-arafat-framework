<?php
class CoreCrud{
    private $conn;
    private static $instance = false;

    private function __construct($connection) {
        $this->conn = $connection;
    }

    # singleton
    public static function init(){
        if( !self::$instance ){
            # create the singleTon Of CoreConnection
            self::$instance = new self(CoreConnection::init()->db_connect());
        }

        return self::$instance;
    }

    public function dbSelect($table_name, $select='*', $where_clause='', $limit = '', $offset = '0', $order_by = 'ORDER BY id DESC') {

        // die($limit);

        // check for optional where clause
        $whereSQL = '';
        // dd($where_clause);
        if(!empty($where_clause)) {
            // check to see if the 'where' keyword exists
            if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
                // not found, add key word
                $whereSQL = " WHERE ".$where_clause;
            } else {
                $whereSQL = " ".trim($where_clause);
            }
        }
        // start the actual SQL statement
        $sql = "SELECT ".$select." FROM ".$table_name." ";
        // append the where statement
        $sql .= $whereSQL;
        // run and return the query result

        # add order by

        $sql .= " ".trim($order_by);


        if(!empty($limit)) {

            $limit_sql = " LIMIT $limit OFFSET $offset";

            $sql .= $limit_sql;
        }

        // pr($sql);
        //exit();
        $res = $this->conn->query($sql);
        $data = array();
        if($res) {
            while ($row = mysqli_fetch_object($res)) {
                     $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    public function dbSelectRaw($sql){
        $res = $this->conn->query($sql);
        $data = array();
        // pr($sql);
        if($res) {

            while ($row = mysqli_fetch_object($res)) {
                     $data[] = $row;
                }

            return $data;

        } else {
            return FALSE;
        }

    }

    public function create_tbl($sql){
        pr($sql);
        $res = $this->conn->query($sql);

        return $res;
    }

    # add by arafat ...
    /*public function __toString() {

           return '';
    }*/
    public function dbInsert($table_name, $form_data) {
        // retrieve the keys of the array (column titles)
        $fields = array_keys($form_data);
        // build the query
        $sql = "INSERT INTO ".$table_name."(`".implode('`,`', $fields)."`) VALUES('".implode("','", $form_data)."')";
        // run and return the query result resource
        // echo $sql; exit();
        // pr($sql);

        $res = $this->conn->query($sql);

        if($res) {
            return $this->conn->insert_id;
        }
        else {
            return FALSE;
        }

    }

    public function dbUpdate($table_name, $form_data, $where_clause=''){
        // check for optional where clause
        $whereSQL = '';
        if(!empty($where_clause))
        {
            // check to see if the 'where' keyword exists
            if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
            {
                // not found, add key word
                $whereSQL = " WHERE ".$where_clause;
            } else
            {
                $whereSQL = " ".trim($where_clause);
            }
        }
        // start the actual SQL statement
        $sql = "UPDATE ".$table_name." SET ";
        // loop and build the column /
        $sets = array();
        foreach($form_data as $column => $value)
        {
             $sets[] = "`".$column."` = '".$value."'";
        }
        $sql .= implode(', ', $sets);
        // append the where statement
        $sql .= $whereSQL;

        // echo $sql; die();

        // run and return the query result
        $res = $this->conn->query($sql);

        if($this->conn->affected_rows) {

            return TRUE;
        }

        return  FALSE;

    }

    public function dbDelete($table_name, $where_clause='') {
        // check for optional where clause
        $whereSQL = '';
        if(!empty($where_clause))
        {
            // check to see if the 'where' keyword exists
            if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
            {
                // not found, add keyword
                $whereSQL = " WHERE ".$where_clause;
            } else
            {
                $whereSQL = " ".trim($where_clause);
            }
        }
        // build the query
        $sql = "DELETE FROM ".$table_name.$whereSQL;
        // run and return the query result resource

        // pr($sql);
        // dd($sql);

        $res = $this->conn->query($sql);

        if($res) {

            return TRUE;
        }

        return  FALSE;
    }

}

# Wrapper function ...
function core_crud(){
    return CoreCrud::init();
}