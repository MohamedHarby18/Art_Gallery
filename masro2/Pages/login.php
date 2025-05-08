<?php
require_once("../App/connection.php");
require_once("../App/Authcontoller.php");
require_once("../App/User.php");
require_once("../App/Customer.php");
require_once("../App/Artist.php");

use App\User;
use App\Customer;

session_start();

// Check if user is already logged in via cookies
if(isset($_COOKIE['emailid']) && isset($_COOKIE['passid'])) {
    if($_COOKIE['roleid'] == 0) {
        header('Location: ../index.php');
        exit();
    } else {
        header('Location: cart.php');
        exit();
    }
}

if(isset($_POST['Login'])) {
    $auth = new Authcontoller($con);
    $user = new Customer();

    $email = trim($_POST['Email'] ?? '');
    $password = trim($_POST['Password'] ?? '');
    $remember = isset($_POST['Remember']) ? filter_var($_POST['Remember'], FILTER_VALIDATE_BOOLEAN) : false;

    // Validate inputs
    $errors = [];
    
    if(empty($email) && empty($password)) {
        $_SESSION['error'] = "Please fill in all fields";
        header('Location: login.php');
        exit();
    }

    if(empty($email)) {
        $_SESSION['emailerror'] = "Please fill in email field";
        header('Location: login.php');
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['emailerror'] = "Invalid email format";
        header('Location: login.php');
        exit();
    }

    if(empty($password)) {
        $_SESSION['passerror'] = "Please fill in password field";
        header('Location: login.php');
        exit();
    }

    $user->setEmail($email);
    $user->setPass($password);

    try {
        if($auth->login($user, $remember)) {
            header('Location: ../index.php');
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password";
            header('Location: login.php');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred during login";
        header('Location: login.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once("../Partials/head.php"); ?>
<body class="bg-gray-200 flex justify-center items-center min-h-screen">
    <form class="w-full max-w-lg bg-white p-10 rounded-md shadow-md" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-email">
                    Email
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-email" type="email" placeholder="am@gmail.com" name="Email" value="<?php echo htmlspecialchars($_POST['Email'] ?? ''); ?>">
                <p class="text-red-500 text-xs italic">
                    <?php 
                        if(isset($_SESSION['emailerror'])) {
                            echo $_SESSION['emailerror'];
                            unset($_SESSION['emailerror']);
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                    Password
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="password" placeholder="********" name="Password">
                <p class="text-red-500 text-xs italic">
                    <?php 
                        if(isset($_SESSION['passerror'])) {
                            echo $_SESSION['passerror'];
                            unset($_SESSION['passerror']);
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <input type="checkbox" name="Remember" class="mr-2 w-4 h-4" value="true" <?php echo isset($_POST['Remember']) ? 'checked' : ''; ?>>
                <label for="remember me">Remember me</label>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <input type="submit" name="Login" value="Login" class="w-full rounded-full bg-teal-500 hover:bg-teal-600 text-white py-2.5 px-5 cursor-pointer transition duration-200">
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-3">
            <div class="w-full px-3">
                <span>Don't have an account? </span>
                <a href="signup.php" class="underline text-sky-400 hover:text-sky-600">Register</a>
            </div>
        </div>
        <?php if(isset($_SESSION['error'])): ?>
            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                <p class="font-bold">Error</p>
                <p><?php 
                    echo $_SESSION['error'];  
                    unset($_SESSION['error']);
                ?></p>
            </div>
        <?php endif; ?>
    </form>
</body>
</html>