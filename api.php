<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
$dataDir = __DIR__ . DIRECTORY_SEPARATOR . 'data';
if (!is_dir($dataDir) && !mkdir($dataDir, 0775, true) && !is_dir($dataDir)) {
    http_response_code(500); echo json_encode(['error' => 'Não foi possível criar o armazenamento.']); exit;
}
$file = $dataDir . DIRECTORY_SEPARATOR . 'escola.json';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method === 'GET') {
    if (!is_file($file)) { echo json_encode(null); exit; }
    readfile($file); exit;
}
if ($method !== 'PUT') { http_response_code(405); header('Allow: GET, PUT'); echo json_encode(['error' => 'Método não permitido.']); exit; }
$raw = file_get_contents('php://input');
$payload = json_decode($raw ?: '', true);
if (!is_array($payload) || !isset($payload['students'], $payload['classes'], $payload['records']) || !is_array($payload['students']) || !is_array($payload['classes']) || !is_array($payload['records'])) {
    http_response_code(400); echo json_encode(['error' => 'Dados inválidos.']); exit;
}
$encoded = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
if ($encoded === false || file_put_contents($file, $encoded, LOCK_EX) === false) {
    http_response_code(500); echo json_encode(['error' => 'Não foi possível salvar os dados.']); exit;
}
echo json_encode(['ok' => true]);
