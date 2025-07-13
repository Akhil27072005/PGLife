<div class=" header sticky-top">   <!--Navigation bar-->
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="home_page.php">
                    <img src="img/logo.png"/>
                </a>
                <div class="collapse navbar-collapse justify-content-end" id="my-navbar">
                    <ul class="navbar-nav">
                        <?php
                            if(!isset($_SESSION["user_id"])){
                        ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="modal" data-target="#signup-modal">
                                        <i class="fas fa-user"></i>Signup    
                                    </a>
                                </li>
                                <div class="nav-vl"></div>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="modal" data-target="#login-modal">
                                        <i class="fas fa-sign-in-alt"></i>Login  
                                    </a>
                                </li>
                        <?php
                            } else{
                        ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="dashboard.php">
                                        <i class="fas fa-user"></i> <?php echo $_SESSION['full_name'];?>  
                                    </a>
                                </li>
                                <div class="nav-vl"></div>
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php">
                                        <i class="fas fa-sign-out-alt"></i>Logout 
                                    </a>
                                </li>

                        <?php
                            }
                        ?>
                        
                    </ul>
                </div>
            </nav>
        </div>