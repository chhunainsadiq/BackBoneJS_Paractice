<?php
/**
 * Contains definition of PDODRIVER
 */

/**
 * Driver class for PDO
 */
class PDODRIVER
{
    /**
     * Contains host name
     * @var string
     */
    private $host = "localhost";
    /**
     * Contains user name to your dbms
     * @var string
     */
    private $user = "root";
    /**
     * Contains password to your dbms
     * @var string
     */
    private $pass = "";
    /**
     * Contains name of your database
     * @var string
     */
    private $dbname = "BackBone_CRUD";
    /**
     * Contains shared instance of PDODriver
     * @var object
     */
    private static $instance = null;
    /**
     * Getter
     * @param string $property
     */
    public function __get($property){

        if(property_exists($this, $property)){
            return $this->$property;
        }
    }
    /**
     * Setter
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value)
    {
        return false;
    }
    /**
     * Returns a shared instance of Driver class
     */
    public static function getInstance(){

        if(self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        //Set DSN
        $dsn = 'mysql:host=' . $this->host .';dbname=' . $this->dbname;
        //Set Options
        $options = array(
            PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        try{
            $db_handler = new PDO($dsn, $this->user, $this->pass, $options);

        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }
    /**
     * Returns the connection to database
     */
    public function getConnection()
    {
        //Set DSN
        $dsn = 'mysql:host=' . $this->host .';dbname=' . $this->dbname;
        //Set Options
        $options = array(
            PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        try{
            $db_handler = new PDO($dsn, $this->user, $this->pass, $options);
            return $db_handler;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }
    /**
     * prepared statement directly using PDO methods
     * @param string $query
     */
    public function prepare($query)
    {
        $conn = $this->getConnection();
        //return PDO::prepare($conn, $query);
        return $conn->prepare($query);
    }
    /**
     * Execute statement using PDO execute method
     * @param PDOStatement $statement
     */
    public function execute($statement)
    {
        // $statement;
        $statement->execute();

    }
    /**
     * Returns associated array by PDO methods
     * @param PDOStatement $statement
     */
    public function fetchAllRows($statement)
    {
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * returns single row from database
     * @param PDOStatement $statement
     */
    public function fetchSingleRow($statement)
    {
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}