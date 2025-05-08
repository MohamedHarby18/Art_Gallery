<?php
require_once("../App/connection.php");
require_once("../App/Authcontoller.php");
require_once("../App/User.php");
require_once("../App/Customer.php");
require_once("../App/Artist.php");
    
    use App\User;
    use App\Artist;
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
    


    if(isset($_POST['Signup'])){

      $artist = isset($_POST['Artist'])? 1:0;
      
        $Fname = trim($_POST['Fname']);
        $Lname = trim($_POST['Lname']);
        $email = trim($_POST['Email']);
        $password = trim($_POST['Password']);
        $Phone = trim($_POST['Phone']);
        $Address = trim($_POST['Address']);
        $Gender = $_POST['Gender'];
        $remember = isset($_POST['Remember'])? $_POST['Remember']:"";
        $city = $_POST['City'];
        $auth = new Authcontoller($con);
       

      
      /// Validating inputs 

      if($Fname == "")
      {
        $_SESSION['efname'] = "Please fill in this field";
        header('Location: signup.php');
        exit();
      }
      if($Lname == "")
      {
        $_SESSION['elname'] = "Please fill in this field";
        header('Location: signup.php');
        exit();
      }
      
      if($email == "")
      {
          $_SESSION['emailsignup'] = "Please fill in email field";
          header('Location: signup.php');
          exit();
      }

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['emailsignup'] = "Invalid email format";
        header('Location: signup.php');
        exit();
      }

      if( $password == "")
      {
          $_SESSION['passsign'] = "Please fill in password field";
          header('Location: signup.php');
          exit();
      }
      
      if(strlen($password)< 8){
        $_SESSION['passsign'] = "password must be atleast 8 characters";
          header('Location: signup.php');
          exit();
      }

      if($Phone == "")
      {
        $_SESSION['ephone'] = "Please fill in this field";
        header('Location: signup.php');
        exit();
      }

      if($Address == "")
      {
        $_SESSION['eaddress'] = "Please fill in this field";
        header('Location: signup.php');
        exit();
      }

      if(empty($city)){
        $_SESSION['ecity'] = "Please fill in this field";
        header('Location: signup.php');
        exit();
      }

      /// end validation 
      

      if($artist == 1){
        $Artist = new Artist();
        $Artist->setFname($Fname);
        $Artist->setLname($Lname);
        $Artist->setEmail($email);
        $Artist->setPass($password);
        $Artist->setPhone($Phone);
        $Artist->setAddress($Address);
        $Artist->setCity($city);
        $Artist->setGender($Gender);
        if($auth->signup($Artist,$remember,$artist)){
          header('Location: Event.php');
          exit();
        }
        else{
          header('Location: signup.php');
          exit();
        }
      }else{
        $Customer = new Customer();
        $Customer->setFname($Fname);
        $Customer->setLname($Lname);
        $Customer->setEmail($email);
        $Customer->setPass($password);
        $Customer->setPhone($Phone);
        $Customer->setAddress($Address);
        $Customer->setGender($Gender);
        $Customer->setCity($city);
        if($auth->signup($Customer,$remember,$artist)){
          header('Location: ../index.php');
          exit();
        }
        else{
          header('Location: signup.php');
          exit();
        }
      }

    



      //encode password
      // function base64_encode_Pass($string): string{
      //   return str_replace(['+','/','='], ['-','_',''], base64_encode($string));
      // }
      
      // $password = base64_encode_Pass($password);
      
      // //cehck if user registered alreaady
      // try {
      //   $sql = "SELECT * FROM users WHERE Email = '$email'";
      //   $result = mysqli_query($con, $sql);
      //   if(mysqli_num_rows($result) > 0){
      //     $_SESSION['ufound'] = "User already exists";
      //     header('Location: signup.php');
      //     exit();
      //   }
      // } catch (mysqli_sql_exception $ex) {
      //   echo $ex->getMessage();
      // }






      // //insert into database
      // $sql = "INSERT INTO users(Fname,Lanme,phoneNumber,Email,Geneder,Address,Artist,Advisor,Password) VALUES('$Fname','$Lname','$Phone','$email','$Gender','$Address','$artist',0,'$password')";

      // $Artist;
      // $Customer;
      // try {
      //   mysqli_query($con, $sql);
      //   if($remember == true){
      //     if(!isset($_COOKIE['emailid'])){
      //       setcookie('emailid', $email, time() + (86400 * 30), "/");
      //       setcookie('passid', $password, time() + (86400 * 30), "/");
      //       setcookie('roleid',$artist, time() + (86400 * 30), "/");
      //     }
      //   }
      //   if ($artist == 1 || $artist == '1') {
      //     // $Artist = new Artist($Fname,$Lname,$email,$password,$Phone,$Address,$Gender) ;
      //     header('Location: signup.php');
      //     exit();
      //   }else{
      //     // $Customer = new Customer($Fname,$Lname,$email,$password,$Phone,$Address,$Gender);
      //     header('Location: ../index.php');
      //     exit();
      //   }

      // } catch (mysqli_sql_exception $ex) {
      //     echo $ex->getMessage();
      //     header('Location: signup.php');
      // }finally{
      //   mysqli_close($con);
      // }

      





    }

?>

<?php require_once("../Partials/head.php"); ?>
<!-- <?=  $_SERVER['DOCUMENT_ROOT'] ?> -->
<body bgcolor="#ddddcc" class="">
<!-- <?php 
  //require_once("../Partials/Header.php") ?> 
