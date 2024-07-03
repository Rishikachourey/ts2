<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault(); // Prevent normal form submission

                var email = $('#email').val();
                var password = $('#password').val();

                $.ajax({
                    type: 'POST',
                    url: 'ajax/login_handler.php',
                    data: { email: email, password: password },
                    dataType: 'json',
                    success: function(response) {
                        if (response.includes('success')) {
                            window.location.href = 'product.php';
                        }
                       else {
                            $('#loginMessage').html('<p class="error">' + response.message + '</p>');
                        }
                    },
                    error: function() {
                        $('#loginMessage').html('<p class="error">An error occurred. Please try again later.</p>');
                    }
                });
            });
        });
    </script>
    <!-- <script>
        $(document).ready(function(){
            $('#loginForm').on('submit', function(e){
                e.preventDefault(); // Prevent default form submission
                $.ajax({
                    url: 'ajax/login_handler.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response){
                        $('#message').html(response);
                        if (response.includes("User successfully logged in.")) {
                            window.location.href = 'shop.php';
                        }
                    }
                });
            });
        });
    </script> -->
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form id="loginForm" method="POST">
            <div id="loginMessage"></div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
