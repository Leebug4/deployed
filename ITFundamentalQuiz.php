<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    header("Location: profile.php");
    exit;
}
include "header.php";
?>
<link rel="stylesheet" href="quizFormStyle.css">
<?php
$topicKey = "ITFundamentalQuiz";
$type = $_GET['type'] ?? '';

// question sets
$mcq = [
    ["The brain of the computer is the:", ["RAM","CPU","Hard Drive","GPU"], "b"],
    ["Which device is an example of output hardware?", ["Keyboard","Mouse","Monitor","Microphone"], "c"],
    ["Which operating system is open-source?", ["Windows","macOS","Linux","iOS"], "c"],
    ["Which type of memory is volatile?", ["ROM","RAM","Hard Drive","SSD"], "b"],
    ["The unit of digital data equal to 1024 bytes is called:", ["Bit","Kilobyte","Megabyte","Gigabyte"], "b"]
];

$fill = [
    ["__________ is known as the physical parts of the computer.", "Hardware"],
    ["The main circuit board of the computer is called __________.", "Motherboard"],
    ["__________ software controls the hardware and software resources of a system.", "Operating System"],
    ["The most common type of permanent storage is __________.", "Hard Drive"],
    ["The smallest unit of data in a computer is a __________.", "Bit"]
];

$tf = [
    ["ROM is non-volatile memory.", "true"],
    ["A printer is an input device.", "false"],
    ["Software is tangible, like hardware.", "false"],
    ["The operating system acts as an interface between user and computer hardware.", "true"],
    ["The BIOS initializes hardware during startup.", "true"]
];

$fourpics = [
    [["qzImages/ITFundamentalQuiz/Q11.png","qzImages/ITFundamentalQuiz/Q12.png","qzImages/ITFundamentalQuiz/Q13.png","qzImages/ITFundamentalQuiz/Q14.png"], "HARDWARE"],
    [["qzImages/ITFundamentalQuiz/Q21.png","qzImages/ITFundamentalQuiz/Q22.png","qzImages/ITFundamentalQuiz/Q23.png","qzImages/ITFundamentalQuiz/Q24.png"], "SOFTWARE"],
    [["qzImages/ITFundamentalQuiz/Q31.png","qzImages/ITFundamentalQuiz/Q32.png","qzImages/ITFundamentalQuiz/Q33.png","qzImages/ITFundamentalQuiz/Q34.png"], "NETWORK"],
    [["qzImages/ITFundamentalQuiz/Q41.png","qzImages/ITFundamentalQuiz/Q42.png","qzImages/ITFundamentalQuiz/Q43.png","qzImages/ITFundamentalQuiz/Q44.png"], "CPU"],
    [["qzImages/ITFundamentalQuiz/Q51.png","qzImages/ITFundamentalQuiz/Q52.png","qzImages/ITFundamentalQuiz/Q53.png","qzImages/ITFundamentalQuiz/Q54.png"], "DEVICES"]
];      

// header and navigation
echo "<h1>IT Fundamentals Quiz</h1>";

// if no type chosen, show type chooser
if (!$type) {
    echo "<h3>Select Quiz Type:</h3>";
    echo "<p><a href='ITFundamentalQuiz.php?type=mcq'><button>Multiple Choice</button></a> ";
    echo "<a href='ITFundamentalQuiz.php?type=fill'><button>Fill in the Blank</button></a> ";
    echo "<a href='ITFundamentalQuiz.php?type=truefalse'><button>True or False</button></a> ";
    echo "<a href='ITFundamentalQuiz.php?type=fourpics'><button>4 Pics 1 Word</button></a></p>";
    include "footer.php";
    exit;
}

// pick question set
if ($type === 'mcq') $questions = $mcq;
elseif ($type === 'fill') $questions = $fill;
elseif ($type === 'truefalse') $questions = $tf;
elseif ($type === 'fourpics') $questions = $fourpics;
else $questions = null;

if (!$questions) {
    echo "<p>Invalid quiz type. <a href='ITFundamentalQuiz.php'>Choose type</a></p>";
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
            echo "<p><a href='ITFundamentalQuiz.php?type=fourpics'><button>Try Again</button></a> ";
            echo "<a href='ITFundamentalQuiz.php'><button>Choose Another Quiz Type</button></a> ";
            echo "<p><a href='quiz.php'><button>Back to Quiz Hub</button></a></p>";

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

        // === XP Calculation ===
        $xp = $score * 100;

        // Save points
        if (!isset($_SESSION['points'])) $_SESSION['points'] = 0;
        $_SESSION['points'] += $xp;

        // Save perfects (🔥)
        if ($score === count($questions)) {
            if (!isset($_SESSION['perfects'])) $_SESSION['perfects'] = 0;
            $_SESSION['perfects']++;
        }

        if (!isset($_SESSION['scores'])) $_SESSION['scores'] = [];
        $_SESSION['scores'][$topicKey] = ["type"=>$type,"score"=>$score,"max"=>count($questions)];
        $_SESSION['score'] = $score;   

        echo "<h2>Results</h2>";
        echo "<p>You scored <b>$score</b> out of <b>" . count($questions) . "</b>. You got <b>$xp XP</b>.</p>";
        echo "<p><a href='WebFundamentalQuiz.php?type=$type'><button>Try Again</button></a> ";
        echo "<a href='WebFundamentalQuiz.php'><button>Choose Another Quiz Type</button></a> ";
        echo "<p><a href='quiz.php'><button>Back to Quiz Hub</button></a></p>";
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
    $letters = ["H Y R A G E W A H R D", "S G OA F F T W U A R K E", "L N H O W D T R K E M B", "U S A I C T P S C", "D S V I C E T P S C E"];
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
?> <link rel="stylesheet" href="quiz.css">
