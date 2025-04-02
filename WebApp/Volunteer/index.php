<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Connect</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: no-repeat center center fixed;
            background-size: cover;
            transition: background-image 1s ease-in-out;
        }

        .container {
            color: white;
            padding: 20px;
            max-width: 600px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            position: relative;
        }

        .logo {
            position: absolute;
            top: -50px; /* Adjust this value as needed to position your logo correctly */
            left: 50%;
            transform: translateX(-50%);
            width: 100px; /*  logo's dimensions */
        }

        h1 {
            font-size: 2.5em;
            margin-top: 60px; /* Add margin to compensate for the logo positioning */
        }

        nav a {
            color: #fff;
            background: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="images/logo.jpg" class="logo" alt="Helping Minds Logo">
        <h1>Welcome to Helping Minds</h1>
        <nav>
            <a href="registration.php">Register</a>
            <a href="login.php">Login</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="?action=logout">Logout</a>
            <?php endif; ?>
        </nav>
    </div>

    <!-- jQuery for simpler JavaScript to change the background every 5sec, just to look professional-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var images = [
                'url("images/bg_image1.jpg")',
                'url("images/bg_image2.jpg")',
                'url("images/bg_image3.jpg")',
            ];
            var i = 0;

            // Change image function
            function changeBackground() {
                $('body').css({
                    'background-image': images[i]
                });
                i++;
                if (i == images.length) i = 0;
            }

            // Initial background set
            changeBackground();

            // Change background every 5 seconds
            setInterval(changeBackground, 5000);
        });
    </script>
</body>
</html>
