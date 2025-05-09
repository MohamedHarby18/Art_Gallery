<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/../Controller/controlDBauth.php";
    
    $sql = sprintf("SELECT * FROM users WHERE Email = '%s'",
        $mysqli->real_escape_string($_POST["Email"])
    );
    
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    
    if ($user) {
        if (password_verify($_POST["Password"], $user["Password"])) {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["UserID"];
            
            // Use HTML meta refresh instead of header() to avoid "headers already sent" error
            echo '<!DOCTYPE html>
                <html>
                <head>
                    <meta http-equiv="refresh" content="3;url=index.php">
                </head>
                <body>
                    ✅ Login successful! Redirecting to homepage in 3 seconds...
                </body>
                </html>';
            exit;
        }
    }
    
    $is_invalid = true; // Only set to true if login fails
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Login</h1>
    
    <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && $is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    
    <form method="post">
        <label for="Email">Email</label>
        <input type="email" name="Email" id="Email" 
               value="<?= htmlspecialchars($_POST["Email"] ?? "") ?>">
        
        <label for="Password">Password</label>
        <input type="password" name="Password" id="Password">
        
        <button>Log in</button>
    </form>
</body>
</html>