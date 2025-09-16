<?php
session_start();
include "header.php";

// Materials (just lessons, no quiz here)
$materials = [
    [
        "title" => "Web Fundamentals",
        "content" => "HTML creates the structure of a webpage, CSS styles it, and JavaScript adds interactivity.",
        "image" => "Images/learningMaterials/WebQ22.png" 
    ],
    [
        "title" => "IT Fundamentals",
        "content" => "IT covers hardware, software, networking, and basic computer troubleshooting.",
        "image" => "Images/learningMaterials/Q13.png" 
    ],
    [
        "title" => "Programming Fundamentals",
        "content" => "Programming teaches variables, control flow, functions, and simple algorithms.",
        "image" => "Images/learningMaterials/Q11.png" 
    ],
    [
        "title" => "Artificial Intelligence",
        "content" => "AI uses data and models to let computers recognize patterns and make decisions.",
        "image" => "Images/learningMaterials/Q12.png" 
    ]
];

?>

<div class="materials-section main-container">
    <h2>Explore our Learning Materials</h2>
    <div class="material-cards-grid">
    
    <?php
    foreach ($materials as $m) {
    ?>
        <div class="material-card">
            <img src="<?php echo $m['image']; ?>" alt="<?php echo $m['title']; ?> Image">
            <div class="card-content">
                <h3><?php echo $m['title']; ?></h3>
                <p><?php echo $m['content']; ?></p>
                <a href="#" class="read-more-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up-right"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                </a>
            </div>
        </div>
    <?php
    }
    ?>

    </div> </div> 
    <div style="text-align:center; margin-top: 40px; margin-bottom: 60px;">
    <a href="quiz.php" class="btn quiz-btn">Let us start the Quiz</a>
</div><?php
include "footer.php";
?>