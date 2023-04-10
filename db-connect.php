<?php
$host = "localhost";
$username = "root";
$pw = "";
$dbname = "dummy_db";

$conn = new mysqli($host, $username, $pw, $dbname);
if(!$conn){
    die("Database Connection Failed!");
}
