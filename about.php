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
            <img src="DevsImages/Beloro_AboutUs.png" width="120" height="120" style="border-radius:50%;"><br>
            <b>Sophia Rhyzelle T. Beloro</b><br>
            Project Manager<br>
            <p>Responsible for overseeing the planning and execution of the project. Also contributed to layout design and participated in back-end development using HTML and PHP.</p>
        </td>
        <td align="center">
            <img src="DevsImages/Tala_AboutUs.png" width="120" height="120" style="border-radius:50%;"><br>
            <b>Mark Jayson B. Tala</b><br>
            Lead Back-End Programmer<br>
            <p>Primarily responsible for the development and structuring of the back-end functionalities of the system using HTML and PHP.</p>
        </td>
        <td align="center">
            <img src="DevsImages/Reyes_AboutUs.png" width="120" height="120" style="border-radius:50%;"><br>
            <b>Rom Jerico T. Reyes</b><br>
            Lead Front-End Programmer<br>
            <p>Mainly handled the development of the front-end interface and design elements of the system using CSS.</p>
        </td>
        <td align="center">
            <img src="DevsImages/Cabugawan_AboutUs.png" width="120" height="120" style="border-radius:50%;"><br>
            <b>John Mark C. Cabugawan</b><br>
            Front-End Programmer<br>
            <p>Assisted in developing the front-end components and user interface of the system using CSS.</p>
        </td>             
    </tr>

    <tr>  
        <td align="center">
            <img src="DevsImages/Cruz_AboutUs.png" width="120" height="120" style="border-radius:50%;"><br>
            <b>Bjorn G. Kurk Cruz</b><br>
            Back-End Programmer<br>
            <p>Contributed to the back-end development of the system, working primarily with HTML and PHP.</p>
        </td>     
         <td align="center">
            <img src="DevsImages/Lazaro_AboutUs.png" width="120" height="120" style="border-radius:50%;"><br>
            <b>Daniel Joaquin M. Lazaro</b><br>
             Research Support<br>
            <p>Assisted in researching relevant information for the quiz content integrated into the system.</p>
        </td>
        <td align="center">
            <img src="DevsImages/Lucas_AboutUs.png" width="120" height="120" style="border-radius:50%;"><br>
            <b>Lloyd Vincent Lucas</b><br>
            Document Production Support<br>
            <p>Assisted in producing printed materials used for the system’s presentation and documentation.</p>
        </td>
        <td align="center">
            <img src="DevsImages/Samson_AboutUs.png" width="120" height="120" style="border-radius:50%;"><br>
            <b>AJ DC. Samson</b><br>
            Content Assistant<br>
            <p>Provided support in content preparation by conducting minor research and assisting in uploading images used within the system.</p>
        </td>
        <td align="center">
            <img src="DevsImages/Aceveda_AboutUs.png" width="120" height="120" style="border-radius:50%;"><br>
            <b>Lanz Jireh R. Aceveda</b><br>
            Research Support<br>
            <p>Supported the team by conducting research to gather necessary information for the quiz section of the system.</p>
        </td>  
    </tr>
</table>

<?php
include "footer.php"; // this is where the bug-report text stays
?>