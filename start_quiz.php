    <?php
    session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
        header("Location: profile.php");
        exit;
    }

    $topic = $_POST['topic'] ?? '';
    $quiztype = $_POST['quiztype'] ?? '';

    if ($topic && $quiztype) {
        switch ($topic) {
            case 'web':
                header("Location:WebFundamentalQuiz.php?type=$quiztype");
                exit;
            case 'it':
                header("Location:ITFundamentalQuiz.php?type=$quiztype");
                exit;
            case 'programming':
                header("Location: ProgrammingFundamentalQuiz.php?type=$quiztype");
                exit;
            case 'ai':
                header("Location:ArtificialIntelligenceQuiz.php?type=$quiztype");
                exit;
            default:
                echo "Invalid topic selected.";
        }
    } else {
        echo "Please choose a topic and quiz type.";
    }
    ?>
