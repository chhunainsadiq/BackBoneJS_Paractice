<?php
/**
 * Contains definition of database class
 */

/**
 * Manages all the database functionalities
 */
include_once(dirname(__FILE__) . "/drivers/mysqli/PDODRIVER.php");
class dbhelper
{
    /**
     * contains the handler
     * @var PDODRIVER
     */
    private $db_handler;
    /**
     * contains the prepared statement to be executed
     * @var PDOStatement
     */
    private $statement;
    /**
     * Constructor for Database
     */
    public function __construct()
    {

        $this->db_handler = PDODRIVER::getInstance();

    }
    /**
     * This function prepare the statement to be executed
     * @param int $query the query string to be prepared
     */
    public function prepareQuery($query)
    {
        $this->statement = $this->db_handler->prepare($query);
    }
    /**
     * This function binds value to prepared statement
     * @param array $param parameters array
     * @param array $value value for parameters
     * @param string $type type of parameter
     */
    public function bind($param, $value, $type = null)
    {
        if(is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->statement->bindValue($param, $value, $type);
    }
    /**
     * Select database rows upon some conditions
     * @param string $table table name
     * @param string $where where condition
     * @param string $fields which fields to be selected
     * @param string $order order bay condition
     * @param int $limit limit of rows to be selected
     * @param string $offset
     */
    public function select($table, $where = '', $fields = '*', $order = '', $limit = null, $offset = '')
    {
        $query = "SELECT $fields FROM $table ".
            ($where ? " WHERE $where " : '')
            .($limit ? " LIMIT $limit " : '')
            .(($offset && $limit ? " OFFSET $offset " : ''))
            .($order ? "ORDER BY $order " : '');
        $this->prepareQuery($query);

    }

    public function joinQuery($ROLLNUMBER)
    {

        $query = "SELECT Student.Roll_No, StudentCourse.Roll_No, Student.Name, StudentCourse.Course_id, Course.Course_name
        FROM StudentCourse
        INNER JOIN Student ON Student.Roll_No = StudentCourse.Roll_No        
        INNER JOIN Course ON StudentCourse.Course_id = Course.Course_id
        ";
        $where  = ' ';
        if(isset($ROLLNUMBER)){
            $where = " where Student.Roll_No = $ROLLNUMBER";
        }

        $query = $query.$where;
        $this->prepareQuery($query);

    }

    public function joinQueryCourse ($COURSEID)
    {

        $query = "SELECT Course.Course_id , StudentCourse.Course_id, Course.Course_name, StudentCourse.Roll_No, Student.Name
        FROM StudentCourse
        INNER JOIN Course ON Course.Course_id = StudentCourse.Course_id        
        INNER JOIN Student ON StudentCourse.Roll_No = Student.Roll_No
        ";
        $where  = ' ';
        if(isset($COURSEID)){
            $where = " where Course.Course_id = $COURSEID";
        }

        $query = $query.$where;
        $this->prepareQuery($query);

    }

    /**
     * Insert row(s) to the database
     * @param string $table table name
     * @param array $data associative array containg data to be added
     */
    public function insert($table, $data)
    {

        ksort($data);

        $fieldNames = implode(',', array_keys($data));
        $fieldValues = ':'.implode(', :', array_keys($data));
        $query = "INSERT INTO $table ($fieldNames) VALUES($fieldValues)";

        $this->prepareQuery($query);

        foreach ($data as $key => $value) {
            $this->bind(":$key", $value);
        }
        $this->executeQuery($this->statement);
    }
    /**
     * Execute prepared query
     * @param string $statement statement to be executed
     */
    public function executeQuery(&$statement){
        $this->db_handler->execute($statement);

    }
    /**
     * Fetch single row of data from database
     * @param string $statement
     */
    public function fetch(&$statement)
    {
        return $this->db_handler->fetchSingleRow($statement);
    }
    /**
     * Fetch multiple rows from database as associative array
     * @param string $statement
     */
    public function fetchAll(&$statement)
    {
        return $this->db_handler->fetchAllRows($statement);
    }
    /**
     * Update a row of database
     * @param string $table table name
     * @param array $data data to updated
     * @param string $where where condition
     */
    public function update($table, array $data, $where = '')
    {
        ksort($data);
        $fieldDetails = NULL;
        foreach ($data as $key => $value)
        {
            $fieldDetails .="$key = '$value',";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        $query = "UPDATE $table SET $fieldDetails ".($where ? 'WHERE '.$where : '');
        $this->prepareQuery($query);
        foreach ($data as $key => $value)
        {
            //$this->bind(":$key", $value);;
            ;
        }

        $this->executeQuery($this->statement);
    }
    /**
     * Delete a row of database based upon primary key
     * @param string $table
     * @param string $where where condition
     * @param int $limit how many rows to be deleted
     */
    public function delete($table, $where, $limit = 1)
    {
        $this->prepareQuery("DELETE FROM $table WHERE $where LIMIT $limit");
        $this->executeQuery($this->statement);
    }
    /**
     * Returns multiple rows of database to model layer
     */
    public function resultSet(){
        $this->executeQuery($this->statement);
        return $this->fetchAll($this->statement);
    }
    /**
     * Returns single row of database to model layer
     */
    public function single()
    {
        $this->executeQuery($this->statement);
        return $this->fetch($this->statement);
    }
    /**
     * Getter of Database properties
     * @param string $property
     */
    public function __get($property){

        if(property_exists($this, $property)){
            return $this->$property;
        }
    }
    /**
     * Setter for Database properties
     * @param string $name
     * @param var $value
     */
    public function __set($name, $value)
    {
        return false;
    }
}
