<?php
//Make the database connection.
  db_connect() or die('Unable to connect to database server!');

db_creds = parse_ini_file('../application/config/config.ini');

//You will need to replace the parameters below with the values for your database connection
//server = the database server (usually localhost).
//username = The user name to connect to the database.
//password = The password to connect to the database.
  function db_connect($server = 'localhost', $username = db_creds['db_username'], $password = db_creds['db_password'], $database = 'searchdb', $link = 'db_link') {
    global $$link;

    $$link = mysql_connect($server, $username, $password);

    if ($$link) mysql_select_db($database);

    return $$link;
  }
//Function to handle database errors.
  function db_error($query, $errno, $error) { 
    die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br><br>' . $query . '<br><br><small><font color="#ff0000">[STOP]</font></small><br><br></b></font>');
  }
//Function to query the database.
  function db_query($query, $link = 'db_link') {
    global $$link;

    $result = mysql_query($query, $$link) or db_error($query, mysql_errno(), mysql_error());

    return $result;
  }
//Get a row from the database query
  function db_fetch_array($db_query) {
    return mysql_fetch_array($db_query, MYSQL_ASSOC);
  }
//The the number of rows returned from the query.
  function db_num_rows($db_query) {
    return mysql_num_rows($db_query);
  }
//Get the last auto_increment ID.
  function db_insert_id() {
    return mysql_insert_id();
  }
//Add HTML character incoding to strings
  function db_output($string) {
    return htmlspecialchars($string);
  }
//Add slashes to incoming data
  function db_input($string, $link = 'db_link') {
    global $$link;

    if (function_exists('mysql_real_escape_string')) {
      return mysql_real_escape_string($string, $$link);
    } elseif (function_exists('mysql_escape_string')) {
      return mysql_escape_string($string);
    }

    return addslashes($string);
  }


?>
