<?php
    include_once '../config/db.php';
    include '../src/autoloader.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Farm Assistant | Home</title>
</head>
<body>
    <div class="header">
        <label>Keep Track of your Farm Activities!</label>
        <div class="header-links">
            <a href='login.php'>Login</a>
            <a href='register.php'>Register</a>
        </div>
    </div>
    <a class="logo" alt="Logo"href="index.php">Farm<br>Assistant</a>
    <div class="navBar">
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#aboutus">About Us</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#contact">Contact Us</a></li>
        </ul>
    </div>
    <div id="home" class="carousel">
        <ul class="slides">
            <input type="radio" name="radio-buttons" id="img-1" checked />
            <li class="slide-container">
                <div class="slide-image">
                <img src="images/slide-img1.jpg">
                </div>
                <div class="carousel-controls">
                <label for="img-5" class="prev-slide">
                    <span>&lsaquo;</span>
                </label>
                <label for="img-2" class="next-slide">
                    <span>&rsaquo;</span>
                </label>
                </div>
            </li>
            <input type="radio" name="radio-buttons" id="img-2" />
            <li class="slide-container">
                <div class="slide-image">
                <img src="images/slide-img2.jpg">
                </div>
                <div class="carousel-controls">
                <label for="img-1" class="prev-slide">
                    <span>&lsaquo;</span>
                </label>
                <label for="img-3" class="next-slide">
                    <span>&rsaquo;</span>
                </label>
                </div>
            </li>
            <input type="radio" name="radio-buttons" id="img-3" />
            <li class="slide-container">
                <div class="slide-image">
                <img src="images/slide-img3.jpg">
                </div>
                <div class="carousel-controls">
                <label for="img-2" class="prev-slide">
                    <span>&lsaquo;</span>
                </label>
                <label for="img-4" class="next-slide">
                    <span>&rsaquo;</span>
                </label>
                </div>
            </li>
            <input type="radio" name="radio-buttons" id="img-4" />
            <li class="slide-container">
                <div class="slide-image">
                <img src="images/slide-img4.jpg">
                </div>
                <div class="carousel-controls">
                <label for="img-3" class="prev-slide">
                    <span>&lsaquo;</span>
                </label>
                <label for="img-5" class="next-slide">
                    <span>&rsaquo;</span>
                </label>
                </div>
            </li>
            <input type="radio" name="radio-buttons" id="img-5" />
            <li class="slide-container">
                <div class="slide-image">
                <img src="images/slide-img5.jpg">
                </div>
                <div class="carousel-controls">
                <label for="img-4" class="prev-slide">
                    <span>&lsaquo;</span>
                </label>
                <label for="img-1" class="next-slide">
                    <span>&rsaquo;</span>
                </label>
                </div>
            </li>
            <div class="carousel-dots">
                <label for="img-1" class="carousel-dot" id="img-dot-1"></label>
                <label for="img-2" class="carousel-dot" id="img-dot-2"></label>
                <label for="img-3" class="carousel-dot" id="img-dot-3"></label>
                <label for="img-4" class="carousel-dot" id="img-dot-4"></label>
                <label for="img-5" class="carousel-dot" id="img-dot-5"></label>
            </div>
        </ul>
    </div>
    <div id="aboutus" class="section about">

    </div>
    <div id="services" class="section services">

    </div>
    <div id="contact" class="section contact">

    </div>
    <div class="section footer">
        <div class="address">
            <h4>FARM ASSISTANT</h4>
            <span> 5/2 Ülkü Sokak Yenikent – Gönyeli / Lefkoşa</span>
            <span> 99150 North Cyprus</span>    
        </div>
        <div class="footer-links">
            <ul>
                <span>Links</span>
                <li><a href="#home">Home</a></li>
                <li><a href="#aboutus">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact Us</a></li>
            </ul>
        </div>
        <div class="footer-action">
            <span>Register now and get started!</span>
            <a href='register.php'>Register</a>
        </div>
    </div>
</body>
</html>