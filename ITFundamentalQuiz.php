<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    header("Location: profile.php");
    exit;
}
include "header.php";

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
    [["qzimages/ITFundamentalQuiz/Q11.png","qzimages/ITFundamentalQuiz/Q12.png","qzimages/ITFundamentalQuiz/Q13.png","qzimages/ITFundamentalQuiz/Q14.png"], "HARDWARE"],
    [["qzimages/ITFundamentalQuiz/Q21.png","qzimages/ITFundamentalQuiz/Q22.png","qzimages/ITFundamentalQuiz/Q23.png","qzimages/ITFundamentalQuiz/Q24.png"], "SOFTWARE"],
    [["qzimages/ITFundamentalQuiz/Q31.png","qzimages/ITFundamentalQuiz/Q32.png","qzimages/ITFundamentalQuiz/Q33.png","qzimages/ITFundamentalQuiz/Q34.png"], "NETWORK"],
    [["qzimages/ITFundamentalQuiz/Q41.png","qzimages/ITFundamentalQuiz/Q42.png","qzimages/ITFundamentalQuiz/Q43.png","qzimages/ITFundamentalQuiz/Q44.png"], "CPU"],
    [["qzimages/ITFundamentalQuiz/Q51.png","qzimages/ITFundamentalQuiz/Q52.png","qzimages/ITFundamentalQuiz/Q53.png","qzimages/ITFundamentalQuiz/Q54.png"], "DEVICES"]
];      

// header and navigation
echo "<h1>IT Fundamentals Quiz</h1>";
echo "<p><a href='quiz.php'><button>Back to Quiz Hub</button></a></p>";

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

        echo "<h2>Results</h2>";
        echo "<p>You scored <b>$score</b> out of <b>" . count($questions) . "</b>.</p>";
        echo "<p><a href='ITFundamentalQuiz.php?type=$type'><button>Try Again</button></a> ";
        echo "<a href='ITFundamentalQuiz.php'><button>Choose Another Quiz Type</button></a> ";
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
?>
