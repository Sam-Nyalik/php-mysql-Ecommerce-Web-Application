<?php

// Start a session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the admin is logged in
include_once "includes/check_login.php";
include_once "functions/functions.php";
$pdo = databaseConnect();

// Define variables and assign them empty values
$productName = $productDescription = $productType = $productBrand = $productRetailPrice = $productPrice = $productQuantity = $productImage = $success = "";
$productName_error = $productDescription_error = $productType_error = $productBrand_error = $productRetailPrice_error = $productPrice_error = $productQuantity_error = $productImage_error = $general_error =  "";

// Process form data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Product Name
    if (empty(trim($_POST["productName"]))) {
        $productName_error = "Product Name field is required!";
    } else {
        $productName = trim($_POST["productName"]);
    }

    // Validate Product Description
    if (empty(trim($_POST["productDescription"]))) {
        $productDescription_error = "Product Description field is required!";
    } else {
        $productDescription = trim($_POST["productDescription"]);
    }

    // Validate Product Type
    if (empty($_POST["productType"])) {
        $productType_error = "Product Type field is required!";
    } else {
        $productType = $_POST["productType"];
    }

    // Validate Product Brand
    if (empty($_POST["productBrand"])) {
        $productBrand_error = "Product Brand field is required!";
    } else {
        $productBrand = $_POST["productBrand"];
    }

    // Validate Product Retail Price
    if (empty(trim($_POST["productRetailPrice"]))) {
        $productRetailPrice_error = "Product Retail Price Field is required!";
    } else {
        $productRetailPrice = trim($_POST["productRetailPrice"]);
    }

    // Validate Product Price
    if (empty(trim($_POST["productPrice"]))) {
        $productPrice_error = "Product Price field is required!";
    } else {
        $productPrice = trim($_POST["productPrice"]);
    }

    // Validate Product Quantity
    if (empty(trim($_POST["productQuantity"]))) {
        $productQuantity_error = "Product Quantity field is required!";
    } else {
        $productQuantity = trim($_POST["productQuantity"]);
    }

    // Check for errors before dealing with the database
    if (empty($productName_error) && empty($productDescription_error) && empty($productType_error) && empty($productBrand_error) && empty($productRetailPrice_error) && empty($productQuantity_error) && empty($productPrice_error)) {
        // Upload the product image
        if (!empty($_FILES["productImage"]["name"])) {
            move_uploaded_file($_FILES["productImage"]["tmp_name"], "/opt/lampp/htdocs/php-ecommerce/administrator/allProductImages/" . $_FILES["productImage"]["name"]);
            $productImage = "/opt/lampp/htdocs/php-ecommerce/administrator/allProductImages/" . $_FILES["productImage"]["name"];

            // Prepare an INSERT statement
            $sql = "INSERT INTO all_products(productName, productDescription, productType, productBrand, productRetailPrice, productPrice, productQuantity, productImage) VALUES (
                :productName, :productDescription, :productType, :productBrand, :productRetailPrice, :productPrice, :productQuantity, :productImage)";

            if ($stmt = $pdo->prepare($sql)) {
                //Bind variables to the prepared statement as parameters
                $stmt->bindParam(":productName", $param_productName, PDO::PARAM_STR);
                $stmt->bindParam(":productDescription", $param_productDescription, PDO::PARAM_STR);
                $stmt->bindParam(":productType", $param_productType, PDO::PARAM_STR);
                $stmt->bindParam(":productBrand", $param_productBrand, PDO::PARAM_STR);
                $stmt->bindParam(":productRetailPrice", $param_productRetailPrice, PDO::PARAM_INT);
                $stmt->bindParam(":productPrice", $param_productPrice, PDO::PARAM_INT);
                $stmt->bindParam(":productQuantity", $param_productQuantity, PDO::PARAM_INT);
                $stmt->bindParam(":productImage", $param_productImage, PDO::PARAM_STR);

                // Set parameters
                $param_productName = $productName;
                $param_productDescription = $productDescription;
                $param_productType = $productType;
                $param_productBrand = $productBrand;
                $param_productRetailPrice = $productRetailPrice;
                $param_productPrice = $productPrice;
                $param_productQuantity = $productQuantity;
                $param_productImage = $productImage;

                // Attempt to execute
                if ($stmt->execute()) {
                    $success = "Product has been added successfully!";
                } else {
                    $general_error = "There was an error. Please try again!";
                }

                // Close the statement
                unset($stmt);
            }
        } else {
            $productImage_error = "Please upload an image!";
        }
    }
}
?>

<!-- Header template -->
<?= headerTemplate('ADMIN | ADD_PRODUCTS'); ?>

<!-- Main Navbar -->
<?php include_once "includes/main_navbar.php" ?>

<!-- Section title -->
<div class="section-title" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <h5>Add Products</h5>
        </div>
    </div>
</div>

