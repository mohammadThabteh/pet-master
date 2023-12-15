<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");


// Assuming you have a database connection already established
$dbHost = 'localhost';
$dbName = 'pet';
$dbUser = 'root';
$dbPass = '';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit();
}

// Get JSON data from the request
$jsonData = json_decode(file_get_contents('php://input'), true);

// Validate JSON data
if ($jsonData === null) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit();
}

// Extract user_id from JSON data
$user_id = $jsonData['user_id'] ?? null;

// Validate user_id
if ($user_id === null) {
    http_response_code(400);
    echo json_encode(['error' => 'user_id is required']);
    exit();
}

try {
    // Prepare and execute the SQL update statement
    $stmt = $pdo->prepare("
        UPDATE animal_booking
        INNER JOIN animal ON animal_booking.animal_id = animal.id
        SET animal_booking.status = 'accepted'
        WHERE animal.user_id = :user_id AND animal_booking.status = 'pending'
    ");

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Check if any rows were affected
    $rowCount = $stmt->rowCount();

    // Send response
    if ($rowCount > 0) {
        echo json_encode(['success' => true, 'message' => "$rowCount records updated"]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No records updated']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
