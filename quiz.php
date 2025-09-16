<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    header("Location: profile.php");
    exit;
}
include "header.php";
?>

<h2>Take the Quiz and boost your wisdom</h2>

<form action="start_quiz.php" method="POST">

    <!-- Step 1: Choose Topic -->
    <h3>Select a Topic</h3>
    <label><input type="radio" name="topic" value="web" required> Web Development</label><br>
    <label><input type="radio" name="topic" value="it"> IT Fundamentals</label><br>
    <label><input type="radio" name="topic" value="programming"> Programming Fundamentals</label><br>
    <label><input type="radio" name="topic" value="ai"> Artificial Intelligence</label><br><br>

    <!-- Step 2: Choose Quiz Type -->
    <h3>Select Quiz Type</h3>
    <label><input type="radio" name="quiztype" value="mcq" required> Multiple Choice</label><br>
    <label><input type="radio" name="quiztype" value="fill"> Fill in the Blank</label><br>
    <label><input type="radio" name="quiztype" value="truefalse"> True/False</label><br>
    <label><input type="radio" name="quiztype" value="fourpics"> Four Pictures One Word</label><br><br>

    <!-- Submit button -->
    <button type="submit">Take the Quiz!</button>
</form>

<?php include "footer.php"; ?>
