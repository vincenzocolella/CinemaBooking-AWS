<?php include('server.php')?>
<!DOCTYPE html>
<html >
<head>
  <title>Sign-Up/Login Form</title>
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/normalize.min.css">
  <link rel="stylesheet" href="css/style.css"> 
</head>

<body>

  <div class="form" id="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Sign Up</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="signup">   
          <h1>Sign Up for Free</h1>
          
          <form action="login.php" method="post" >
          <?php include('errors.php'); ?>
          <div class="field-wrap">
            <label class="coloriLabel">
              Username<span class="req">*</span>
            </label>
            <input id = "test" type="text"required autocomplete="off" name="username" value="<?php echo $username; ?>" />
          </div>

          <div class="field-wrap">
            <label class="coloriLabel">
              Email<span class="req">*</span>
            </label>
            <input type="email" name="email" value="<?php echo $email; ?>" required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label class="coloriLabel">
              Password<span class="req">*</span>
            </label>
            <input type="password" name="password_1" required autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label class="coloriLabel">
              Conferma Password<span class="req">*</span>
            </label>
            <input type="password" name="password_2" name="reg_user" required autocomplete="off"/>
          </div>
          
          <button type="submit" class="button button-block" name="reg_user"/>Get Started</button>
          
          </form>

        </div>
        
        <div id="login">   
          <p>
            <br>
          </p>
          <h1 class= "welcomeText">Welcome Back!</h1>
          <p>
            <br>  
            <br>  
            <br>  
            <br>  
            <br>
          </p>
          <form id = "loginForm" action="login.php" method="post" >
          <?php include('errors.php'); ?>
           <div class="field-wrap">
            <label class="coloriLabel">
              Username<span class="req">*</span>
            </label>
            <input type="text" name="username" required autocomplete="off" />
           </div>
          
          <div class="field-wrap">
            <label class="coloriLabel">
              Password<span class="req">*</span>
            </label>
            <!-- gli attributi dell'input qui sotto servono per prevenire l'autocompletamento. Li gestisco
            	in index.js-->
            <input type="password" required autocomplete="off" id="pass" name="password" value="" readonly/>
            
          </div>
          <p>
            <br>
          </p>
          <button name="login_user" class="button button-block"/>Log In</button>
          
          </form>
        </div>
      </div><!-- tab-content -->
      
</div> <!-- /form -->
<script src="js/jquery.min.js"></script>
<script  src="js/index.js"></script>

</body>
</html>
