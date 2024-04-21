<?php
include 'config.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT d.id FROM devices d WHERE d.MAC = '" . $_POST["device"] . "'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $voltage = $_POST["voltage"];
    $current = $_POST["current"];
    $power = $_POST["power"];
    $light = $_POST["light"];
    $effectivity = $_POST["effectivity"];
    $row = $result->fetch_assoc();
    $device = $row["id"];

    $sql = "INSERT INTO data (voltage, current, power, light, effectivity, device_id, created_at) VALUES ('$voltage', '$current', '$power', '$light', '$effectivity', '$device', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "OK " . $sql;
    } else {
        echo "Chyba " . $sql;
    }
} else {
    echo "Toto zariadenie nie je registrované";
}
?>