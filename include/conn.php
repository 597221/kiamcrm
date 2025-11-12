<?php
// Configuración de reporte de errores AL INICIO
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', 0); // Ocultar errores en producción

date_default_timezone_set('Asia/Calcutta'); 

// --- DETALLES DE CONEXIÓN ---
$host = "mysql-catalogo.alwaysdata.net";
$username = "catalogo_querend";
$password = "querendon13102025";
$db = "catalogo_querend";

// --- CONEXIÓN PRINCIPAL ---
$conn = mysqli_connect($host, $username, $password, $db);

if (!$conn) {
    // Log seguro sin mostrar detalles sensibles
    error_log("Database connection failed: " . mysqli_connect_error());
    die("Failed To Connect Database! Error: 02H");
}

// Conexión secundaria (si realmente necesitas dos)
$conn1 = new mysqli($host, $username, $password, $db);
if ($conn1->connect_error) {
    error_log("Secondary database connection failed: " . $conn1->connect_error);
    // No morir aquí si la primera conexión funciona
}

// ====================== Secure Fetch Configuration ====================

// Initialize config array
$config = [];

// Prepare the query safely
$stmt = $conn->prepare("SELECT config_key, config_value FROM config");

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch as associative array
    while ($row = $result->fetch_assoc()) {
        $config[$row['config_key']] = $row['config_value'];
    }

    $stmt->close();
} else {
    // Log error pero no detener la ejecución
    error_log("Error in preparing statement: " . $conn->error);
}

// --- Configuración con valores por defecto ---
$website_name       = isset($config['site_name']) ? $config['site_name'] : 'CRM System';
$support_email      = isset($config['support_email']) ? $config['support_email'] : 'support@example.com';
$supportPhoneNumber = isset($config['support_mobile']) ? $config['support_mobile'] : '';
$color_background   = isset($config['color_background']) ? $config['color_background'] : '#ffffff';
$color_text         = isset($config['color_text']) ? $config['color_text'] : '#000000';
$main_logo          = isset($config['main_logo']) ? $config['main_logo'] : 'default-logo.png';
$favicon_logo       = isset($config['favicon_logo']) ? $config['favicon_logo'] : 'favicon.ico';
$extension_file     = isset($config['extension_file_name']) ? $config['extension_file_name'] : '';
$external_link      = isset($config['external_link']) ? $config['external_link'] : '#';
$trial_days         = isset($config['trial_days']) ? $config['trial_days'] : 1;

// Style assignment with escaping
$style = "style='background:" . htmlspecialchars($color_background) . ";color:" . htmlspecialchars($color_text) . ";border:none;'";

//Session auto expire if your not active on portal
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$timeout_duration = 180; // seconds

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    // Session timeout
    session_unset();      // Clear all session variables
    session_destroy();    // Destroy the session
    header("Location: login.php?timeout=true");
    exit();
}

$_SESSION['last_activity'] = time(); // Reset last activity time

?>