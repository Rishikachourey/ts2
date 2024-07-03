<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form id="registerForm">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <input type="tel" name="phone_number" placeholder="Phone Number" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="file" name="profile_photo" accept="image/*" required>
        <input type="submit" value="Register">
    </form>
    <div id="message"></div>

    <script>
        $(document).ready(function(){
            $('#registerForm').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'ajax/register_handler.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $('#message').html(response);
                        if (response.includes("successfully")) {
                            window.location.href = "login.php";
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
