<?php
header("Content-Type: application/json");

$mensagem = $_POST["mensagem"] ?? "";

$api_key = "gen-lang-client-0980037362I";

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$api_key";

$prompt_iot= "
Você é um assistente virtual que explica conceitos básicos de enfermagem com IoT.
Fale de uma forma simples, como se estivesse falando para iniciantes.
Dê exemplos praticos como: a internet das coisas está sendo usada no campo da enfermagem.

Mensagem:  $mensagem
";

$data = [
    "contents" => [
        [
            "parts" => [
                ["text" => $prompt]
            ]
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["resposta" => "Erro ao conectar: " . curl_error($ch)]);
    exit;
}

curl_close($ch);

$json = json_decode($response, true);

$resposta = $json["candidates"][0]["content"]["parts"][0]["text"]
    ?? "A IA não respondeu.";

echo json_encode(["resposta" => $resposta]);
