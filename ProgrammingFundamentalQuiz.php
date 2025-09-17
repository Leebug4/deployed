<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    header("Location: profile.php");
    exit;
}
include "header.php";
?>
<link rel="stylesheet" href="quiz.css">
<?php
$topicKey = "ProgrammingFundamentalQuiz";
$type = $_GET['type'] ?? '';

// question sets
$mcq = [
    ["Which symbol is used for single-line comments in Python?", ["//","#","<!-- -->","/* */"], "b"],
    ["A variable is used to:", ["Execute code","Store data values","Print text","Control loops"], "b"],
    ["Which loop runs at least once?", ["For loop","While loop","Do-while loop","Nested loop"], "c"],
    ["Which of the following is a relational operator?", ["+","==","&&","%"], "b"],
    ["In programming, 'syntax' refers to:", ["Logic of a program","Rules of writing code","Runtime errors","Data storage"], "b"]
];

$fill = [
    ["In Python, the keyword used to define a function is __________.", "def"],
    ["A __________ is a named location in memory that stores data.", "variable"],
    ["The process of repeating a set of instructions is called __________.", "looping"],
    ["The __________ statement is used to make decisions in programming.", "if"],
    ["A __________ error happens when code rules are broken.", "syntax"]
];

$tf = [
    ["A variable name can start with a number.", "false"],
    ["An array can store multiple values under one variable.", "true"],
    ["Infinite loops can cause a program to crash.", "true"],
    ["In most languages, indentation does not matter at all.", "false"],
    ["Functions help in code reusability.", "true"]
];

// 4 Pics 1 Word (images should be inside /images/ folder)
$fourpics = [
    [["qzImages/ProgrammingFundamentalQuiz/Q11.png","qZImages/ProgrammingFundamentalQuiz/Q12.png","qzImages/ProgrammingFundamentalQuiz/Q13.png","qzImages/ProgrammingFundamentalQuiz/Q14.png"], "CODE"],
    [["qzImages/ProgrammingFundamentalQuiz/Q21.png","qzImages/ProgrammingFundamentalQuiz/Q22.png","qzImages/ProgrammingFundamentalQuiz/Q23.png","qzImages/ProgrammingFundamentalQuiz/Q24.png"], "VARIABLE"],
    [["qzImages/ProgrammingFundamentalQuiz/Q31.png","qzImages/ProgrammingFundamentalQuiz/Q32.png","qzImages/ProgrammingFundamentalQuiz/Q33.png","qzImages/ProgrammingFundamentalQuiz/Q34.png"], "LOOP"],
    [["qzImages/ProgrammingFundamentalQuiz/Q41.png","qzImages/ProgrammingFundamentalQuiz/Q42.png","qzImages/ProgrammingFundamentalQuiz/Q43.png","qzImages/ProgrammingFundamentalQuiz/Q44.png"], "DEBUG"],
    [["qzImages/ProgrammingFundamentalQuiz/Q51.png","qzImages/ProgrammingFundamentalQuiz/Q52.png","qzImages/ProgrammingFundamentalQuiz/Q53.png","qzImages/ProgrammingFundamentalQuiz/Q54.png"], "COMPILE"],
];

// header and nav
echo "<h1>Programming Fundamentals Quiz</h1>";
echo "<p><a href='quiz.php'><button>Back to Quiz Hub</button></a></p>";

if (!$type) {
    echo "<h3>Select Quiz Type:</h3>";
    echo "<p><a href='ProgrammingFundamentalQuiz.php?type=mcq'><button>Multiple Choice</button></a> ";
    echo "<a href='ProgrammingFundamentalQuiz.php?type=fill'><button>Fill in the Blank</button></a> ";
    echo "<a href='ProgrammingFundamentalQuiz.php?type=truefalse'><button>True or False</button></a> ";
    echo "<a href='ProgrammingFundamentalQuiz.php?type=fourpics'><button>4 Pics 1 Word</button></a></p>";
    include "footer.php";
    exit;
}

if ($type === 'mcq') $questions = $mcq;
elseif ($type === 'fill') $questions = $fill;
elseif ($type === 'truefalse') $questions = $tf;
elseif ($type === 'fourpics') $questions = $fourpics;
else $questions = null;

if (!$questions) {
    echo "<p>Invalid quiz type. <a href='ProgrammingFundamentalQuiz.php'>Choose type</a></p>";
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
            echo "<p><a href='ProgrammingFundamentalQuiz.php?type=fourpics'><button>Try Again</button></a> ";
            echo "<a href='ProgrammingFundamentalQuiz.php'><button>Choose Another Quiz Type</button></a> ";
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
        echo "<p><a href='ProgrammingFundamentalQuiz.php?type=$type'><button>Try Again</button></a> ";
        echo "<a href='ProgrammingFundamentalQuiz.php'><button>Choose Another Quiz Type</button></a> ";
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
    $letters = ["C O W R O E B A D P T", "A V I O M L P C R A E K U T B", "H L A O D I N O T E M P", "E A B M G U C D", "E A M R I P S L S C O"];
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