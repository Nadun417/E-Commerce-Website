<DOCTYPE html>
<html>
<head>
	<meta charset="UFT 8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Account - Velvet Vogue</title>
	<link rel="stylesheet" href="style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>


		<div class="container">
			<div class="navbar">
				<div class="logo">
					<a href="VVhome.php"><img src="Logos\logo.png" width="125px"></a>
				</div>
				<nav>
					<ul id="MenuItems">
						<li><a href="VVhome.php">Home</a></li>
						<li><a href="Product.php">All Products</a></li>
						<li><a href="Account.php">Account</a></li>
					</ul>
				</nav>

				<a href="Shopping_cart.php"><img src="Images/shopping-cart.png" width="30px" height="30px"></a>
				<img src="Logos\menu 1.png" class="menu-icon" onclick="menuToggle()">

			</div>
		</div>

<!--------account-page--------->

	<div class="account-page">
		<div class="container">
			<div class="row">
				<div class="col-2">
					<img src="Images/pngwing.com (2).png" alt="Account Page Image" style="width: 100%;">
				</div>
            
				<div class="col-2">
					<div class="form-container">
						<div class="form-btn">
							<span onclick="login()">Login</span>
							<span onclick="register()">Register</span>
							<hr id="Indicator">
						</div>
						
						<form id="LoginForm">
							<input type="text" placeholder="Username">
							<input type="password" placeholder="Password">
							<button type="submit" class="btn">Login</button>
							<a href="">Forgot password</a>
						</form>
						
						<form id="RegForm">
							<input type="text" placeholder="Username">
							<input type="text" placeholder="Real Name">
							<input type="email" placeholder="Email">
							<input type="password" placeholder="Password">
							<input type="Phone Number" placeholder="Phone Number">
							<input type="Address" placeholder="Address">
							<button type="submit" class="btn">Register</button>							
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>




<!-------footer------->
	
	<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-col-6">
                <h4>Download Our App</h4>
                <p>Download App for Android and iOS mobile phone.</p>
			<div class="app-logo">
				<img src="Logos\icon 6.png">
			</div>
            </div>
            <div class="footer-col-6">
                <img src="Logos\logo.png" alt="Logo">
                <p>
                    Our purpose is to sustainably make the pleasure and benefits of
                    sports accessible to the many.
                </p>
            </div>
            <div class="footer-col-6">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Coupons</a></li>
                    <li><a href="#">Blog Post</a></li>
                    <li><a href="#">Return Policy</a></li>
                    <li><a href="#">Join Affiliate</a></li>
                </ul>
            </div>
            <div class="footer-col-6">
                <h4>Follow Us</h4>
                <ul class="social-icons">
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                </ul>
            </div>
        </div>
		<hr>
			<p class="copyright">Copyright 2024 - Velvet Vogue</p>
    </div>
</footer>

<!-------js for toggle menu-------->
	<script>
    // Get the menu items element
    var MenuItems = document.getElementById("MenuItems");

    // Set initial height
    MenuItems.style.maxHeight = "0px";

    // Toggle function for the menu
    function menuToggle() {
        if (MenuItems.style.maxHeight === "0px") {
            MenuItems.style.maxHeight = "200px"; 
        } else {
            MenuItems.style.maxHeight = "0px"; 
        }
    }
	</script>

<!-------js for toggle Form-------->
	<script>
	
		var LoginForm = document.getElementById("LoginForm");
		var RegForm = document.getElementById("RegForm");
		var Indicator = document.getElementById("Indicator");

		function register(){
			RegForm.style.transform = "translateX(0px)";
			LoginForm.style.transform = "translateX(0px)"; 
			Indicator.style.transform = "translateX(100px)";
		}

		function login(){
			RegForm.style.transform = "translateX(300px)"; 
			LoginForm.style.transform = "translateX(300px)"; 
			Indicator.style.transform = "translateX(0px)"; 
		}
	</script>
	
</body>
</html>