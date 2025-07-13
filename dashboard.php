<?php
session_start();
require "includes/database_connect.php";

if (!isset($_SESSION["user_id"])) {
    header("location: home_page.php");
    die();
}
$user_id = $_SESSION['user_id'];

$sql1="SELECT * FROM users WHERE user_id= $user_id";
$result1=mysqli_query($conn,$sql1);
if(!$result1){
    echo "Something went wrong";
    return;
}
$user=mysqli_fetch_assoc($result1);
if(!$user){
    echo "Something went wrong";
    return;
}

$sql2="SELECT * FROM users_properties up, properties p WHERE up.property_id=p.property_id AND up.user_id=$user_id";
$result2=mysqli_query($conn,$sql2);
if(!$result2){
    echo "Something went wrong";
}
$interested_properties=mysqli_fetch_all($result2,MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard</title>
        
        <?php
        include "includes/head_file.php";
        ?>
        <link href="css/dashboard.css" rel="stylesheet"/>
    </head>

    <body>
        
        <?php 
        include "includes/header.php";
        ?>

        <div id="loading"></div>  

        <nav aria-label="breadcrumb"> <!--Breadcrumb-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="home_page.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
        </nav>

        <div style="padding-top: 20px; padding-left: 50px;"><h1><b>My Profile</b></h1></div>
        <div class=profile-section; style="padding-left: 200px;">
            <div class="profile-container" style="padding-left: 250px;">
                <i class="fas fa-user fa-5x" style="margin-right: 20px;"></i>
                <div class="profile-details">
                    <div style="font-weight: bold;"><?= $user['full_name']?></div>
                    <div><?= $user['email']?></div>
                    <div><?= $user['phone_number']?></div>
                    <div><?= $user['college_name']?></div>  
                </div>
               <a href="#" class="edit-profile" data-toggle="modal" data-target="#edit-profile-modal" style="padding-left: 100px; padding-top: 100px; padding-right: 30px;">Edit Profile </a>

            </div>
        </div>
        

        <?php
    if (count($interested_properties) > 0) {
    ?>
        <div class="my-interested-properties">
            <div class="page-container">
                <h1>My Interested Properties</h1>

                <?php
                foreach ($interested_properties as $property) {
                    $property_images = glob("img/properties/" . $property['property_id'] . "/*");
                ?>
                    <div class="property-card property-id-<?= $property['property_id'] ?> row">
                        <div class="image-container col-md-4">
                            <img src="<?= $property_images[0] ?>" />
                        </div>
                        <div class="content-container col-md-8">
                            <div class="row no-gutters justify-content-between">
                                <?php
                                $total_rating = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safety']) / 3;
                                $total_rating = round($total_rating, 1);
                                ?>
                                <div class="star-container" title="<?= $total_rating ?>">
                                    <?php
                                    $rating = $total_rating;
                                    for ($i = 0; $i < 5; $i++) {
                                        if ($rating >= $i + 0.8) {
                                    ?>
                                            <i class="fas fa-star"></i>
                                        <?php
                                        } elseif ($rating >= $i + 0.3) {
                                        ?>
                                            <i class="fas fa-star-half-alt"></i>
                                        <?php
                                        } else {
                                        ?>
                                            <i class="far fa-star"></i>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="interested-container">
                                    <i class="is-interested-image fas fa-heart" property_id="<?= $property['property_id'] ?>"></i>
                                </div>
                            </div>
                            <div class="detail-container">
                                <div class="property-name"><?= $property['property_name'] ?></div>
                                <div class="property-address"><?= $property['address'] ?></div>
                                <div class="property-gender">
                                    <?php
                                    if ($property['gender'] == "male") {
                                    ?>
                                        <img src="img/male.png">
                                    <?php
                                    } elseif ($property['gender'] == "female") {
                                    ?>
                                        <img src="img/female.png">
                                    <?php
                                    } else {
                                    ?>
                                        <img src="img/unisex.png">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="rent-container col-6">
                                    <div class="rent">Rs <?= number_format($property['price']) ?>/-</div>
                                    <div class="rent-unit">per month</div>
                                </div>
                                <div class="button-container col-6">
                                    <a href="property_detail.php?property_id=<?= $property['property_id'] ?>" class="btn btn-primary">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } 
                ?>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
    include "includes/signup_modal.php";
    include "includes/login_modal.php";
    include "includes/footer.php";
    include "includes/edit_profile_modal.php"
    ?>

    <script type="text/javascript" src="js/dashboard.js"></script>
    </body>
</html>