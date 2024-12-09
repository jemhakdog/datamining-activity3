<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.blackbox.ai/api/chat');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'sec-ch-ua-platform: "Android"',
    'Referer: https://www.blackbox.ai/',
    'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36',
    'sec-ch-ua: "Google Chrome";v="131", "Chromium";v="131", "Not_A Brand";v="24"',
    'DNT: 1',
    'Content-Type: application/json',
    'sec-ch-ua-mobile: ?1',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"messages":[{"role":"user","content":"@web search py","id":"UDeoaZG"}],"id":"iJQoJIz","previewToken":null,"userId":null,"codeModelMode":true,"agentMode":{},"trendingAgentMode":{},"isMicMode":false,"maxTokens":1024,"playgroundTopP":null,"playgroundTemperature":null,"isChromeExt":false,"githubToken":"","clickedAnswer2":false,"clickedAnswer3":false,"clickedForceWebSearch":false,"visitFromDelta":false,"mobileClient":false,"userSelectedModel":null,"validated":"00f37b34-a166-4efb-bce5-1312d87f2f94","imageGenerationMode":false,"webSearchModePrompt":false}');

$response = curl_exec($ch);

echo $response;

curl_close($ch);