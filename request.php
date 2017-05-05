<?php
header("Access-Control-Allow-Origin: *");

// Database class folder path
define( 'DBPATH', dirname(__FILE__) . '/database/' );

// erro reporting
error_reporting( E_ALL );

// get db environment variables
require_once( 'config.php' );

// include all databse classes
require_once( DBPATH . 'index.php' );
require_once( DBPATH . 'function.php' );

//check up to exsist of DB class
if ( !class_exists('DB') ) {
error_code('can not find db class.', __FILE__, __LINE__);
}

//global db variable
$db = require_db();


//create database and tables
$sql = "CREATE DATABASE " . DB_NAME;
$db->query($sql);

$sql ="USE " . DB_NAME;
$db->query($sql);

$tbl_fields = array(
    'id' => array(
                    'type' => 'int',
                    'constraint' => 11, 
                    'null' => false,
                    'auto_increment' => true
              ),
    'email' => array(
                    'type' => 'varchar',
                    'constraint' => 255,
                    'null' => false
              ),
    'password' => array(
                    'type' => 'varchar',
                    'constraint' => 255,
                    'null' => false
              ),
    'name' => array(
                    'type' => 'varchar',
                    'constraint' => 255,
                    'null' => false
              )          
    );
                    
$db->add_field($tbl_fields);
$db->add_key('id', true);
$db->create_table(TBL_USERS, true);


//request processor
extract($_REQUEST, EXTR_OVERWRITE, "");

if (@$action == "signin"){    
    $db->where('email', $email);
    $db->where('password', $password);
    $n = $db->get(TBL_USERS)->num_rows();
    if ($n == 1){
        echo '{"status": "yes"}';
    } else {
        echo '{"status": "no"}';
    }
} else if (@$action == "signup"){    
    $db->where('email', $email);
    $n = $db->get(TBL_USERS)->num_rows();
    if ($n == 1){
        echo '{"status": "email"}';
    } else {
        $db->set("name", $name);
        $db->set("password", $password);
        $db->set("email", $email);
        
        if ($db->insert(TBL_USERS)){
            echo '{"status": "yes"}';
        } else {
            echo '{"status": "no"}';
        }
    }    
} else {
    echo "nothing received!";
    die(0);
}

?>
