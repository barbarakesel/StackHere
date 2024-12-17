<?php
$connection = mysqli_connect("localhost", "root", "", "itstudents");
if (!$connection) {
    print ('Не удалось подключиться к базе данных');
    exit();
}

mysqli_query($connection, "SET NAMES 'utf8'");
mysqli_query($connection, "SET CHARACTER SET 'utf8'");
mysqli_query($connection, "SET SESSION collation_connection 'utf8_general_ci'");
mysqli_query($connection, 'SET NAMES utf8 COLLATE utf8_general_ci');