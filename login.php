<?php



$status = true;






// echo password_hash("123456",PASSWORD_BCRYPT);


include("include/conn.php");
include("include/function.php");
$login = cekSession();
if ($login == 1)
{
    redirect("index.php");
}

?>

<?php if($status){ ?>
<!DOCTYPE html>
<html lang="en"><meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Whatsapp CRM | Login</title>
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&amp;display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link rel="shortcut icon" type="image/x-icon" href="images/<?= $favicon_logo; ?>">
	
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<style>
		/* General Styling */
		body, html {
			margin: 0;
			padding: 0;
			height: 100%;
			font-family: 'Poppins', sans-serif;
			background-color: #f0f2f5;
			display: flex;
			flex-direction: column;
		}
		
		h2 {
    text-align: center;
    margin-bottom: 20px;
    font-weight: 600;
    color: #555; /* Lighten the text color */
}


		.container {
			flex: 1;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
		}

		.container .form-box {
			width: 100%;
			max-width: 400px;
			background-color: white;
			padding: 40px;
			border-radius: 10px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
			box-sizing: border-box;
		}

		.container img {
			width: 200px;
			display: block;
			margin: 0 auto 20px;
		}

		.container h2 {
			text-align: center;
			margin-bottom: 20px;
			font-weight: 600;
			color: #333;
		}

		.input-div {
			margin-bottom: 20px;
			position: relative;
			width: 100%;
		}

		.input-div i {
			position: absolute;
			left: 15px;
			top: 12px;
			color: #999;
		}

		.input-div input {
			width: 100%;
			padding: 12px 15px 12px 45px;
			border: none;
			border-radius: 30px;
			background-color: #f0f2f5;
			color: #333;
			font-size: 14px;
			outline: none;
			transition: background 0.3s ease;
			box-sizing: border-box; /* Ensure input fields are within the card */
		}

		.input-div input:focus {
			background-color: #e4e6eb;
		}

		.btn {
			width: 100%;
			padding: 12px;
			background-color:<?= $bgColor; ?>;
			color: white;
			border: none;
			border-radius: 30px;
			cursor: pointer;
			font-size: 16px;
			transition: background-color 0.3s ease;
			box-sizing: border-box;
		}

		.btn:hover {
			background-color: grey;
		}

		.links {
			text-align: center;
			margin-top: 15px;
		}

		.links a {
			color: <?= $bgColor; ?>;
			text-decoration: none;
			margin: 0 10px;
			font-size: 14px;
		}

		.links a:hover {
			text-decoration: underline;
		}

		.forgot-password {
			display: block;
			text-align: right;
			color: <?= $bgColor; ?>;
			font-size: 10px;
			margin-top: -10px;
			margin-bottom: 20px;
		}

		.forgot-password:hover {
			text-decoration: underline;
		}

		.footer {
			text-align: center;
			font-size: 12px;
			color: #aaa;
			padding: 20px 0;
			background-color: #f0f2f5;
			width: 100%;
		}

		.footer a {
			color: <?= $bgColor; ?>;
			text-decoration: none;
		}

		.footer a:hover {
			text-decoration: underline;
		}

		/* Responsive */
		@media (max-width: 600px) {
			.container .form-box {
				width: 90%;
			}
		}
		
		a{
		    color :<?= $color_background; ?>;
		}
		
		
	</style>
</head>
<body>
	<div class="container">
		<div class="form-box">
			<img src="images/<?= $main_logo; ?>" alt="ImbX Logo" style='width:160px;height:45px;'><br>

			<form id="login-form">
				<!-- Username Input -->
				<div class="input-div">
					<i class="fas fa-user"></i>
					<input type="text" id="username" name="username" placeholder="Username" required>
				</div>

				<!-- Password Input -->
				<div class="input-div">
					<i class="fa fa-user"></i>
					<input type="password" id="password" name="password" placeholder="Password" required>
				</div>

				<a href="/downloads/<?= $extension_file; ?>" class="forgot-password" target="_blank">Extensions Download ?</a>
				
				<!-- Submit Button -->
				<!--<input type="submit" class="btn" value="Login">-->
				<button type="submit" <?= $style; ?> class = "btn">Login</button>

				<!-- Links to Policy Pages -->
				<div class="links">
					<a href="<?= $external_link; ?>" target="_blank">More Programs</a>
					<a href="https://api.whatsapp.com/send?phone=<?= $supportPhoneNumber; ?>&text=I+want+to+discuss+about+whatsapp+crm." target="_blank">Chat on whatsapp</a>
				</div>
			</form>
		</div>
	</div>

	<div class="footer">
		<p><a href="https://wa.me/<?= $supportPhoneNumber; ?>" target="_blank">Contact Us</a></p>
	</div>

<script type="text/javascript" src="login-page/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
$(document).ready(function () {
    $('#login-form').submit(function (e) {
        e.preventDefault(); // Prevent the default form submission
        
        // Get the form data
        var formData = {
            username: $('#username').val(),
            password: $('#password').val()
        };

        // Send an AJAX POST request to your PHP script
        $.ajax({
            type: 'POST',
            url: 'function/check-login.php',
            data: formData,
            dataType: 'json', // important: to parse JSON automatically
            success: function (response) {
                if (response.status === true) {
                    // success
                    window.location.href = 'index.php';
                } else {
                    // failed
                    Swal.fire({
                                title: 'Error!',
                                text: 'Incorrect username or password !!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                }
            },
            error: function () {
                alert('An error occurred while processing the request.');
            }
        });

    });
});
</script>
<script disable-devtool-auto="" src="../pay.imb.org.in/Qrcode/disable-devtool.html" data-url="https://www.google.com/"></script> 
</body>
</html>
<?php } ?>