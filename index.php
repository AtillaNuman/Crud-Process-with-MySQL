<?php 
include 'operation.php';
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1); 

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="snackbar.css">

    <title>CRUD Process</title>
    <style>
        
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <h1>Database (PDO) Registration Process</h1>
    <hr>


     <div id="form-container">
        <div id="formdiv">
            <form action="connect.php" method="POST" id="registerForm">

                <input type="text" name="myInf_name" placeholder="Your Name...">

                <input type="text" name="myInf_surname" placeholder="Your Surname..." required>

                <select name="myInf_gender" required>
                    <option value="" disabled selected>Choose your Gender</option>
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                </select>

                <input type="email" name="myInf_mail" placeholder="Your Mail..." required>

                <input type="password" name="myInf_password" placeholder="Your Password..." required>

                <input type="text" name="myInf_age" placeholder="Your Age..." required>

                <textarea name="myInf_description" placeholder="Your Comment..."></textarea>

                <button type="submit" name="send" onclick="myFunction()">Sign Up</button> <br>

                <button type="reset">Reset</button>

            </form>
        </div>
    </div>

    <div id="snackbar">

    </div>

    <script>
    $(document).ready(function() {
        $('#registerForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from refreshing the page

            $.ajax({
                url: 'operation.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    var snackbar = $('#snackbar');
                    snackbar.text(response); // Write incoming response to snackbar
                    snackbar.addClass('show');  // Show Snackbar

                    // Hide snackbar after 3 seconds
                    setTimeout(function(){ 
                        snackbar.removeClass('show'); 
                    }, 3000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('AJAX Error: ' + textStatus + ': ' + errorThrown);
                }
            });
        });
    });
</script>

</body>
</html>
