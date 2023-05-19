<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

date_default_timezone_set('Asia/Ho_Chi_Minh');

try {
    $con = new PDO("mysql:host=localhost;dbname=bac;charset=utf8", "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function exec_query($query, ...$values)
{
    global $con;
    try {
        $sth = $con->prepare($query);
        $sth->execute($values);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        return $sth;
    } catch (PDOException $e) {
        die("Query execution failed: " . $e->getMessage());
    }
}

function select_all($query, ...$values)
{
    $res = exec_query($query, ...$values);
    return $res->fetchAll();
}

function select_one($query, ...$values)
{
    $res = exec_query($query, ...$values);
    return $res->fetch();
}

function generate_id()
{
    $data = select_one('SELECT num_posts FROM counters');
    $current_idx = sprintf('%06d', $data['num_posts'] + 1);
    return base64_encode($current_idx);
}

