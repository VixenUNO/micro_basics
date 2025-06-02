<?php

$storageFile = '/tmp/logs.json';

function loadLogs() {
    global $storageFile;
    if (file_exists($storageFile)) {
        $data = file_get_contents($storageFile);
        return json_decode($data, true) ?? [];
    }
    return [];
}

function saveLogs($logs) {
    global $storageFile;
    file_put_contents($storageFile, json_encode($logs));
}

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/log' && $requestMethod === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $logs = loadLogs();
    $logs[$input['uuid']] = $input['msg'];
    saveLogs($logs);
    echo "Logged: " . $input['msg'];

} elseif ($requestUri === '/logs' && $requestMethod === 'GET') {
    $logs = loadLogs();
    echo implode("\n", array_values($logs));

} else {
    http_response_code(404);
    echo "Not Found";
}

?>
