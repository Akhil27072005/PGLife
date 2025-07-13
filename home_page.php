<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> home_page </title>

        <?php
        include "includes/head_file.php";
        ?>
        <link href="css/home_page.css" rel="stylesheet"/>

    </head>
    
    <body>

        <?php 
        include "includes/header.php";
        ?>

        <div id="loading"></div>  

        <nav aria-label="breadcrumb"> <!--Breadcrumb-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
        </nav>

        <!--Image Section with Search-->
        <div class="d-flex align-items-center justify-content-center text-center" style="background-image: url('img/bg.png'); background-size: cover; background-position: center; height: 500px; position: relative; background-attachment: fixed;">   <!--image with search bar section-->
        <div style="background-color: rgba(0, 0, 0, 0.385); position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1;" ></div>
            <div class=" text-white" style="z-index: 2;">
            
                 <h1 class="mb-4 fw-bold">Happiness per Square Foot</h1>
                 <form class="d-flex justify-content-center" action="property_list.php" method="GET">
                    <input type="text" class="form-control" name="city_name" placeholder="Enter your city to search for PG's">
                    <button class="btn btn-primary" type="submit"> Search </button>
                 </form>
            </div>

        </div>

        <div class="container text-center my-5">  <!--Cities-->
            <h1>Major Cities</h1>
            <div class="row justify-content-center mt-4 city row">

                <div class="col-6 col-sm-3 mb-4">
                <div class="city-card text-center city-button" data-city="delhi" >
                    <img src="img/delhi.png" class="img-fluid rounded circle" >
                </div>
                </div>

                <div class="col-6 col-sm-3 mb-4">
                <div class="city-card text-center city-button" data-city="mumbai">
                    <img src="img/mumbai.png" class="img-fluid rounded circle" >
                </div>
                </div>

                <div class="col-6 col-sm-3 mb-4">
                <div class="city-card text-center city-button" data-city="bengaluru">
                    <img src="img/bangalore.png" class="img-fluid rounded circle" >
                </div>
                </div>

                <div class="col-6 col-sm-3 mb-4">
                <div class="city-card text-center city-button" data-city="hyderabad">
                    <img src="img/hyderabad.png" class="img-fluid rounded circle" >
            </div>
            </div>

        </div>
        </div>

        <div class="modal-footer"> <!--Footer-->
            <p class="card-text">Find your stay now</p>
        </div>

        <?php
        include "includes/signup_modal.php";
        include "includes/login_modal.php";
        include "includes/footer.php";
        ?>

        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript" src="js/home_page.js"></script>

    </body>
</html>