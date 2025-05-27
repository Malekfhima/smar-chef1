<?php
header('Content-Type: application/json');

// Récupérer les données POST
$data = json_decode(file_get_contents('php://input'), true);
$userMessage = $data['message'] ?? '';

// Configuration de l'API Deepseek
$apiKey = 'sk-3e49332d43794da4bd796fb4eaa7f700';
$apiUrl = 'https://api.deepseek.com/v1/chat/completions';

// Contexte pour le chatbot
$context = "Tu es un assistant culinaire qui aide avec les questions de cuisine. Sois concis et précis.";

// Préparer la requête pour l'API Deepseek
$requestData = [
    'model' => 'deepseek-chat',
    'messages' => [
        [
            'role' => 'system',
            'content' => $context
        ],
        [
            'role' => 'user',
            'content' => $userMessage
        ]
    ],
    'temperature' => 0.5,
    'max_tokens' => 500,
    'stream' => false
];

// Initialiser cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey,
    'Accept: application/json',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_ENCODING, '');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

// Exécuter la requête
$response = curl_exec($ch);

// Vérifier les erreurs cURL
if(curl_errno($ch)) {
    error_log('Erreur cURL : ' . curl_error($ch));
    $botResponse = "Erreur de connexion : " . curl_error($ch);
} else {
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Gérer la réponse
    if ($httpCode === 200) {
        $responseData = json_decode($response, true);
        if (isset($responseData['choices'][0]['message']['content'])) {
            $botResponse = $responseData['choices'][0]['message']['content'];
        } else {
            error_log('Réponse API invalide : ' . print_r($responseData, true));
            $botResponse = "Format de réponse invalide de l'API";
        }
    } else {
        error_log('Erreur API (' . $httpCode . '): ' . $response);
        $botResponse = "Erreur de l'API (Code: " . $httpCode . "). Veuillez vérifier votre clé API ou réessayer plus tard.";
    }
}

curl_close($ch);

// Renvoyer la réponse
echo json_encode(['response' => $botResponse]);
?> 