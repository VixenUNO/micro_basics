<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['msg'])) {
        http_response_code(400);
        echo "Missing 'msg'";
        exit;
    }

    $uuid = uniqid('', true);
    $data = ['uuid' => $uuid, 'msg' => $input['msg']];

    $ch = curl_init('http://logging-service/log');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_exec($ch);
    curl_close($ch);

    echo "Message logged with UUID: $uuid";

} elseif ($requestMethod === 'GET') {
    $logResponse = file_get_contents('http://logging-service/logs');
    $msgResponse = file_get_contents('http://messages-service/message');
    echo $logResponse . "\n" . $msgResponse;
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
