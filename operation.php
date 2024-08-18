<?php 
session_start();
ob_start();
include 'connect.php';

function hack_control(string $str){
    $str = trim($str);
    $str = strip_tags($str);
    $str = htmlspecialchars($str);      
    return $str;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Print to screen to check POST data
    $is_valid = true; // Initially the form is considered valid
    $response_message = "";



    // Detaylı POST veri kontrolleri
    $myInf_name = $myInf_surname = $myInf_gender = $myInf_mail = $myInf_age = $myInf_description = "";
    //$nameErr = $surnameErr = $sexErr = $mailErr = $passErr = $ageErr = $commErr = ""; // Optional way

    $is_valid = true; // To monitor the validity of all form data

 // Name field validation
if (empty($_POST["myInf_name"])) {
    $response_message = "The name field cannot be left blank.";

    $is_valid = false;

} else {
    $myInf_name = hack_control($_POST["myInf_name"]);
    // Check if ad only contains letters and whitespace, including Turkish characters
    if (!preg_match("/^[a-zA-ZçÇğĞıİöÖşŞüÜ' -]*$/", $myInf_name)) {
        $response_message = "Only letter and space characters are valid for the name.";

        $is_valid = false;
    }
}

     // Surname field validation
    if (empty($_POST["myInf_surname"])) {
        $response_message = "Soyad alanı boş bırakılamaz.";

        $is_valid = false;

    } else {
        $myInf_surname = hack_control($_POST["myInf_surname"]);
        // Check if soyad only contains letters and whitespace, including Turkish characters
        if (!preg_match("/^[a-zA-ZçÇğĞıİöÖşŞüÜ' -]*$/", $myInf_surname)) {
            $response_message = "Only letter and space characters are valid for the surname.";

            $is_valid = false;
        }
    }

    // Gender field validation
    if (empty($_POST["myInf_gender"])) {
        $response_message = "The gender field cannot be left blank.";

        $is_valid = false;

    } else {
        $myInf_gender = hack_control($_POST["myInf_gender"]);
        // Additional cinsiyet-specific validation can be added here if needed
    }

    // Mail field validation
    if (empty($_POST["myInf_mail"])) {
        $response_message = "The mail field cannot be left blank.";

        $is_valid = false;

    } else {
        $myInf_mail = hack_control($_POST["myInf_mail"]);
        // Check if the email address is well-formed
        if (!filter_var($myInf_mail, FILTER_VALIDATE_EMAIL)) {
            $response_message = "Invalid e-mail format.";

            $is_valid = false;
        }
    }

		// Yaş field validation
		if (empty($_POST["myInf_age"])) {
		    $response_message = "The age field cannot be left blank";

		    $is_valid = false;

		} else {
		    $myInf_age = hack_control($_POST["myInf_age"]);

		    // Check if yaş is a valid number
		    if (!filter_var($myInf_age, FILTER_VALIDATE_INT)) {
		        $response_message = "Invalid age format. Please enter only numbers.";

		        $is_valid = false;

		    } else {
		        // Check if yaş is within the acceptable range
		        if ($myInf_age < 0 || $myInf_age > 140) {
		            $response_message = "The age must be between 0 and 140 years.";

		            $is_valid = false;
		        }
		    }
		}

    // Dexcription field validation
    if (empty($_POST["myInf_description"])) {
        $aciklamaErr = "The description field cannot be left blank.";
        //echo $aciklamaErr . '<br>';
        $is_valid = false;

    } else {
        $myInf_description = hack_control($_POST["myInf_description"]);
        // Additional description-specific validation can be added here if needed
    }

    // If all fields are valid, add to the database
    if ($is_valid) {
        try {
            // Hash the password
            $hashed_password = password_hash($_POST["myInf_password"], PASSWORD_DEFAULT);

                // Write SQL Query correctly
            $add_member = $db->prepare("INSERT INTO bilgilerim (myInf_name, myInf_surname, myInf_gender, myInf_mail, myInf_password, password_hash, myInf_age, myInf_description) 
            VALUES (:name, :surname, :gender, :email, :password, :hash, :age, :description)");

            // This script creates a hash value using the user email address, password and the current timestamp.
            $hash = md5(sha1($_POST["myInf_mail"] . $_POST["myInf_password"].time()));

            // Parametreleri bağla
            $add_member->bindParam(":name", $myInf_name);
            $add_member->bindParam(":surname", $myInf_surname);
            $add_member->bindParam(":gender", $myInf_gender);
            $add_member->bindParam(":email", $myInf_mail);
            $add_member->bindParam(":password", $hashed_password); // Use secure hashed password
            $add_member->bindParam(":hash", $hash);
            $add_member->bindParam(":age", $myInf_age);
            $add_member->bindParam(":description", $myInf_description);

            // Run the query and check the result
            if ($add_member ->execute()) {
                echo "Kayıt başarılı.";
            } else { 
                echo "Kayıt başarısız.";
                print_r($add_member->errorInfo());
            }
        } catch (PDOException $e) {
            echo "Hata: " . $e->getMessage();
        }
    }
    // Response message to be returned to AJAX
    echo $response_message;
    exit;
}
?>
