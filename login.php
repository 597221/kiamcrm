<?php

// --- INICIO DE LA SOLUCIÓN CORS ---
header("Access-Control-Allow-Origin: https://web.whatsapp.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// --- FIN DE LA SOLUCIÓN CORS ---

include("include/conn.php");
include("include/function.php");
$login = cekSession();
if ($login == 1) {
    redirect("index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KiamberCRM | Iniciar Sesión</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="shortcut icon" type="image/x-icon" href="images/<?= $favicon_logo; ?>">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5; /* Un gris más suave como el del ejemplo */
        }
        
        /* Estilos para que el botón use tu color principal de la BD */
        .btn-principal {
            background-color: <?= $bgColor; ?>;
            color: white;
            transition: background-color 0.3s ease;
        }
        .btn-principal:hover {
            filter: brightness(0.9);
        }
        .focus-ring-principal:focus {
            --tw-ring-color: <?= $bgColor; ?>;
            --tw-ring-opacity: 0.5;
            box-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
        }
    </style>
</head>
<body class="antialiased">

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 max-w-4xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            <div class="hidden md:flex flex-col items-center justify-center p-12 bg-green-50">
                <img src="https://fil-e.b-cdn.net/Im%C3%A1genes/crm/Mique%20CRM%20Whatsapp.png" 
                     alt="Ilustración de CRM" class="w-full h-auto object-cover">
                <h2 class="mt-6 text-2xl font-bold text-gray-700 text-center">Gestiona tus chats de forma eficiente</h2>
                <p class="mt-2 text-gray-500 text-center">Tu solución CRM para WhatsApp todo en uno.</p>
            </div>

            <div class="p-8 md:p-12">
                <div class="flex justify-center mb-6">
                    <img src="images/<?= $main_logo; ?>" alt="Logotipo KiamberCRM" class="h-14">
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2 text-center">Bienvenido de Nuevo</h1>
                <p class="text-gray-500 mb-8 text-center">Por favor, inicia sesión para continuar.</p>

                <form id="login-form" class="space-y-6">
                    <div>
                        <label for="username" class="block text-gray-700 text-sm font-semibold mb-2">Usuario</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input type="text" id="username" name="username" placeholder="Tu nombre de usuario"
                                   class="w-full pl-10 pr-4 py-2.5 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus-ring-principal" required>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Contraseña</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input type="password" id="password" name="password" placeholder="Tu contraseña"
                                   class="w-full pl-10 pr-4 py-2.5 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus-ring-principal" required>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <a href="/downloads/<?= $extension_file; ?>" class="text-sm font-medium" style="color: <?= $bgColor; ?>;" target="_blank">¿Descargar extensión?</a>
                    </div>

                    <button type="submit" <?= $style; ?> 
                            class="w-full btn-principal font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                        Iniciar Sesión
                    </button>

                    <div class="text-center text-sm pt-4">
                        <a href="<?= $external_link; ?>" target="_blank" class="text-gray-600 hover:text-gray-900 mx-2 transition-colors">Más Programas</a>
                        <span class="text-gray-300">|</span>
                        <a href="https://api.whatsapp.com/send?phone=<?= $supportPhoneNumber; ?>&text=Hola,+me+gustaría+poder+hablar+sobre+el+CRM+de+WhatsApp." target="_blank" class="text-gray-600 hover:text-gray-900 mx-2 transition-colors">Chatear en WhatsApp</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#login-form').submit(function (e) {
            e.preventDefault(); // Prevenir el envío por defecto del formulario
            
            // Obtener los datos del formulario
            var formData = {
                username: $('#username').val(),
                password: $('#password').val()
            };

            // Enviar la petición AJAX a tu script de PHP
            $.ajax({
                type: 'POST',
                url: 'function/check-login.php', // Esta es tu lógica original
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.status === true) {
                        // Éxito: Redirigir al panel principal
                        window.location.href = 'index.php';
                    } else {
                        // Fallo: Mostrar alerta de error
                        Swal.fire({
                            title: '¡Error!',
                            text: 'El usuario o la contraseña son incorrectos.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '<?= $bgColor; ?>' // Usa tu color de marca
                        });
                    }
                },
                error: function () {
                    // Error en la petición
                    Swal.fire({
                        title: '¡Oops!',
                        text: 'Ocurrió un error al procesar la solicitud. Por favor, inténtalo de nuevo.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '<?= $bgColor; ?>'
                    });
                }
            });
        });
    });
    </script>
    
</body>
</html>