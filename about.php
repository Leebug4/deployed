<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include "header.php";
?>
<link rel="stylesheet" href="aboutStyle.css">
<h2>About Us</h2>

<p class="about-text" align="center">
    We are the Learn IT team — a group of students and aspiring programmers. 
    Our mission? To study with dedication while building this website as a fun 
    and engaging way to explore and share the world of programming. This web page project 
    for our preliminary examination is submitted to Mr. Alessandro Solis, 
    our Web System and Technology professor.
</p>

<table align="center" cellpadding="20">
    <tr>
        <td align="center">
            <img src="DevsImages/Beloro, Sophia Rhyzelle.jpg" width="120" height="120" style="border-radius:50%;"><br>
            <b>Sophia Beloro</b><br>
            Project Manager<br>
            <p>I handled the planning, layouting and back-end coding</p>
        </td>
        <td align="center">
            <img src="DevsImages/Tala, Mark Jayson.png" width="120" height="120" style="border-radius:50%;"><br>
            <b>Mark Jayson Tala</b><br>
            Main Programmer<br>
            <p>I handled mostly of the back-end coding</p>
        </td>
        <td align="center">
            <img src="DevsImages/pastor.jpg" width="120" height="120" style="border-radius:50%;"><br>
            <b>Rom Jerico Reyes</b><br>
            CSS Programmer<br>
            <p>I handled mostly of the front-end coding</p>
        </td>
        <td align="center">
            <img src="DevsImages/Cabugawan, john mark .jpg" width="120" height="120" style="border-radius:50%;"><br>
            <b>John Mark Cabugawan</b><br>
            CSS Programmer<br>
            <p>I handled the front-end coding</p>
        </td>             
    </tr>

    <tr>      
         <td align="center">
            <img src="DevsImages/Lazaro, Daniel Joaquin M.png" width="120" height="120" style="border-radius:50%;"><br>
            <b>Lazaro Daniel Joaquin</b><br>
            Reasercher <br>
            <p>I handled the context of our website</p>
        </td>
        <td align="center">
            <img src="DevsImages/Lucas, Lloyd Vincent F..jpeg" width="120" height="120" style="border-radius:50%;"><br>
            <b>Lucas Lloyd Vincent F.</b><br>
            Reasercher <br>
            <p>I handled the context of our website</p>
        </td>
        <td align="center">
            <img src="DevsImages/Samson, AJ DC..png" width="120" height="120" style="border-radius:50%;"><br>
            <b>AJ Samson</b><br>
            Reasercher <br>
            <p>I handled the images of our website</p>
        </td>
        <td align="center">
            <img src="https://via.placeholder.com/120" width="120" height="120" style="border-radius:50%;"><br>
            <b>Lanz Jireh Aceveda </b><br>
            Role/Position<br>
            <p>Short description about member 9.</p>
        </td>
        <td align="center">
            <img src="DevsImages/Cruz, Bjorn Kurk G..jfif" width="120" height="120" style="border-radius:50%;"><br>
            <b>Bjorn Cruz</b><br>
            Programmer<br>
            <p>I handled the back-end coding</p>
        </td>   
    </tr>
</table>

<?php
include "footer.php"; // this is where the bug-report text stays
?>