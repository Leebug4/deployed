<?php
session_start();
include "header.php";   
$valid_user = "student";
$valid_pass = "12345";

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    if ($_POST['username'] == $valid_user && $_POST['password'] == $valid_pass) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $_POST['username'];

        if (!isset($_SESSION['nickname'])) {
            $_SESSION['nickname'] = "New Student";
        }
        if (!isset($_SESSION['avatar'])) {
            $_SESSION['avatar'] = "😀";
        }

        echo "<p class='login-success'>Login successful!</p>";
    } else {
        echo "<p class='login-fail'>Invalid login.</p>";
    }
}

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $_SESSION['nickname'] = $_POST['nickname'];
    $_SESSION['avatar'] = $_POST['avatar'];
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: profile.php");
    exit;
}

// Save score to scoreboard
if (!isset($_SESSION['scoreboard'])) {
    $_SESSION['scoreboard'] = [];
}
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_SESSION['score'])) {
    $_SESSION['scoreboard'][$_SESSION['username']] = [
        'nickname' => $_SESSION['nickname'],
        'avatar'   => $_SESSION['avatar'],
        'score'    => $_SESSION['score']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile / Login</title>
    <link rel="stylesheet" href="profileStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<main class="profile-container">
<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
    
    <!-- LEFT PROFILE CARD -->
    <aside class="profile-card">
        <div class="avatar-circle"><?php echo $_SESSION['avatar']; ?></div>
        <h2><?php echo $_SESSION['nickname']; ?></h2>
        <p class="username">@<?php echo $_SESSION['username']; ?></p>
<div class="stats">
  <div class="stat-card">
    <i class="fa-solid fa-crown"></i>
    <span>10</span>
  </div>
  <div class="stat-card">
    <i class="fa-solid fa-fire"></i>
    <span>26</span>
  </div>
  <div class="stat-card">
    <i class="fa-solid fa-star"></i>
    <span>15</span>
  </div>
</div>
    </aside>

    <!-- RIGHT DASHBOARD -->
    <section class="dashboard">
        <h1>Welcome to Learn IT!</h1>

        <!-- Profile Update -->
        <div class="card">
            <h3>Edit Profile</h3>
            <form method="post">
                <label>Nickname:</label>
                <input type="text" name="nickname" value="<?php echo $_SESSION['nickname']; ?>">
                <label>Avatar:</label>
                <select name="avatar">
                    <option value="😀" <?php if ($_SESSION['avatar']=="😀") echo "selected"; ?>>😀</option>
                    <option value="😎" <?php if ($_SESSION['avatar']=="😎") echo "selected"; ?>>😎</option>
                    <option value="🐱" <?php if ($_SESSION['avatar']=="🐱") echo "selected"; ?>>🐱</option>
                    <option value="🐶" <?php if ($_SESSION['avatar']=="🐶") echo "selected"; ?>>🐶</option>
                    <option value="🐵" <?php if ($_SESSION['avatar']=="🐵") echo "selected"; ?>>🐵</option>
                </select>
                <input type="submit" name="update_profile" value="Update Profile">
            </form>
        </div>

        <!-- Scoreboard -->
        <div class="card">
            <h3>Scoreboard</h3>
            <?php if (!empty($_SESSION['scoreboard'])): ?>
                <table>
                    <tr><th>Nickname</th><th>Avatar</th><th>Score</th></tr>
                    <?php foreach ($_SESSION['scoreboard'] as $player): ?>
                        <tr>
                            <td><?php echo $player['nickname']; ?></td>
                            <td><?php echo $player['avatar']; ?></td>
                            <td><?php echo $player['score']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No scores yet.</p>
            <?php endif; ?>
        </div>

        <!-- Logout -->
        <form method="post">
            <input type="submit" name="logout" value="Logout" class="logout-btn">
        </form>
    </section>

<?php else: ?>
    <!-- LOGIN FORM -->
    <section class="login-box">
        <h2>Login</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" name="login" value="Login">
        </form>
    </section>
<?php endif; ?>
</main>
<?php include "footer.php"; ?>
</body>
</html>
