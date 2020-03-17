<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../src/Client.php';

$clients = [];
$testClients = 1;
$testMessages = 1;
for ($i = 0; $i < $testClients; $i++) {
    $clients[$i] = new \Bloatless\WebSocket\Client;
    $clients[$i]->connect('127.0.0.1', 8000, '/demo', 'foo.lh');
}
echo 'asd';
// usleep(5000);

$payload = json_encode([
    'action' => 'echo',
    'data' => 'dos',
]);

for ($i = 0; $i < $testMessages; $i++) {
    $clientId = rand(0, $testClients-1);
    $clients[$clientId]->sendData($payload);
    // usleep(5000);
}
// usleep(5000);