<!-- Add Products Form -->
<div class="container">
    <div id="profile">
        <div class="row my-5">
            <div class="col-md-5">
                <h1>Add General Products</h1>
                <form action="index.php?page=administrator/add_products" method="post" enctype="multipart/form-data" class="profile_form">
                    <!-- Success Message -->
                    <div class="form-group">
                        <span class="text-success">
                            <ul>
                                <li><?php
                                    if ($success) {
                                        echo $success;
                                    }
                                    ?></li>
                            </ul>
                        </span>
                    </div>

                    <!-- General Errors -->
                    <div class="form-group">
                        <span class="text-danger">
                            <ul>
                                <!-- General Error -->
                                <li><?php
                                    if ($general_error) {
                                        echo $general_error;
                                    }
                                    ?></li>

                                <!-- Product Name Error -->
                                <li><?php
                                    if ($productName_error) {
                                        echo $productName_error;
                                    }
                                    ?></li>

                                <!-- Product Description Error -->
                                <li><?php
                                    if ($productDescription_error) {
                                        echo $productDescription_error;
                                    }
                                    ?></li>

                                <!-- Product Type Error -->
                                <li><?php
                                    if ($productType_error) {
                                        echo $productType_error;
                                    }
                                    ?></li>

                                <!-- Product Brand Error -->
                                <li><?php
                                    if ($productBrand_error) {
                                        echo $productBrand_error;
                                    }
                                    ?></li>

                                <!-- Product Retail Price -->
                                <li><?php
                                    if ($productRetailPrice_error) {
                                        echo $productRetailPrice_error;
                                    }
                                    ?></li>

                                <!-- Product Price Error -->
                                <li><?php
                                    if ($productPrice_error) {
                                        echo $productPrice_error;
                                    }
                                    ?></li>

                                <!-- Product Quantity Error -->
                                <li><?php
                                    if ($productQuantity_error) {
                                        echo $productQuantity_error;
                                    }
                                    ?></li>

                                <!-- Product Image Error -->
                                <li><?php 
                                    if($productImage_error){
                                        echo $productImage_error;
                                    }
                                ?></li>
                            </ul>
                        </span>
                    </div>

                    <!-- Product Name -->
                    <div class="form-group">
                        <label for="ProductName">Product Name</label>
                        <input type="text" name="productName" value="<?php echo $productName; ?>" class="form-control 
                        <?php echo (!empty($productName_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Product Description -->
                    <div class="form-group">
                        <label for="productDescription">Product Description</label>
                        <textarea name="productDescription" class="form-control w-100 <?php echo (!empty($productDescription_error)) ? 'is-invalid' : ''; ?>"><?php echo $productDescription; ?></textarea>
                    </div>

                    <!-- Product Type -->
                    <div class="form-group">
                        <label for="productType">Product Type</label>
                        <select name="productType" class="form-control <?php echo (!empty($productType_error)) ? 'is-invalid' : ''; ?>">
                            <option value="" disabled>Choose Product Type</option>
                            <!-- Prepare a SELECT statement to get all the product types from the database -->
                            <?php
                            $sql = $pdo->prepare("SELECT * FROM product_types");
                            $sql->execute();
                            $database_product_type = $sql->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php foreach ($database_product_type as $type) : ?>
                                <option value="<?= $type['productType']; ?>"><?= $type['productType']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Product Brand -->
                    <div class="form-group">
                        <label for="productBrand">Product Brand</label>
                        <select name="productBrand" class="form-control <?php echo (!empty($productBrand_error)) ? 'is-invalid' : ''; ?>">
                            <option value="" disabled>Choose Product Brand</option>
                            <!-- Prepare a SELECT statement to get all the product brands from the database -->
                            <?php
                            $sql = $pdo->prepare("SELECT * FROM product_brands");
                            $sql->execute();
                            $database_product_brands = $sql->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php foreach ($database_product_brands as $productBrand) : ?>
                                <option value="<?= $productBrand['productBrand']; ?>"><?= $productBrand['productBrand']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Product Retail Price -->
                    <div class="form-group">
                        <label for="ProductRetailPrice">Product Retail Price</label>
                        <input type="number" name="productRetailPrice" value="<?php echo $productRetailPrice; ?>" class="form-control 
                        <?php echo (!empty($productRetailPrice_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Product price -->
                    <div class="form-group">
                        <label for="productPrice">Product Price</label>
                        <input type="number" name="productPrice" value="<?php echo $productPrice; ?>" class="form-control 
                        <?php echo (!empty($productPrice_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Product Quantity -->
                    <div class="form-group">
                        <label for="productQuantity">Product Quantity</label>
                        <input type="number" name="productQuantity" value="<?php echo $productQuantity; ?>" class="form-control 
                        <?php echo (!empty($productQuantity_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Product image -->
                    <div class="form-group">
                        <label for="productImage">Product Image</label>
                        <input type="file" name="productImage" class="form-control 
                        <?php echo (!empty($productImage_error)) ? 'is-invalid' : ''; ?>">
                    </div>

                    <!-- Submit Btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Add New Product" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Footer Template -->
<?= footerTemplate(); ?>