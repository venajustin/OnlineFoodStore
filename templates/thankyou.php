<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #88d498;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .thank-you-message {
            opacity: 1;
            transition: opacity 2s ease-in-out;
            color: #1c3144;
            font-size: 35px;
            
        }

        .hide-message {
            opacity: 0;
        }
    </style>
</head>
<body>

<div class="thank-you-message" id="thankYouMessage">
    <h1>Thank you for your order!</h1>
    <h3>Order status can be viewed from account page</h3>
</div>

<script>
    
    window.onload = function () {
        setTimeout(function () {
            var thankYouMessage = document.getElementById('thankYouMessage');
            thankYouMessage.classList.add('hide-message');
            
            // Redirect to a new page after the animation duration
            setTimeout(function () {
                window.location.href = 'home.php'; 
            }, 1500);
        }, 100);
    };
</script>

</body>
</html>
