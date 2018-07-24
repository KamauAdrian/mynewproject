<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Index</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/customs.css" />
</head>
<body>
<nav class="nav navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-target="#mynav" data-toggle="collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand">BLOG POST</a>
        </div>
        <div class="collapse navbar-collapse" id="mynav">
            <!--            <ul class="nav navbar-nav">-->
            <!--                <li class="active"><a href="#">Home</a></li>-->
            <!--                <li><a href="#">About Blog</a> </li>-->
            <!--                <li><a href="#">Blog</a> </li>-->
            <!--            </ul>-->
            <form method="post" class="navbar-form navbar-right">
                <div class="form-group">
                    <label for="user_log">Email Address:</label>
                    <input type="text" name="log_name" class="form-control" id="user_log" placeholder="Email Address"/>
                </div>
                <div class="form-group">
                    <label for="user_pass">Password :</label>
                    <input type="password" name="log_pass" class="form-control" id="user_pass" placeholder="password"/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" name="log_in" value="Sign-in"/>
                </div><br />
                <div class="form-group">

                </div><br>
                <div class="form-group">
                    <a href="#">forgot password</a>
                </div>
            </form>
        </div>
    </div>
</nav>


<?php
$user_first_Err=$user_last_Err=$user_phone_Err=$user_email_Err=$user_pass_Err=$user_pass1_Err=$log_in_Err=$user_feedback="";
$user_first=$user_last=$user_phone=$user_email=$gender=$user_pass=$user_pass1=$log_name=$log_pass="";


if (isset($_POST['register'])){
    if (empty($_POST['user_first'])){
        $user_first_Err='Please fill out this field';
    }else{
        $user_first=$_POST['user_first'];
        if (!preg_match("/^[a-zA-z0-9 \s]+$/", $user_first)){
            $user_first_Err='Name can only contain letters or numbers';
        }
    }
    if (empty($_POST['user_last'])){
        $user_last_Err='Please fill out this field';
    }else{
        $user_last=$_POST['user_last'];
        if (!preg_match("/^[a-zA-z0-9 \s]+$/", $user_last)){
            $user_last_Err='Name can only contain letters or numbers';
        }
    }
    if(empty($_POST['user_phone'])){
        $user_phone_Err='Phone number required';
    }
    else{
        $user_phone=$_POST['user_phone'];
        if (!preg_match("/^\d{9,13}?[0-9]$/", $user_phone)){
            $user_phone_Err='Enter a valid phone number';
        }
    }
    if(empty($_POST['user_email'])){
        $user_email_Err='Email required';
    }
    else{
        $user_email=$_POST['user_email'];
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL) == false){
            $user_email_Err='Invalid email address';
        }
    }
    if (isset($_POST['gender'])){
        $gender=$_POST['gender'];
    }
    if(empty($_POST['user_pass'])){
        $user_pass_Err='Please create a password';
    }
    else{
        $user_pass=$_POST['user_pass'];
    }
    if (empty($_POST['user_pass1'])){
        $user_pass1_Err='Please confirm your password';
    }else{
        $user_pass1=$_POST['user_pass1'];
    }
    if ($user_pass == $user_pass1){
        $final_pass=md5($user_pass);
    }else{
        $user_pass1_Err='Password mismatch detected';
        $user_pass='';
        $user_pass1='';
    }
    if (empty($user_first_Err) && empty($user_last_Err) && empty($user_phone_Err) && empty($user_email_Err) && empty($user_pass1_Err)){
        //include the database connection
        include 'dbconn.php';

        //Query to insert the user values to the database
        $query="INSERT INTO members VALUES ('','$user_first','$user_last','$user_phone','$user_email','$gender','$final_pass')";
        //executing the query
        $result=mysqli_query($conn,$query);
        if ($result == true){
            $_SESSION["user"]=$user_email;
            $_SESSION["password"]=$final_pass;



            $user_first='';
            $user_last='';
            $user_phone='';
            $user_email='';
            $user_pass='';
            $user_pass1='';

            $user_feedback=$_SESSION["user_id"];
//            header('location:dashboard.php');
        }else{
            $user_feedback="An error occurred please try again later";
        }

    }
}


