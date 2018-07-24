<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>forgot</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/customs.css" />
</head>
<body>
<label for="email">Email Address</label>
<input type="text" id="email" placeholder="Your email address">
<input type="submit" name="reset" value="send">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
</body>
</html>
<?php
$email="";
$email_Err=$feedback="";
if (isset($_POST['reset'])){
    if (empty($_POST['email'])){
        $email_Err="Email address";
    }else{
        $email=$_POST['email'];
        if (filter_var($email,FILTER_VALIDATE_EMAIL)==false){
            $email_Err="invalid email address";
        }
    }
    if (empty($email_Err)){
        include 'dbconn.php';
        $sql="SELECT * FROM  members WHERE email=$email";
        $result=mysqli_query($conn,$sql);
        if ($result){

            $feedback="We have sent a link to $email use the link to reset your password";
        }
    }

}
?>