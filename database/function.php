<?php
// connect to databases
function require_db(){
    global $table_prefix;
    
    $db_info['hostname'] = DB_HOST;
    $db_info['username'] = DB_USER;
    $db_info['password'] = DB_PASSWORD;
    $db_info['database'] = DB_NAME;
    $db_info['dbprefix'] = $table_prefix;
    
    $db = new DB($db_info);
    $db->initialize();

    $GLOBALS['db'] = $db;
    
    return $db;
}
?>