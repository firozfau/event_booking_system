<?php

function getAllParticipationInformation() {
    global $pdo;
    $statement = $pdo->prepare("
	select
        participation.participation_id,
        `event`.event_date,
              `event`.event_name,
              `employees`.employee_name,
              `employees`.employee_mail,
              participation.participation_fee
       from  participation
       INNER JOIN `event` on `participation`.event_id=`event`.event_id
       INNER JOIN `employees` on `participation`.employee_id=`employees`.employee_id
       ORDER BY participation.participation_id ASC
	");
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($data)) {
        return $data;
    } else {
        return false;
    }
}

function getEmployeeInfo($name, $email) {
    global $pdo;
    $statement = $pdo->prepare("
	SELECT *
	FROM employees 
        where employee_name=? and employee_mail=?
	");
    $statement->execute([$name, $email]);
    $data = $statement->fetch();
    if (!empty($data)) {
        return $data;
    } else {
        return false;
    }
}

function getEventInfo($event_name) {
    global $pdo;
    $statement = $pdo->prepare("
	SELECT *
	FROM event 
        where event_name=?
	");
    $statement->execute([$event_name]);
    $data = $statement->fetch();
    if (!empty($data)) {
        return $data;
    } else {
        return false;
    }
}

function getParticipationInfo($event_id, $employee_id) {
    global $pdo;
    $statement = $pdo->prepare("
	SELECT *
	FROM participation 
        where event_id=? and employee_id=?
	");
    $statement->execute([$event_id, $employee_id]);
    $data = $statement->fetch();
    if (!empty($data)) {
        return $data;
    } else {
        return false;
    }
}

function insertEmployeeData($data) {
    global $pdo;
    $statement = $pdo->prepare("
    INSERT INTO `employees`
    (
        `employee_name`
        , `employee_mail`
        ) VALUES (
            :employee_name
            ,:employee_mail
        )
    ");
    $statement->execute($data);
    return $pdo->lastInsertId();
}

function insertEventData($data) {
    global $pdo;
    $statement = $pdo->prepare("
    INSERT INTO `event`
    (
        `event_name`
        , `event_date`
        ) VALUES (
            :event_name
            ,:event_date
        )
    ");
    $statement->execute($data);
    return $pdo->lastInsertId();
}

function insertParticipationData($data) {
    global $pdo;
    $statement = $pdo->prepare("
    INSERT INTO `participation`
    (
        `event_id`
        , `employee_id`
         , `participation_fee`
        ) VALUES (
            :event_id
            ,:employee_id
             ,:participation_fee
        )
    ");
    $statement->execute($data);
    return $pdo->lastInsertId();
}

function deleteEventAllData() {
    global $pdo;
    $statement = $pdo->prepare("TRUNCATE TABLE event");
    $statement->execute();
}

function deleteEmployeeAllData() {
    global $pdo;
    $statement = $pdo->prepare("TRUNCATE TABLE employees");
    $statement->execute();
}

function deleteParticipationAllData() {
    global $pdo;
    $statement = $pdo->prepare("TRUNCATE TABLE participation");
    $statement->execute();
}