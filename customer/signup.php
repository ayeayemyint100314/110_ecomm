<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once "../admin/dbconnect.php";
// creating password strength checker function
function isStrongPassword($password)
{
    $digitCount = 0; // isdigit()
    $specCount = 0; //preg_match('/[^a-zA-Z0-9]/', $str) > 0;
    $capitalCount = 0; //ctype_upper

    foreach (str_split($password) as $letter) {
        if (ctype_digit($letter)) // checks whether character is digit or not
        {
            $digitCount++;
        } else if (preg_match('/[^a-zA-Z0-9]/', $letter)) {
            $specCount++;
        } else if (ctype_upper($letter)) {
            $capitalCount++;
        }
    } // end for loop
    if ($digitCount >= 1 && $specCount >= 1 && $capitalCount >= 1) {
        return true;
    } else {
        return false;
    }
}
// checking password 
function isLengthOK($password)
{
    return strlen($password) >= 8; // true on pwd length greater than or equal to 8

}




if (
    $_SERVER['REQUEST_METHOD'] == "POST" &&
    isset($_POST['signUp'])
) {
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $bdate = $_POST['bdate'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $profile = $_FILES['profile'];
    $profilePath = "profiles/" . $profile['name'];

    if ($password != $cpassword) {
        $errMessage = "Password and Confirm Password must be the same!";
    } else {
        if (isLengthOK($password)) {
            if (isStrongPassword($password)) { // desired task and continue coding for saving file and inserting user info
                if (move_uploaded_file($profile['tmp_name'], $profilePath)) { 
                    // userId,	email,	password,profilePath,city,gender,fullname,	bdate	
                   
                    $hashcode = password_hash($password, PASSWORD_BCRYPT);
                    try{
                        $sql = "insert into users values
                            (?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $status = $stmt->execute([null,$email, $hashcode, $profilePath,
                         $city,$gender,$fullname, $bdate   ]);
                         if ($status)
                         {
                                header("Location:signin.php");

                         }





                    }catch(PDOException $e)
                    {
                            echo $e->getMessage();
                    }

                }
            } else {
                $errMessage = "Password is not strong";
            }
        } // end isLengthOK
        else {
            $errMessage = "Password must be at least 8 characters long.";
        }
    }
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!--  navigation -->
            <?php require_once "navi.php" ?>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto py-5">
                <form action="signup.php" class="form" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    required placeholder="abc@gmail.com">
                            </div>
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Fullname</label>
                                <input type="text" class="form-control" name="fullname" id="fullname"
                                    required>
                            </div>
                            <div class="mb-3">
                                <?php 
                                if(isset($errMessage))
                                {
                                echo "<p class='alert alert-danger'> $errMessage</p>";
                                
                                }
                                ?>
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="cpassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="cpassword" id="cpassword"
                                    required>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bdate" class="form-label">Birth Date</label>
                                <input type="date" class="form-control" name="bdate" id="bdate">
                            </div>
                            <p>Choose Gender</p>
                            <div class="form-check mb-1">
                                <input type="radio" class="form-check-input" value="male" name="gender" id="gender">
                                <label for="gender" class="form-check-label" >Male</label>
                            </div>
                            <div class="form-check mb-3">
                                <input type="radio" class="form-check-input" value="female" name="gender" id="gender">
                                <label for="gender" class="form-check-label" >Female</label>
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">Choose City</label>
                                <select name="city" id="city" class="form-select">
                                    <option value="mdy">Mandalay</option>
                                    <option value="ygn">Yangon</option>
                                    <option value="tgi">Taunggyi</option>
                                    <option value="mlm">Mawlamyaing</option>
                                    <option value="stw">Sittway</option>
                                    <option value="mgy">Magway</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="profile" class="form-label">Choose Profile Picture</label>
                                <input type="file" class="form-control" id="profile" name="profile">
                            </div>
                            <button class="btn btn-primary" type="submit" name="signUp">Sign Up</button>

                        </div>

                    </div>




                </form>
            </div>
        </div>








    </div>


</body>

</html>