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
$topicKey = "ArtificialIntelligenceQuiz";
$type = $_GET['type'] ?? '';

// question sets
$mcq = [
    ["Which is considered the father of AI?", ["Alan Turing","John McCarthy","Bill Gates","Elon Musk"], "b"],
    ["Which of the following is an example of Narrow AI?", ["Human brain","Self-driving car","Superintelligence","General AI"], "b"],
    ["Which algorithm is commonly used for training AI models?", ["Bubble Sort","Backpropagation","Linear Search","Binary Search"], "b"],
    ["Which AI field deals with teaching machines to improve from data?", ["Robotics","Expert Systems","Machine Learning","Natural Language Processing"], "c"],
    ["Siri and Alexa are examples of:", ["Strong AI","Weak AI","General AI","Super AI"], "b"]
];

$fill = [
    ["__________ is the ability of a machine to mimic human intelligence.", "Artificial Intelligence"],
    ["The Turing Test was proposed by __________.", "Alan Turing"],
    ["In AI, __________ learning uses labeled data.", "Supervised"],
    ["The area of AI that deals with understanding human speech is called __________.", "Natural Language Processing"],
    ["__________ is the process where AI improves performance with experience.", "Learning"]
];

$tf = [
    ["Machine Learning is a subset of Artificial Intelligence.", "true"],
    ["AI can only be used in gaming.", "false"],
    ["Natural Language Processing helps machines understand human language.", "true"],
    ["AI can make decisions without any data.", "false"],
    ["Expert Systems are AI programs that simulate human experts.", "true"]
];

// 4 Pics 1 Word (images should be inside /images/ folder)
$fourpics = [
    [["qzImages/ArtificialIntelligenceQuiz/Q11.png","qzImages/ArtificialIntelligenceQuiz/Q12.png","qzImages/ArtificialIntelligenceQuiz/Q13.png","qzImages/ArtificialIntelligenceQuiz/Q14.png"], "ROBOT"],
    [["qzImages/ArtificialIntelligenceQuiz/Q21.png","qzImages/ArtificialIntelligenceQuiz/Q22.png","qzImages/ArtificialIntelligenceQuiz/Q23.png","qzImages/ArtificialIntelligenceQuiz/Q24.png"], "AUTOMATIC"],
    [["qzImages/ArtificialIntelligenceQuiz/Q31.png","qzImages/ArtificialIntelligenceQuiz/Q32.png","qzImages/ArtificialIntelligenceQuiz/Q33.png","qzImages/ArtificialIntelligenceQuiz/Q34.png"], "MACHINE"],
    [["qzImages/ArtificialIntelligenceQuiz/Q41.png","qzImages/ArtificialIntelligenceQuiz/Q42.png","qzImages/ArtificialIntelligenceQuiz/Q43.png","qzImages/ArtificialIntelligenceQuiz/Q44.png"], "SMART"],
    [["qzImages/ArtificialIntelligenceQuiz/Q51.png","qzImages/ArtificialIntelligenceQuiz/Q52.png","qzImages/ArtificialIntelligenceQuiz/Q53.png","qzImages/ArtificialIntelligenceQuiz/Q54.png"], "SENSORS"],
];


// header and nav
echo "<h1>Artificial Intelligence Quiz</h1>";
echo "<p><a href='quiz.php'><button>Back to Quiz Hub</button></a></p>";

if (!$type) {
    echo "<h3>Select Quiz Type:</h3>";
    echo "<p><a href='ArtificialIntelligenceQuiz.php?type=mcq'><button>Multiple Choice</button></a> ";
    echo "<a href='ArtificialIntelligenceQuiz.php?type=fill'><button>Fill in the Blank</button></a> ";
    echo "<a href='ArtificialIntelligenceQuiz.php?type=truefalse'><button>True or False</button></a> ";
    echo "<a href='ArtificialIntelligenceQuiz.php?type=fourpics'><button>4 Pics 1 Word</button></a></p>";
    include "footer.php";
    exit;
}

if ($type === 'mcq') $questions = $mcq;
elseif ($type === 'fill') $questions = $fill;
elseif ($type === 'truefalse') $questions = $tf;
elseif ($type === 'fourpics') $questions = $fourpics;
else $questions = null;

if (!$questions) {
    echo "<p>Invalid quiz type. <a href='ArtificialIntelligenceQuiz.php'>Choose type</a></p>";
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
            echo "<p><a href='ArtificialIntelligenceQuiz.php?type=fourpics'><button>Try Again</button></a> ";
            echo "<a href='ArtificialIntelligenceQuiz.php'><button>Choose Another Quiz Type</button></a> ";
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
    $letters = ["O W R O E B A P T", "A O I O M P C I A T K U T S", "H L A O D I N C T E M B", "S A I M T S C R", "S A N R I E S T S C O"];
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