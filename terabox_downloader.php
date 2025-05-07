<?php
header('Content-Type: application/json');

if (!isset($_GET['url'])) {
    echo json_encode(["status" => "error", "message" => "No URL provided"]);
    exit;
}

$url = $_GET['url'];

// Requesting the actual API (using sam0077 API in your case)
$apiUrl = "http://sami0077.serv00.net/terabox.php?url=" . urlencode($url);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Decode the response
$data = json_decode($response, true);

// Check if the API responded with success and return video info
if ($data && $data['status'] === 'success' && isset($data['data'])) {
    $fileData = $data['data'];

    echo json_encode([
        "status" => "success",
        "data" => [
            "title" => $fileData['title'],
            "size" => $fileData['size'],
            "thumbnail" => $fileData['thumbnail'],
            "downloadUrl" => $fileData['downloadUrl']
        ]
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Unable to fetch video information"]);
}

