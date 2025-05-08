<?php


    // require_once 'connection.php';
    use App\User;
    use App\Artist;
    use App\Customer;
class Authcontoller{
    protected $logcon ;

    public function __construct($con){
        $this->logcon = $con;
    }
    static public function setCookies(User $user,$role){
        
        setcookie('userid', $user->getSsn(), time() + (86400 * 30), "/");
        setcookie('emailid', $user->getEmail(), time() + (86400 * 30), "/");
        setcookie('passid', $user->getPass(), time() + (86400 * 30), "/");
        setcookie('roleid', $role, time() + (86400 * 30), "/");
    }

    static public function unSetCookies(){
        setcookie('userid', "", time() - 3600, "/");
        setcookie('emailid', "", time() - 3600, "/");
        setcookie('passid', "", time() - 3600, "/");
        setcookie('roleid', "", time() - 3600, "/");
    }

    
    static public function encodePass($string): string{
        return str_replace(['+','/','='], ['-','_',''], base64_encode($string));
    }
    
    public function login(User $user,$cookie){
        $email = $user->getEmail();
        $user->setPass(Authcontoller::encodepass($user->getPass()));
        $sql = "SELECT * FROM users WHERE Email = '$email'";
        try{
            $result = mysqli_query($this->logcon,$sql);
            if(mysqli_num_rows($result) == 0)
            {
                session_start();
                $_SESSION['emailerror'] = "Email does not exist";
                return false;
            }else{
                $row = mysqli_fetch_assoc($result);
                if($user->getPass() == $row['Password'])
                {
                    
                    $_SESSION["userId"] = $row['UserID'];
                    $user->setSsn($row['UserID']);
                    if($cookie == true)
                        Authcontoller::setCookies($user,$row['Artist']);
                    // add session varibales;
                    if($row['Artist'] == 1){
                        
                        header('Location: Event.php');
                        exit();
                    }else{
                        
                        header('Location: ../index.php');
                        exit();
                    }
                }else{
                    session_start();
                    $_SESSION['passerror'] = "Incorrect  password";
                    return false;
                }
            }
        // mysqli_close($this->logcon);
        }catch(mysqli_sql_exception $ex){
            echo $ex->getMessage();
        }
    }

    
    public function signup(User $user,$cookie,$role){
        $Fname = $user->getFname();
        $Lname = $user->getLname();
        $email = $user->getEmail();
        $password = Authcontoller::encodePass($user->getPass());
        $Phone = $user->getPhone();
        $Address = $user->getAddress();
        $Gender = $user->getGender();
        $city = $user->getCity();
        $sql = "INSERT INTO users(Fname,Lanme,phoneNumber,Email,Geneder,Address,City,Artist,Advisor,Password) VALUES('$Fname','$Lname','$Phone','$email','$Gender','$Address','$city','$role',0,'$password')";
        $sql1 = "SELECT * FROM users WHERE Email = '$email'";
        try {
            $result = mysqli_query($this->logcon, $sql1);
            if(mysqli_num_rows($result) > 0){
                session_start();
                $_SESSION['ufound'] = "User already exists";
            }else{
                mysqli_query($this->logcon, $sql);
                session_start();
                $_SESSION['userId'] = mysqli_fetch_assoc(mysqli_query($this->logcon,"SELECT UserID FROM users WHERE(Email = '$email')"))['UserID'];
                $user->setSsn(mysqli_fetch_assoc(mysqli_query($this->logcon,"SELECT UserID FROM users WHERE(Email = '$email')"))['UserID']);
                if($cookie == true)
                    Authcontoller::setCookies($user,$role);
                if($role == 1){
                    header('Location: Event.php');
                    exit();
                }else{
                    header('Location: ../index.php');
                    exit();
                }
            }
            
    }catch (mysqli_sql_exception $ex) {
            echo $ex->getMessage();
        }
    }

}