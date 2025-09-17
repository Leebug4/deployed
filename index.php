<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include "header.php";
?>

<main>
    <div class="main-banner">
        <div class="banner-text">
            <h1>LET'S GROW YOUR IT KNOWLEDGE WITH LEARN IT.</h1>
            <p>Learn anytime anywhere at ease</p>
            <div class="search-box">
                <span class="search-icon"><i class="fas fa-search"></i></span>
                <form method="get" action="materials.php" style="display: flex; flex: 1;">
                    <input type="text" name="search" placeholder="Search here">
                </form>
            </div>
        </div>
        <img src="Images/Dashboard Element (Girl with Laptop).png" alt="Banner" class="banner-img">
    </div>
</main>

<?php include "footer.php"; ?>