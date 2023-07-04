<?php 
$pdo = new PDO("mysql:host=localhost;dbname=event_booking_system", 'root', '');
$sql = "SET NAMES utf8";
$pdo->query($sql);  