if (isset($_POST['log_in'])) {
    if (empty($_POST['log_name'])){
        $log_in_Err="Enter your email address and password to continue";

    }else{
        $log_name=$_POST['log_name'];
    }
    if (empty($user_log_Err) && !empty($_POST['log_pass'])){
        $log_pass=$_POST['log_pass'];
        $ins_pass=md5($log_pass);
        include 'dbconn.php';

        $query="SELECT * FROM members WHERE email='$log_name' && password ='$ins_pass'";
        $new_res=mysqli_query($conn,$query);
        $count=mysqli_num_rows($new_res);
        if ($count==1){
            $row=mysqli_fetch_array($new_res);
            $_SESSION["user"]=$log_name;
            $_SESSION["password"]=$ins_pass;
            $_SESSION["id"]=$row['id'];

            header('location:dashboard.php');
        }else{
            $log_in_Err="invalid user name or password";
        }
    }
}
?>
<p><span class="error"><?php echo $log_in_Err?></span></p>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-5 col-xm-12">
            <h1 class="cent">WELCOME TO BLOG</h1><br />
            <img src="images/im.png">
        </div>
        <div class="col-sm-7 col-xm-12">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                <legend>
                    <h1 class="cent">Register With Us</h1>
                </legend>
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="user_first" class="col-sm-2">First name:</label>
                            <div class="col-sm-10">
                                <input type="text" id="user_first" value="<?php echo htmlspecialchars($user_first);?>" class="test" name="user_first" placeholder="First name"/>
                                <span class="error"><?php echo $user_first_Err;?></span>
                            </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="user_last" class="col-sm-2">Last name:</label>
                            <div class="col-sm-10">
                                <input type="text" id="user_last"  value="<?php echo htmlspecialchars($user_last);?>" class="test" name="user_last" placeholder="Last name"/>
                                <span class="error"><?php echo $user_last_Err;?></span>
                            </div>
                    </div>
                    <div class="form-row">
                        <label for="user_phone" class="col-sm-2">Phone number :</label>
                        <div class="col-sm-10">
                        <input type="text" name="user_phone" id="user_phone"  value="<?php echo htmlspecialchars($user_phone);?>" class="test" placeholder="Phone number"/>
                            <span class="error"><?php echo $user_phone_Err;?></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="user_email" class="col-sm-2">Email address :</label>
                        <div class="col-sm-10">
                        <input type="text" name="user_email" id="user_email"   value="<?php echo htmlspecialchars($user_email);?>" class="test" placeholder="Email address"/>
                            <span class="error"><?php echo $user_email_Err;?></span>
                        </div>
                    </div><br /><br />
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2">
                                <legend>Gender</legend>
                            </div>
                            <div class="col-sm-10">
                                <input type="radio" name="gender" value="Male"/> Male<br />
                                <input type="radio" name="gender" value="Female"/> Female
                            </div>
                        </div>
                    </div><br />
                    <div class="form-group">
                        <label for="user_pass" class="col-sm-2">Create new password :</label>
                            <div class="col-sm-10">
                                <input type="password" name="user_pass"   value="<?php echo htmlspecialchars($user_pass);?>" class="test" id="user_pass" placeholder="New password"/>
                                <span class="error"><?php echo $user_pass_Err;?></span>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="user_pass1" class="col-sm-2">Confirm new password :</label>
                            <div class="col-sm-10">
                                <input type="password" name="user_pass1"  value="<?php echo htmlspecialchars($user_pass1);?>" class="test" id="user_pass1" placeholder="Confirm new password"/>
                                <span class="error"><?php echo $user_pass1_Err;?></span>
                            </div>
                        <br />
                        <div class="form-group">
                            <input type="submit" name="register" value="Sign up" class="btn btn-success"/>
                        <span class="success"><?php echo $user_feedback;?></span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
</body>
</html>
