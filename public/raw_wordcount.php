<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); 
    echo json_encode(['error' => 'Only POST method is allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['content']) || empty(trim($input['content']))) {
    http_response_code(400);
    echo json_encode(['error' => 'Content is missing or empty']);
    exit;
}

$content = trim($input['content']);
$wordCount = str_word_count(strip_tags($content));


echo json_encode(['word_count' => $wordCount]);
