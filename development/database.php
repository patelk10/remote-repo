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

