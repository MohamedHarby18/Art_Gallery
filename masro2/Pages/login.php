<?php
require_once("../App/connection.php");
require_once("../App/Authcontoller.php");
require_once("../App/User.php");
require_once("../App/Customer.php");
require_once("../App/Artist.php");

// declare (restrict_type=1);

use App\User;
use App\Customer;

session_start();



if(isset($_COOKIE['emailid']) && isset($_COOKIE['passid']))
{
  if($_COOKIE['roleid'] == 0){
  header('Location: ../index.php');
  exit();
  }else{
    header('Location: cart.php');
    exit();
  }
}


if(isset($_POST['Login'])){
  
  $auth = new Authcontoller($con);

  $user = new Customer();


  $email = trim($_POST['Email']);

  $password = trim($_POST['Password']);
  
  $remember = isset($_POST['Remember'])? $_POST['Remember']:false;



  //validate inputs
  
if($email == "" && $password == ""){
    $_SESSION['error'] = "Please fill in all fields";
    header('Location: login.php');
    exit();
}

if( $email == "")
{
    $_SESSION['emailerror'] = "Please fill in email field";
    header('Location: login.php');
    exit();
}


if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION['emailerror'] = "Invalid email format";
    header('Location: login.php');
    exit();
}

if( $password == "")
{
    $_SESSION['passerror'] = "Please fill in password field";
    header('Location: login.php');
    exit();
}

$user->setEmail($email);
$user->setPass($password);

if($auth->login($user,$remember))
{

  header('Location: ../index.php');
  exit();
}else{
  header('Location: login.php');
  exit();
}


// if(strlen($password) < 8){
//   $_SESSION['passerror'] = "password must be atleast 8 characters";
//     header('Location: login.php');
//     exit();
// }
  // end validate


  //decode password
// function base64_decode_pass($string):string {
//   return base64_decode(str_replace(['-','_'], ['+','/'], $string));
// }

// $sql = "SELECT * FROM users WHERE Email = '$email'";

// try{
//   $result = mysqli_query($con, $sql);
//   if(mysqli_num_rows($result) > 0){
//     $row = mysqli_fetch_assoc($result);
//     if ($password == base64_decode_pass($row['Password'])) {
//       if($remember == true){
//         if(!isset($_COOKIE['emailid'])){
//           setcookie('emailid', $email, time() + (86400 * 30), "/");
//           setcookie('passid', $row['Password'], time() + (86400 * 30), "/");
//           setcookie('roleid',$row['Artist'], time() + (86400 * 30), "/");
//         }
//       }
//       if($row['Artist'] == 1){
//         header('Location: ');
//         exit();
//       }else{
//         header('Location: ../index.php');
//       }
//     }else{
//       $_SESSION['passerror'] = "Incorrect  password";
//       header('Location: login.php');
//       exit();
//     }
//   }else{
//     $_SESSION['emailerror'] = "Email does not exist";
//     header('Location: login.php');
//     exit();
  
//   }

// }catch (mysqli_sql_exception $ex) {
//   echo $ex->getMessage();
// }finally{
//   mysqli_close($con);
// }




}


?>
<?php require_once("../Partials/head.php"); ?>
<body bgcolor="#ddddcc" class="flex justify-center items-center min-h-screen">
<form class="w-full max-w-lg bg-white p-10 rounded-md" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full px-3">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-email">
        Email
      </label>
      <input  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="text" placeholder="am@gmail.com" name="Email">
      <p class="text-red-500 text-xs italic"><?php 
        if(isset($_SESSION['emailerror'])){
          echo $_SESSION['emailerror'];
          unset($_SESSION['emailerror']);
        }
      ?></p>
    
    </div>
  </div>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full px-3">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
        Password
      </label>
      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="password" placeholder="********" name = "Password">
      <p class="text-red-500 text-xs italic"><p class="text-red-500 text-xs italic"><?php 
        if(isset($_SESSION['passerror'])){
          echo $_SESSION['passerror'];
          unset($_SESSION['passerror']);
        }
      ?></p></p>
    </div>
  </div>
    <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full px-3">
        <input type="checkbox" name="Remember" class="mr-2 w-4 h-4" value="true">
        <label for="remember me">Remember me</label>
    </div>
    </div>
    <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full px-3">
      <input type="submit" name="Login" value="Login" class="w-full rounded-full bg-teal-500 text-white py-2.5 px-5 cursor-pointer">
    </div>
    </div>
    <div class="flex flex-wrap -mx-3 mb-3">
    <div class="w-full px-3">
        <span>Don't have an anccount? </span>
        <a href="signup.php" class="underline text-sky-400">Register</a>
    </div>
    </div>
    <?php
      if(isset($_SESSION['error'])){

      ?>
      <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
        <p class="font-bold">Be Warned</p>
        <p><?php   echo $_SESSION['error'];  
                  unset($_SESSION['error'])?>
        </p>
      </div>
      <?php  }?>
</form>
</body>
</html>
