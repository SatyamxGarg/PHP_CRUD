<?php

header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod === 'POST') {
    handlePostRequest();
} else { 
    echo json_encode(['error' => 'Unsupported request method']);
}

function handlePostRequest() {
    
    $data = file_get_contents('php://input');

   
    $decodedData = json_decode($data, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Invalid JSON']);
        return;
    }

    if (isset($decodedData['countryId'])) {
        $countryId = $decodedData['countryId'];
        
        
        include 'connect.php';

        
        $stmt = $con->prepare("SELECT * FROM Country WHERE c_name = ?");
        $stmt->bind_param("s", $countryId); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $c_id = $row['id'];

            
            $stmt = $con->prepare("SELECT * FROM State WHERE cntry_id = ?");
            $stmt->bind_param("i", $c_id); 
            $stmt->execute();
            $result1 = $stmt->get_result();

            $arr = [];
            while ($row = $result1->fetch_assoc()) {
                $arr[] = [
                    'id' => $row['id'],
                    'cntry_id' => $row['cntry_id'],
                    'state_name' => $row['state_name'],
                ];
            }

            echo json_encode($arr);
        } else {
            echo json_encode(['error' => 'Country not found']);
        }
    } else {
        echo json_encode(['error' => 'countryId not provided']);
    }
}

?>
