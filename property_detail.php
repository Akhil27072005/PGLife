<?php
session_start();
require "includes/database_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$property_id=$_GET['property_id'];

$sql1= "SELECT * FROM properties,cities WHERE properties.city_id=cities.city_id AND property_id=$property_id";
$result1=mysqli_query($conn,$sql1);

if (!$result1) {
    echo "Something went wrong!";
    return;
}
$property = mysqli_fetch_assoc($result1);
if (!$property) {
    echo "Something went wrong!";
    return;
}

$sql2="SELECT * FROM testimonials WHERE property_id=$property_id";
$result2=mysqli_query($conn,$sql2);

if (!$result2) {
    echo "Something went wrong!";
    return;
}
$testimonials = mysqli_fetch_all($result2, MYSQLI_ASSOC);


$sql3="SELECT * FROM amenities a, properties_amenities pa WHERE a.amenity_id=pa.amenity_id AND pa.property_id=$property_id";
$result3=mysqli_query($conn,$sql3);

if (!$result3) {
    echo "Something went wrong!";
    return;
}
$amenities = mysqli_fetch_all($result3, MYSQLI_ASSOC);


$sql4="SELECT * FROM users_properties WHERE property_id=$property_id";
$result4=mysqli_query($conn,$sql4);

if (!$result4) {
    echo "Something went wrong!";
    return;
}
$interested_users = mysqli_fetch_all($result4, MYSQLI_ASSOC);
$interested_users_count = mysqli_num_rows($result4);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $property['property_name']; ?> | PG Life </title>

    <?php include "includes/head_file.php";?>
    <link href="css/property_detail.css" rel="stylesheet" />
</head>

