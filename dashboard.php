<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard</title>
            <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
            <link rel="stylesheet" type="text/css" href="css/customs.css" />
</head>
<body>
<nav class="nav navbar-default">
    <div class="container-fluid">
       <div class="navbar-header">
           <button class="navbar-toggle" data-toggle="mynav" data-target="collapse">
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
           </button>
           <a href="#" class="navbar-brand">BLOG POST</a>
       </div>
        <div class="collapse navbar-collapse" id="mynav">
            <ul class="nav navbar-nav">
               <li><a href="#all">All Posts</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Contact us</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </div>
    </div>
</nav>
<?php
$user=$password=$user_id=$posts="";


if (!isset($_SESSION['user']) && !isset($_SESSION['password'])){

    header('location:index.php');
}else{
    $user=$_SESSION['user'];
    $password=$_SESSION['password'];
    $user_id=$_SESSION['id'];
    include 'dbconn.php';
    $sql="SELECT * FROM posts WHERE user_id=$user_id";
   // die($sql);
    $result=mysqli_query($conn,$sql);

        $count=mysqli_num_rows($result);
//        $posts=$count;

    while($row=mysqli_fetch_assoc($result)){
       $posts = $posts."<div class='one'> Title: ".$row['title']." Post: ".$row['post']."</div>";
    }


}
if (isset($_POST['post'])){
    header('location:posts.php');
}


?>



<div class="container-fluid">
    <form method="post">
        <input class="btn btn-success btn-new new" type="submit" name="post" value="New Post">
    </form>
</div>
<!--<div class='divone'>-->
<?php echo $posts;?>
<!--</div>-->


<div class="div1">

</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
</body>
</html>
