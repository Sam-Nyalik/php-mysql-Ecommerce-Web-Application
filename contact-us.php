<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$firstName = $lastName = $email = $message = "";
$firstName_error = $lastName_error = $email_error = $message_error = "";

// Process form data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate firstName
    if (empty(trim($_POST["firstName"]))) {
        $firstName_error = "First Name field is required!";
    } elseif (!preg_match("/^[a-zA-Z]+$/", trim($_POST["firstName"]))) {
        $firstName_error = "First name requires only letters!";
    } else {
        $firstName = trim($_POST["firstName"]);
    }

    // Validate LastName
    if (empty(trim($_POST["lastName"]))) {
        $lastName_error = "Last Name field is required!";
    } elseif (!preg_match("/^[a-zA-Z]+$/", trim($_POST["lastName"]))) {
        $lastName_error = "Last name requires only letters!";
    } else {
        $lastName = trim($_POST["lastName"]);
    }

    // Validate Email Address
    if (empty(trim($_POST["email"]))) {
        $email_error = "Email Address field is required!";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate Message
    if (empty(trim($_POST["message"]))) {
        $message_error = "Message Field is required!";
    } else {
        $message = trim($_POST["message"]);
    }
}

?>

<!-- Header template -->
<?= headerTemplate('CONTACT US'); ?>

<!-- Topbar -->
<?= top_barTemplate() ?>

<!-- Main Navbar -->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" id="header">
    <div class="container">
        <h3 class="navbar-brand"><a href="index.php?page=home">E-Commerce.</a></h3>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php?page=home">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="" class="dropdown-item">Apple</a>
                        <a href="" class="dropdown-item">Samsung</a>
                        <a href="" class="dropdown-item">Huawei</a>
                        <a href="" class="dropdown-item">Dell</a>
                        <a href="" class="dropdown-item">Hp</a>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="" class="dropdown-item">All Products</a>
                        <a href="index.php?page=phone_products" class="dropdown-item">Phone Products</a>
                        <a href="" class="dropdown-item">Laptop Products</a>
                    </ul>

                </li>
                <li class="nav-item">
                    <a href="index.php?page=contact-us" class="nav-link active">Contact</a>
                </li>
            </ul>
            <span class="navbar-icons">
                <i class="bi bi-bag" style="margin-right: 30px;"><span class="text-dark">(0)</span></i>
                <i class="bi bi-heart" style="margin-right: 45px;"><span class="text-dark">(0)</span></i>
            </span>
        </div>
    </div>
</nav>

<!-- Contact Header -->
<div id="contact_header">
    <div class="container">
        <div class="row text-center">
            <div class="contact_header_description">
                <h3>How Can We Help?</h3>
                <h5>Shoot us a message!</h5>
            </div>
        </div>
    </div>
</div>

<!-- Contact Us -->
<div id="contact_us">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <form action="" method="post" class="contact_us_form">
                    <!-- General Errors -->
                    <div class="form-group">
                        <span class="text-danger">
                            <ul>
                                <!-- FirstName Error -->
                                <li><?php
                                    if ($firstName_error) {
                                        echo $firstName_error;
                                    }
                                    ?></li>

                                <!-- LastName Error -->
                                <li><?php
                                    if ($lastName_error) {
                                        echo $lastName_error;
                                    }
                                    ?></li>

                                <!-- Email Error -->
                                <li><?php
                                    if ($email_error) {
                                        echo $email_error;
                                    }
                                    ?></li>

                                <!-- Message Error -->
                                <li><?php
                                    if ($message_error) {
                                        echo $message_error;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>
                    <!-- FirstName -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" name="firstName" class="form-control 
                                <?php echo (!empty($firstName_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstName; ?>">
                            </div>
                        </div>

                        <!-- LastName -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" name="lastName" class="form-control 
                                <?php echo (!empty($lastName_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastName; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="EmailAddress">Email Address</label>
                        <input type="email" name="email" class="form-control 
                        <?php echo (!empty($email_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                    </div>

                    <!-- Message -->
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="message" class="form-control 
                        <?php echo (!empty($message_error)) ? 'is-invalid' : ''; ?>"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group my-3">
                        <input type="submit" value="Send Message" class="btn w-100">
                    </div>
                </form>
            </div>

            <!-- Google Maps -->
            <div class="col-md-5">
                <h4>Google Maps</h4>
            </div>
        </div>
    </div>
</div>

<!-- Primary Footer -->
<?= primary_footerTemplate(); ?>

<!-- Footer Template -->
<?= footerTemplate(); ?>