-->
<div class="flex py-16 justify-center items-center min-h-screen">
<form class="w-full max-w-lg bg-white py-10 rounded-md" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
  <div class="flex flex-wrap -mx-3 mb-4">
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
        First Name
      </label>
      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border  rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Jane" name="Fname">
      <p class="text-red-500 text-xs italic"><?php
        if(isset($_SESSION['efname'])){
          echo $_SESSION['efname'];
          unset($_SESSION['efname']);
        }

      ?></p>
    </div>
    <div class="w-full md:w-1/2 px-3">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
        Last Name
      </label>
      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Doe" name = "Lname">
      <p class="text-red-500 text-xs italic"><?php
        if(isset($_SESSION['elname'])){
          echo $_SESSION['elname'];
          unset($_SESSION['elname']);
        }

      ?></p>
    </div>
  </div>
  <div class="flex flex-wrap -mx-3 mb-4">
    <div class="w-full px-3">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-email">
        Email
      </label>
      <input  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="text" placeholder="am@gmail.com" name="Email">
      <p class="text-red-500 text-xs italic"><?php 
        if(isset($_SESSION['emailsignup'])){
          echo $_SESSION['emailsignup'];
          unset($_SESSION['emailsignup']);
        }
      ?></p>
    
    </div>
  </div>
  <div class="flex flex-wrap -mx-3 mb-4">
    <div class="w-full px-3">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
        Password
      </label>
      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="password" placeholder="********" name = "Password">
      <p class="text-red-500 text-xs italic"><p class="text-red-500 text-xs italic"><?php 
        if(isset($_SESSION['passsign'])){
          echo $_SESSION['passsign'];
          unset($_SESSION['passsign']);
        }
      ?></p></p>
    </div>
  </div>
  <div class="flex flex-wrap -mx-3 mb-4">
    <div class="w-full px-3">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-phone">
        phoneNumber
      </label>
      <input  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-phone" type="text" placeholder="+201111111111" name="Phone">
      <p class="text-red-500 text-xs italic"><?php
        if(isset($_SESSION['ephone'])){
          echo $_SESSION['ephone'];
          unset($_SESSION['ephone']);
        }

      ?></p>
    
    </div>
  </div>
  <div class="flex flex-wrap -mx-3 mb-4">
    <div class="w-full px-3">
     
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-address">
        Address
      </label>
      <input  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-phone" type="text" placeholder="25 mst cairo" name="Address">
      <p class="text-red-500 text-xs italic"><?php
        if(isset($_SESSION['eaddress'])){
          echo $_SESSION['eaddress'];
          unset($_SESSION['eaddress']);
        }
      ?></p>
      
      <div class="relative w-1/3">
        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state" name = "City">
        <option value="Gharbia">Gharbia</option>
    <option value="Alexandria">Alexandria</option>
    <option value="Ismailia">Ismailia</option>
    <option value="Kafr El Sheikh">Kafr El Sheikh</option>
    <option value="Aswan">Aswan</option>
    <option value="Assiut">Assiut</option>
    <option value="Luxor">Luxor</option>
    <option value="New Valley">New Valley</option>
    <option value="North Sinai">North Sinai</option>
    <option value="El Beheira">El Beheira</option>
    <option value="Beni Suef">Beni Suef</option>
    <option value="Port Said">Port Said</option>
    <option value="Red Sea">Red Sea</option>
    <option value="Giza">Giza</option>
    <option value="Dakahlia">Dakahlia</option>
    <option value="South Sinai">South Sinai</option>
    <option value="Damietta">Damietta</option>
    <option value="Sohag">Sohag</option>
    <option value="Suez">Suez</option>
    <option value="Sharqia">Sharqia</option>
    <option value="Gharbia">Gharbia</option>
    <option value="Fayoum">Fayoum</option>
    <option value="Cairo" selected>Cairo</option>
    <option value="Qalyubia">Qalyubia</option>
    <option value="Qena">Qena</option>
    <option value="Matrouh">Matrouh</option>
    <option value="Monufia">Monufia</option>
    <option value="Minya">Minya</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
        <p class="text-red-500 text-xs italic"><?php
        if(isset($_SESSION['ecity'])){
          echo $_SESSION['ecity'];
          unset($_SESSION['ecity']);
        }
      ?></p>
      </div>
    </div>
  </div>
    <div class="flex items-center mb-4">
    <input id="default-radio-1" type="radio" checked value="M" name="Gender" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
    <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 ">Male</label>
    </div>
    <div class="flex items-center mb-4">
    <input id="default-radio-1" type="radio" value="F" name="Gender" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
    <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 ">Female</label>
    </div>
    <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full px-3">
        <input type="checkbox" name="Remember" class="mr-2 w-4 h-4" value="true">
        <label for="remember me">Remember me</label>
    </div>
    </div>
    <div class="flex flex-wrap -mx-3 mb-4">
    <div class="w-full px-3">
        <input type="checkbox" name="Artist" class="mr-2 w-4 h-4" value="1">
        <label for="remember me">Register As Artist</label>
    </div>
    </div>
    <div class="flex flex-wrap -mx-3 mb-4">
    <div class="w-full px-3">
      <input type="submit" name="Signup" value="SignUp" class="w-full rounded-full bg-black text-white py-2.5 px-5 cursor-pointer">
    </div>
    </div>
    <div class="flex flex-wrap -mx-3">
    <div class="w-full px-3">
        <span>Already have an account? </span>
        <a href="login.php" class="underline text-sky-400">Login</a>
    </div>
    </div>
</form>
<?php
      if(isset($_SESSION['ufound'])){
    ?>
      <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 absolute right-5 bottom-10 w-64" role="alert">
        <p class="font-bold">Be Warned</p>
        <p><?php   echo $_SESSION['ufound'];  
                  unset($_SESSION['ufound'])?>
                  <a href="login.php" class="underline text-sky-400">Login</a>
        </p>
      </div>
      <?php  }?>
      <!-- <?php //require_once("../Partials/Footer.php") ?> -->
</div>
</body>
</html>

