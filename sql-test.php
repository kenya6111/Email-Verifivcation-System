<?php
spl_autoload_extensions(".php");
spl_autoload_register();
require_once "vendor/autoload.php";
use Database\MySQLWrapper;

$mysqli = new MySQLWrapper();

$studentsData = [
    ['Alice', 20, 'Computer Science'],
    ['Bob', 22, 'Mathematics'],
    ['Charlie', 21, 'Physics'],
    ['David', 23, 'Chemistry'],
    ['Eve', 20, 'Biology'],
    ['Frank', 22, 'History'],
    ['Grace', 21, 'English Literature'],
    ['Hannah', 23, 'Art History'],
    ['Isaac', 20, 'Economics'],
    ['Jack', 24, 'Philosophy']
];

foreach ($studentsData as $student) {
    $insertQuery = "INSERT INTO students (name, age, major) VALUES ('$student[0]', $student[1], '$student[2]')";
    $mysqli->query($insertQuery);
}