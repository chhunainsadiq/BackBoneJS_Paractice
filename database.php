<?php
ini_set('display_errors', 1);

require_once 'dbhelper.php';
/**
 *
 */
define('DB_HOST', 'localhost');
/**
 *
 */
define('DB_NAME', 'BackBone_CRUD');
/**
 *
 */
define('DB_USER', 'root');
/**
 *
 */
define('DB_PASS', '');

//object of dbhelper created here
$dbo = new dbhelper();

$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);

if (isset($_REQUEST['_method'])) $_SERVER['REQUEST_METHOD'] = $_REQUEST['_method'];
//$tablee = $_REQUEST['_table'];

/**
 * Find the position of the first occurrence of a substring in a string
 **/
$request_method = strtolower($_SERVER['REQUEST_METHOD']);
// switch is used for the create ,update and delete, the post used for insert , put used for update, and get for the select
switch($request_method) {
    //insertion to the dbhelper
    case 'post':
    {
        $data = $_REQUEST['model'];
        $data=json_decode($data, true);
        $tableName = $data['table'];
        unset($data['table'], $data['_method']);
        if($tableName== "StudentCourse")
            unset($data['Course_name'], $data['Name'] );
         $dbo->insert($tableName, $data);

        break;
    }

    //updation to the dbhelper
    case 'put':
    {

        $data = $_REQUEST['model'];
        $data=json_decode($data, true);
        $tableName = $data['table'];
        unset($data['table'], $data['_method']);
        $where = '';
        if(isset($data['Roll_No']))
            $where = 'Roll_No = '.$data['Roll_No'].'';
        else if(isset($data['Course_id']))
            $where = 'Course_id = '.$data['Course_id'].'';
        $dbo->update($tableName, $data, $where);

        break;
    }
    //selection to the dbhelper
    case 'get':
    {
        $result = null;
        $tableName = $_GET['table'];
       if($tableName != "StudentCourse")
        {
            $dbo->select($tableName);
            $result = $dbo->resultSet();
        }
        else
        {
            $Roll_No = null;
            if(isset($_GET['Roll_No']))
            {
                $Roll_No = $_GET['Roll_No'];
                $dbo->joinQuery($Roll_No);
            }

            else
            {
                $Roll_No = $_GET['Course_id'];
                $dbo->joinQueryCourse($Roll_No);
             }
            $result = $dbo->resultSet();
        }
        echo json_encode($result);

        break;
    }
    case 'delete':
    {
        $data = $_REQUEST['model'];
        $data=json_decode($data, true);
        $tableName = $data['table'];
        unset($data['table'], $data['_method']);
        $where = '';
        if(isset($data['Roll_No']))
            $where = 'Roll_No = '.$data['Roll_No'].'';
        else if(isset($data['Course_id']))
            $where = 'Course_id = '.$data['Course_id'].'';
        $dbo->delete($tableName, $where);

        break;
    }
}
?>
