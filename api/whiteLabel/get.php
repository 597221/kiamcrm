<?php
// --- INICIO DE LA SOLUCIÓN CORS ---
// Estas líneas permiten que la extensión (desde web.whatsapp.com) se conecte a tu API.
header("Access-Control-Allow-Origin: https://web.whatsapp.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// --- FIN DE LA SOLUCIÓN CORS ---

header('Content-Type: application/json');

$response = [
    "success" => true,
    "message" => "WL capturada",
    "wl" => [
        "id" => "gjlfpggiddcminhebiejofeglfjmleli",
        "checkout" => "https://wa.me/573004085041?text=Hola%2C+deseo+adquirir+KiamberCRM+PRO",
        "tutorial" => "https://www.youtube.com/@catalogos_co",
        "webhook" => "",
        "cor_primaria" => 0,
        "banner" => null,
        "status" => "ACTIVE",
        "install" => "https://watidy.com.br/baixou",
        "uninstall" => "https://watidy.com.br/desinstalou",
        "rewards" => "https://www.youtube.com/@catalogos_co",
        "suporte" => "https://api.whatsapp.com/send/?phone=%2B573004085041&text=Hola%2C+deseo+soporte+estoy+utilizando+KiamberCRM",
        "webhook_login_clients" => "https://n8n.manyflux.com.br/webhook/64c4296d-61d8-4271-9ff2-1aa44c8a192c",
        "ia_wascript" => "https://ia.wascript.com.br/produto/pacote-premium-2",
        "meetAovivo" => [
            "users" => "ALL",
            "aoVivo" => false,
            "online" => [
                "title" => "📢 Estamos ao Vivo!",
                "btnName" => "🔗 Acesse a apresentação aqui:",
                "urlMeet" => "https://meet.google.com/ffj-xdtc-may",
                "description" => "Hoje teremos nossa live semanal às 15 horas. Já salve nosso link para aprender mais sobre nossa ferramenta!\n\nAproveite para tirar suas dúvidas online!"
            ],
            "offline" => [
                "title" => "",
                "active" => false,
                "description" => "",
                "suportRedirect" => false
            ],
            "fusoHorario" => "America/Sao_Paulo",
            "activationDays" => [
                "sexta" => ["active" => false, "start_time" => "14:30", "finish_time" => "16:00"],
                "terca" => ["active" => false, "start_time" => "", "finish_time" => ""],
                "quarta" => ["active" => false, "start_time" => "11:04", "finish_time" => "11:19"],
                "quinta" => ["active" => false, "start_time" => "", "finish_time" => ""],
                "sabado" => ["active" => false, "start_time" => "", "finish_time" => ""],
                "domingo" => ["active" => false, "start_time" => "00:00", "finish_time" => "00:00"],
                "segunda" => ["active" => false, "start_time" => "", "finish_time" => ""]
            ]
        ],
        "suporte_clientes" => [
            "free" => "https://api.whatsapp.com/send/?phone=%2B573004085041&text=Hola%2C+deseo+soporte+estoy+utilizando+KiamberCRM",
            "premium" => "https://api.whatsapp.com/send/?phone=%2B573004085041&text=Hola%2C+deseo+soporte+estoy+utilizando+KiamberCRM"
        ]
    ]
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>