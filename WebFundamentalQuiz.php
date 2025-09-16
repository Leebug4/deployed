<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    header("Location: profile.php");
    exit;
}
include "header.php";

$topicKey = "Web FundamentalQuiz";
$type = $_GET['type'] ?? '';

// question sets
$mcq = [
    ["Which tag is used to create a hyperlink in HTML?", ["<img>","<a>","<link>","<p>"], "b"],
    ["Which CSS property controls text size?", ["font-style","font-size","text-weight","size"], "b"],
    ["The default method for submitting form data is:", ["GET","POST","PUT","PATCH"], "a"],
    ["Which part of a website ensures it adapts to different devices?", ["SEO","Responsiveness","Hyperlinks","Metadata"], "b"],
    ["JavaScript is mainly used for:", ["Structuring content","Styling content","Adding interactivity","Storing data on the server"], "c"]
];

$fill = [
    ["The __________ tag is used to insert images in an HTML page.", "<img>"],
    ["CSS stands for __________ Style Sheets.", "Cascading"],
    ["The HTML5 semantic tag for navigation is __________.", "<nav>"],
    ["The default file name for a website’s home page is usually __________.", "index.html"],
    ["JavaScript code is placed inside __________ tags.", "<script>"]
];

$tf = [
    ["HTML is a programming language.", "false"],
    ["CSS can be used to create animations.", "true"],
    ["<head> contains visible elements of a webpage.", "false"],
    ["Inline CSS has higher priority than external CSS.", "true"],
    ["JavaScript can change HTML content dynamically.", "true"]
];

// 4 Pics 1 Word (images should be inside /images/ folder)
$fourpics = [
    [["qzImages/WebFundamentalQuiz/WebQ11.png","qzImages/WebFundamentalQuiz/WebQ12.png","qzImages/WebFundamentalQuiz/WebQ13.png","qzImages/WebFundamentalQuiz/WebQ14.png"], "WEB"],
    [["qzImages/WebFundamentalQuiz/WebQ21.png","qzImages/WebFundamentalQuiz/WebQ22.png","qzImages/WebFundamentalQuiz/WebQ23.png","qzImages/WebFundamentalQuiz/WebQ24.png"], "lINK"],
    [["qzImages/WebFundamentalQuiz/WebQ31.png","qzImages/WebFundamentalQuiz/WebQ32.png","qzImages/WebFundamentalQuiz/WebQ33.png","qzImages/WebFundamentalQuiz/WebQ34.png"], "HTML"],
    [["qzImages/WebFundamentalQuiz/WebQ41.png","qzImages/WebFundamentalQuiz/WebQ42.png","qzImages/WebFundamentalQuiz/WebQ43.png","qzImages/WebFundamentalQuiz/WebQ44.png"], "CSS"],
    [["qzImages/WebFundamentalQuiz/WebQ51.png","qzImages/WebFundamentalQuiz/WebQ52.png","qzImages/WebFundamentalQuiz/WebQ53.png","qzImages/WebFundamentalQuiz/WebQ54.png"], "JAVASCRIPT"],
];

// header and nav
echo "<h1>Web Fundamentals Quiz</h1>";
echo "<p><a href='quiz.php'><button>Back to Quiz Hub</button></a></p>";

if (!$type) {
    echo "<h3>Select Quiz Type:</h3>";
    echo "<p><a href='WebFundamentalQuiz.php?type=mcq'><button>Multiple Choice</button></a> ";
    echo "<a href='WebFundamentalQuiz.php?type=fill'><button>Fill in the Blank</button></a> ";
    echo "<a href='WebFundamentalQuiz.php?type=truefalse'><button>True or False</button></a> ";
    echo "<a href='WebFundamentalQuiz.php?type=fourpics'><button>4 Pics 1 Word</button></a></p>";
    include "footer.php";
    exit;
}

if ($type === 'mcq') $questions = $mcq;
elseif ($type === 'fill') $questions = $fill;
elseif ($type === 'truefalse') $questions = $tf;
elseif ($type === 'fourpics') $questions = $fourpics;
else $questions = null;

