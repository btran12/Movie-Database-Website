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
            if ($_POST['username'] == 'user' && $_POST['password'] == 'pass') {
               $_SESSION['valid'] = true;
               $_SESSION['timeout'] = time();
               $_SESSION['username'] = 'user';

               header('Refresh: 1; URL = add_movie.php');
            }else {
               $msg = 'Incorrect Login Credentials. Try Again.';
            }
         }
      ?>
      
         <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
            <div class="login-block">
                <h1>Login</h1>
                <p style="font-family:Montserrat"><?php echo $msg; ?></p>
                <input type="text" name="username" placeholder="Username" id="username" required/>
                <input type="password" name="password" placeholder="Password" id="password" required/>
                <button  type="submit" name = "login">Login</button>
				<a href="index.php"><div class="cancel-button"></div></a>
            </div>
         </form>
			

   </body>
</html>

<?php
}else{
   //If already logged in just redirect
   header('Refresh: 0; URL = add_movie.php');
}
?>