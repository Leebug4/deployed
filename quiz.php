<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    header("Location: profile.php");
    exit;
}
include "header.php";
?>
<link rel="stylesheet" href="styleQuiz.css">

<form action="start_quiz.php" method="POST" class="quiz-form">
  <div class="quiz-container">
    <!-- Left Column -->
    <div class="left-column">
      <div class="sub-heading">Take the Quiz and boost your wisdom</div>
      <h1 class="main-heading">YOUR PERSONALIZED<br>ONLINE LEARNING HUB</h1>
      <p class="cta">Tap on the topic that tickles your fancy and choose your quiz adventure!</p>

      <div class="topics">
        <label class="topic"><input type="radio" name="topic" value="web" required><span>Web Development</span></label>
        <label class="topic"><input type="radio" name="topic" value="it"><span>IT Fundamentals</span></label>
        <label class="topic"><input type="radio" name="topic" value="programming"><span>Programming Fundamentals</span></label>
        <label class="topic"><input type="radio" name="topic" value="ai"><span>Artificial Intelligence</span></label>
      </div>
    </div>

    <!-- Right Column -->
    <div class="right-column">
      <div class="quiz-types">
        <label class="quiz-card quiz-mcq">
          <input type="radio" name="quiztype" value="mcq" required>
          <div class="card-overlay"></div>
          <div class="card-label">Multiple Choice</div>
        </label>

        <label class="quiz-card quiz-fill">
          <input type="radio" name="quiztype" value="fill">
          <div class="card-overlay"></div>
          <div class="card-label">Fill in the Blank</div>
        </label>

        <label class="quiz-card quiz-truefalse">
          <input type="radio" name="quiztype" value="truefalse">
          <div class="card-overlay"></div>
          <div class="card-label">True or False</div>
        </label>

        <label class="quiz-card quiz-fourpics">
          <input type="radio" name="quiztype" value="fourpics">
          <div class="card-overlay"></div>
          <div class="card-label">Four Pictures One Word</div>
        </label>
      </div>

      <button type="submit" class="submit-btn">Take the Quiz <span class="arrow">→</span></button>
    </div>
  </div>
</form>

<?php include "footer.php"; ?>