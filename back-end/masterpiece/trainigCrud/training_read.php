<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $sql = "SELECT * FROM training";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $training = array();
        while ($row = $result->fetch_assoc()) {
            $training[] = $row;
        }
        echo json_encode($training);
    } else {
        echo json_encode(array("message" => "No training records found."));
    }
  } elseif ($_SERVER['REQUEST_METHOD'] == "POST") { 
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['training_id'])) {
        $id = $data['training_id'];
        $sql = "SELECT * FROM training WHERE training_id = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc();
            echo json_encode($category);
        } else {
            echo json_encode(array("message" => "training with the provided ID not found."));
        }
    } else {
        echo json_encode(array("error" => "Please provide the training ID."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}

