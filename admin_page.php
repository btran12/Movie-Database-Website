<?php
   ob_start();
   session_start();
   if (!$_SESSION['valid']){
?>

<html lang = "en">
   <head>
      <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" type="text/css" href="styles.css">
      <title>Log In to Database</title>

   </head>
	
   <body class="login-page-body">
      
      <?php
         
         $msg = '';
         
         if (!empty($_POST)) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (($username == 'btran' && $password == '6291')|| ($username == 'guest' && $password == '1234')) {

               $_SESSION['valid'] = true;
               //$_SESSION['timeout'] = time();
               if ($username == 'btran'){
                  $_SESSION['username'] = 'btran';
                  header('Refresh: 1; URL = add_movie.php');
               }else if ($username == 'guest'){
                  $_SESSION['username'] = 'guest';
                  header('Refresh: 1; URL = view_movies.php');
               }
               

               
            }else {
               $msg = 'Incorrect Login Credentials. Try Again.';
            }
         }
      ?>
      
         <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
            <div class="login-block">
                <h1>Login</h1>
                <p style="font-family:Montserrat"><?php echo $msg; ?></p>
                <input type="text" name="username" placeholder="Username - (guest)" id="username" required/>
                <input type="password" name="password" placeholder="Password - (1234)" id="password" required/>
                <button  type="submit" name = "login">Login</button>
				<a href="index.php"><div class="cancel-button"></div></a>
            </div>
         </form>
			

   </body>
</html>

<?php
}else{
   //If already logged in just redirect
   if ($_SESSION['username'] == 'btran'){
      header('Refresh: 1; URL = add_movie.php');
   }else if ($_SESSION['username'] == 'guest'){
      header('Refresh: 1; URL = view_movies.php');
   }
}
?>