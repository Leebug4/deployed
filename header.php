<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Learning System</title>
    <link rel="stylesheet" href="mainStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="materialsStyle.css">
</head>
<body>
<div class="header-container">
    <div class="logo-area">
        <img src="Images/LearnITLogo.png" alt="Learn IT Logo">
    </div>
    <nav class="nav-menu">
        <a href="index.php">Home</a>
        <a href="materials.php">Learning Materials</a>
        <a href="quiz.php">Take Quiz</a>
        <a href="profile.php">Profile</a>
        <a href="about.php">About Us</a>   
    </nav>
    <!-- <a href="profile.php" class="profile-link"> -->
    <div class="profile-avatar">
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
    <div class="header-avatar">
        <?php echo $_SESSION['avatar']; ?>
    </div>
    <?php endif; ?>

    </div>

</div>
