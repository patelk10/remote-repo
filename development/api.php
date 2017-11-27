<?php
/**
 * Server IP address: http://159.203.139.147/api.php
 * PHPmyadmin: http://159.203.139.147/phpmyadmin.php
 * Created by PhpStorm.
 * User: kunal
 * Date: 11/22/2017
 * Time: 1:14 PM
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$servername = "localhost";
$username = "admin";
$password = "Kunal_25";

try {
    $conn = new PDO("mysql:host=$servername;dbname=android_final_project_api", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $err_msg = [];
    $json = file_get_contents('php://input');
    $arrays = json_decode($json, true);

    for ($i = 0, $len = count($arrays); $i < $len; $i++) {
        if (empty($arrays[$i]["imei"])) {
            $err_msg[] = 'IMEI number not provided. '.$i;
        } elseif (empty($arrays[$i]["packageName"])) {
            $err_msg[] = 'Package Name not provided. '.$i;
        } elseif (empty($arrays[$i]["appName"])) {
            $err_msg[] = 'App Name not provided. '.$i;
        }
    }

    if (count($err_msg) != 0) {
        echo json_encode($err_msg);
    } else {

        $stmt = $conn->prepare("INSERT INTO users (imei, packageName, appName) VALUES (:imei, :packageName, :appName)");
        $stmt->bindParam(':imei', $imei);
        $stmt->bindParam(':packageName', $packageName);
        $stmt->bindParam(':appName', $appName);

        foreach ($arrays as $array) {
            $imei = $array["imei"];
            $packageName = $array["packageName"];
            $appName = $array["appName"];
            $stmt->execute();
        }

        $conn = null;

        $data_saved = array("success" => "true", "message" => "All Data Saved");
        echo json_encode($data_saved);
    }


}