<body>
    
    <?php include "includes/header.php"; ?>
    <div id="loading">
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="home_page.php">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="property_list.php?city_name=<?= $property['city_name']; ?>"><?= $property['city_name']; ?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?= $property['property_name']; ?>
            </li>
        </ol>
    </nav>

    <div id="property-images" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
            $property_images = glob("img/properties/" . $property['property_id'] . "/*");
            foreach ($property_images as $index => $property_image) {
            ?>
                <li data-target="#property-images" data-slide-to="<?= $index ?>" class="<?= $index == 0 ? "active" : ""; ?>"></li>
            <?php
            }
            ?>
        </ol>
        <div class="carousel-inner">
            <?php
            foreach ($property_images as $index => $property_image) {
            ?>
                <div class="carousel-item <?= $index == 0 ? "active" : ""; ?>">
                    <img class="d-block w-100" src="<?= $property_image ?>" alt="slide">
                </div>
            <?php
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#property-images" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#property-images" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="property-summary page-container">
        <div class="row no-gutters justify-content-between">
            <?php 
            $total_rating=($property['rating_clean']+$property['rating_safety']+$property['rating_food'])/3;
            $total_rating=round($total_rating,1);
            ?>
            <div class="star-container" title="<?=$total_rating?>">
                <?php
                $rating=$total_rating;
                for($i=0;$i<5;$i++){
                    if($rating>$i + 0.8){
                ?>
                        <i class="fas fa-star"></i>
                <?php 
                    }elseif($rating>=$i + 0.3){
                ?>
                        <i class="fas fa-star-half-alt"></i>
                <?php
                    }else{
                ?>
                        <i class="far fa-star"></i>
                <?php
                    }
                }
                ?>
            </div>
            <div class="interested-container">
                <?php
                $is_interested=false; 
                foreach ($interested_users as $interested_user) {
                    if ($interested_user['user_id'] == $user_id) {
                        $is_interested = true;
                    }
                }
                ?>
                <i class="is-interested-image <?= $is_interested ? 'fas' : 'far' ?> fa-heart"></i>
                
                <div class="interested-text">
                    <span class="interested-user-count"><?= $interested_users_count ?></span> interested
                </div>
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
                <div class="rent">Rs <?= $property['price'] ?>/-</div>
                <div class="rent-unit">per month</div>
            </div>
            <div class="button-container col-6">
                <div class="btn btn-primary" aria-label="Enquire phone number">
                    <span class="text-group"> Enquire <i class="fas fa-phone" aria-hidden="true"></i></span>
                    <span class="phone-number">+91 92835 22841</span>
            </div>
            </div>
        </div>
    </div>

    <div class="property-amenities">
        <div class="page-container">
            <h1>Amenities</h1>
            <div class="row justify-content-between">
                <div class="col-md-auto">
                    <h5>Building</h5>
                    <?php
                    foreach ($amenities as $amenity) {
                        if ($amenity['type'] == "Building") {
                    ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg">
                                <span><?= $amenity['name'] ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

                <div class="col-md-auto">
                    <h5>Common Area</h5>
                    <?php
                    foreach ($amenities as $amenity) {
                        if ($amenity['type'] == "Common Area") {
                    ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg">
                                <span><?= $amenity['name'] ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

                <div class="col-md-auto">
                    <h5>Bedroom</h5>
                    <?php
                    foreach ($amenities as $amenity) {
                        if ($amenity['type'] == "Bedroom") {
                    ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg">
                                <span><?= $amenity['name'] ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

                <div class="col-md-auto">
                    <h5>Washroom</h5>
                    <?php
                    foreach ($amenities as $amenity) {
                        if ($amenity['type'] == "Washroom") {
                    ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg">
                                <span><?= $amenity['name'] ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="property-about page-container">
        <h1>About the Property</h1>
        <p><?= $property['about_property'] ?></p>
    </div>

    <div class="property-rating">
        <div class="page-container">
            <h1>Property Rating</h1>
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fas fa-broom"></i>
                            <span class="rating-criteria-text">Cleanliness</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?=$rating_clean?>">
                            <?php
                            $rating_clean=$property['rating_clean'];
                            $rating=$rating_clean;
                            for($i=0;$i<5;$i++){
                                if($rating>$i + 0.8){
                            ?>
                                    <i class="fas fa-star"></i>
                            <?php 
                                }elseif($rating>=$i + 0.3){
                            ?>
                                    <i class="fas fa-star-half-alt"></i>
                            <?php
                                }else{
                            ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fas fa-utensils"></i>
                            <span class="rating-criteria-text">Food Quality</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="3.4">
                            <?php
                            $rating_food=$property['rating_food'];
                            $rating=$rating_food;
                            for($i=0;$i<5;$i++){
                                if($rating>$i + 0.8){
                            ?>
                                    <i class="fas fa-star"></i>
                            <?php 
                                }elseif($rating>=$i + 0.3){
                            ?>
                                    <i class="fas fa-star-half-alt"></i>
                            <?php
                                }else{
                            ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fa fa-lock"></i>
                            <span class="rating-criteria-text">Safety</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="4.8">
                            <?php
                            $rating_safety=$property['rating_safety'];
                            $rating=$rating_safety;
                            for($i=0;$i<5;$i++){
                                if($rating>$i + 0.8){
                            ?>
                                    <i class="fas fa-star"></i>
                            <?php 
                                }elseif($rating>=$i + 0.3){
                            ?>
                                    <i class="fas fa-star-half-alt"></i>
                            <?php
                                }else{
                            ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="rating-circle">
                        <div class="total-rating"><?= $total_rating ?></div>
                        <div class="rating-circle-star-container">
                            <?php
                            $rating=$total_rating;
                            for($i=0;$i<5;$i++){
                                if($rating>$i + 0.8){
                            ?>
                                    <i class="fas fa-star"></i>
                            <?php 
                                }elseif($rating>=$i + 0.3){
                            ?>
                                    <i class="fas fa-star-half-alt"></i>
                            <?php
                                }else{
                            ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="property-testimonials page-container">
        <h1>What people say</h1>
        <?php 
        foreach($testimonials as $testimonial){
        ?>
            <div class="testimonial-block">
            <div class="testimonial-image-container">
                <img class="testimonial-img" src="img/man.png">
            </div>
            <div class="testimonial-text">
                <i class="fa fa-quote-left" aria-hidden="true"></i>
                <p><?= $testimonial['review'] ?></p>
            </div>
            <div class="testimonial-name">- <?= $testimonial['name'] ?></div>
            </div>
        <?php
        }
        ?>
        
    </div>

    <?php
    include "includes/login_modal.php";
    include "includes/signup_modal.php";
    include "includes/footer.php";
    ?>

    <script type="text/javascript" src="js/property_detail.js"></script>
</body>

</html>