if (!$questions) {
    echo "<p>Invalid quiz type. <a href='WebFundamentalQuiz.php'>Choose type</a></p>";
    include "footer.php";
    exit;
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($type === 'fourpics') {
        // Initialize if not set
        if (!isset($_SESSION['fp_index'])) $_SESSION['fp_index'] = 0;
        if (!isset($_SESSION['fp_score'])) $_SESSION['fp_score'] = 0;

        $currentIndex = $_SESSION['fp_index'];
        $user = strtolower(trim($_POST['answer']));
        $correct = strtolower($fourpics[$currentIndex][1]);

        if ($user === $correct) $_SESSION['fp_score']++;    
        $_SESSION['fp_index']++;

        // Done all questions
        if ($_SESSION['fp_index'] >= count($fourpics)) {
            echo "<h2>Results</h2>";
            echo "<p>You scored <b>{$_SESSION['fp_score']}</b> out of <b>" . count($fourpics) . "</b>.</p>";
            echo "<p><a href='WebFundamentalQuiz.php?type=fourpics'><button>Try Again</button></a> ";
            echo "<a href='WebFundamentalQuiz.php'><button>Choose Another Quiz Type</button></a> ";
            echo "<a href='quiz.php'><button>Back to Hub</button></a></p>";

            unset($_SESSION['fp_index']);
            unset($_SESSION['fp_score']);
            include "footer.php";
            exit;
        }

        header("Location: " . $_SERVER['PHP_SELF'] . "?type=fourpics");
        exit;
    }
    else {
        // Normal MCQ / Fill / TrueFalse scoring
        $score = 0;
        foreach ($questions as $i => $q) {
            $user = $_POST["q$i"] ?? '';
            if ($type === 'mcq') {
                if (strtolower(trim($user)) === strtolower($q[2])) $score++;
            } elseif ($type === 'truefalse') {
                if (strtolower(trim($user)) === strtolower($q[1])) $score++;
            } else {
                if (strtolower(trim($user)) === strtolower($q[1])) $score++;
            }
        }

        if (!isset($_SESSION['scores'])) $_SESSION['scores'] = [];
        $_SESSION['scores'][$topicKey] = ["type"=>$type,"score"=>$score,"max"=>count($questions)];
        $_SESSION['score'] = $score;   

        echo "<h2>Results</h2>";
        echo "<p>You scored <b>$score</b> out of <b>" . count($questions) . "</b>.</p>";
        echo "<p><a href='WebFundamentalQuiz.php?type=$type'><button>Try Again</button></a> ";
        echo "<a href='WebFundamentalQuiz.php'><button>Choose Another Quiz Type</button></a> ";
        echo "<a href='quiz.php'><button>Back to Hub</button></a></p>";
        include "footer.php";
        exit;
    }
}

// Form display
echo "<h2>" . ($type === 'mcq' ? "Multiple Choice" : ($type === 'fill' ? "Fill in the Blank" : ($type === 'truefalse' ? "True or False" : "4 Pics 1 Word"))) . "</h2>";
echo "<form method='post'>";

if ($type === 'mcq') {
    foreach ($questions as $i => $q) {
        echo "<p>" . ($i+1) . ". " . htmlspecialchars($q[0]) . "</p>";
        $letters = ['a','b','c','d'];
        foreach ($q[1] as $j => $opt) {
            $val = $letters[$j];
            echo "<label><input type='radio' name='q$i' value='$val' required> " . strtoupper($val) . ") " . htmlspecialchars($opt) . "</label><br>";
        }
    }
} elseif ($type === 'truefalse') {
    foreach ($questions as $i => $q) {
        echo "<p>" . ($i+1) . ". " . htmlspecialchars($q[0]) . "</p>";
        echo "<label><input type='radio' name='q$i' value='true' required> True</label> ";
        echo "<label><input type='radio' name='q$i' value='false'> False</label><br>";
    }
} elseif ($type === 'fourpics') {
    if (!isset($_SESSION['fp_index'])) $_SESSION['fp_index'] = 0;
    if (!isset($_SESSION['fp_score'])) $_SESSION['fp_score'] = 0;
    $_SESSION['score'] = $_SESSION['fp_score']; 
    $currentIndex = $_SESSION['fp_index'];
    $q = $fourpics[$currentIndex];

    echo "<p>Question " . ($currentIndex+1) . " of " . count($fourpics) . "</p>";

    // Show 4 images
    foreach ($q[0] as $img) {
        echo "<img src='$img' style='width:120px; height:120px; margin:5px;'>";
    }

    // Hardcoded random letters
    $letters = ["W A E B A P T", "L O I O P I T K   S", "L H O D T E M B", "S A I C T S C", "Z J J A H V A A S O C T R I P P T Z"];
    echo "<p style='font-size:20px; font-weight:bold; letter-spacing:8px;'>" . $letters[$currentIndex] . "</p>";

    // Answer box
    echo "<p><input type='text' name='answer' required style='font-size:18px;'></p>";
} else {
    foreach ($questions as $i => $q) {
        echo "<p>" . ($i+1) . ". " . htmlspecialchars($q[0]) . "</p>";
        echo "<input type='text' name='q$i' required><br>";
    }
}

echo "<br><input type='submit' value='Submit Answers'>";
echo "</form>";

include "footer.php";
?>
