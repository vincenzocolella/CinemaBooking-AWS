<?php 
  session_start(); 
  $db = mysqli_connect('localhost', 'root', '', 'registration');
  //if (!isset($_SESSION['username'])) {
   //$_SESSION['msg'] = "Devi prima loggarti per accedere";
   //header('location: login.php');
  //}
 
  // Booking made

   if (isset($_GET['booked'])) {
   if (!isset($_SESSION['username'])) {
   $_SESSION['msg'] = "Devi prima loggarti per accedere";
   header('location: login.php');
   }
   $username = $_SESSION['username'] ;
   
   
   // more than one booking
   $number = "SELECT * FROM users WHERE username = '$username'";
   $result = mysqli_query($db, $number);
   while ($row = mysqli_fetch_array($result)) {
      $booked_before = $row['booked'];
  }
   $booked = $_GET['booked'];
   $total = "SELECT SUM(booked) FROM users";
   $result_total = mysqli_query($db, $total);
   $row = mysqli_fetch_array($result_total);
   $total_booked = $row;
  
   
   if ($booked_before[0]+1 < 10 and $total_booked[0]<51) {
   $new_booked = $booked_before[0] + 1;
   
   $query = "UPDATE users SET booked='$new_booked' WHERE username = '$username'";
   mysqli_query($db, $query);
   $_SESSION['success'] = "$new_booked Place(s) Booked"; // messaggio che mostra dopo la registrazione
   $places_left = 49-$total_booked[0];
   $_SESSION['left'] = "$places_left Place(s) Left"; // messaggio che mostra dopo la registrazione
 
      //header('location: index.php');
   }
   else if ($booked_before[0]+1 < 10){
      $message = "Sorry, you booked too many places ";
      echo "<script type='text/javascript'>alert('$message');</script>";
      }
   else {
      $message = "Sorry, there are no places left";
      echo "<script type='text/javascript'>alert('$message');</script>";
   }
   }
   if (isset($_GET['logout'])) {
      session_destroy();
      unset($_SESSION['username']);
      header("location: login.php");
      echo("hello");
     }
   
?>
<!DOCTYPE html>
<html lang="it">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>Cinema Booking</title>
  
      <link href="css/bootstrap.css" rel="stylesheet">
     
      <link rel="stylesheet" href="css/simple-line-icons.css">
      <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
      <link rel="stylesheet" href="device-mockups/device-mockups.css">
      <link href="css/multiutility.css" rel="stylesheet">
      <link href="css/terminal.css" rel="stylesheet">
   </head>

   <body id="page-top">

      <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
         <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">Cinema Booking</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                     <a class="nav-link js-scroll-trigger" href="#features">Booking</a>
                  </li>

                  <li class="nav-item">
                     <a class="nav-link js-scroll-trigger" href="#about">About Us</a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <header class="masthead">  
         <div class="container h-100">
            <div class="row h-100">
               <div class="col-lg-7 my-auto" id="titolo">
                  <div class="header-content mx-auto">
                     <h1 class="mb-5" id="scrollante" > Cinema Booking </h1>
                     <a  class="btn btn-outline btn-xl js-scroll-trigger tastone" id =\"{$t}\" href=index.php?logout='1'" onclick=\"open_page('ajaxinfo.php','content'); javascript:change('{$t}');\">
                         

                            
                            <?php  if (isset($_SESSION['username'])) : ?>
                              <p class="welcomeBtn">Welcome <strong><?php echo $_SESSION['username'];?></strong></p>
                              
                           <?php endif ?>

                           <p  style="color: aquamarine;margin-bottom: 0;" class="cliccaQui">Press here to logout</p>
                           
                     </a> 
                    
                     <a name="booked" class="btn btn-outline btn-xl js-scroll-trigger tastone" id =\"{$t}\" href=index.php?booked='1'" onclick=\"open_page('ajaxinfo.php','content'); javascript:change('{$t}');\">

                           <p  style="color: white;margin-bottom: 0;">Click to Book a seat</p>
                           
                         </a> 
                         <br> <br>  <br>
                         <a  class="btn btn-outline btn-xl " id =\"{$t}\" <?php if(!isset($_SESSION['left'])) echo 'style="display:none"';?>>
                         

                            
                         <?php if (isset($_SESSION['left'])) : ?>
                              <div class="error success" >
                                 <h3>
                                  <?php 
                                    echo $_SESSION['left']; 
                                    unset($_SESSION['left']);
                                  ?>
                                 </h3>
                              </div>
                           <?php endif ?>

                        
                           
                     </a>
                     <a  class="btn btn-outline btn-xl " id =\"{$t}\" <?php if(!isset($_SESSION['success'])) echo 'style="display:none"';?>>
   
                     <?php if (isset($_SESSION['success'])) : ?>
                              <div class="error success" >
                                 <h3>
                                  <?php 
                                    echo $_SESSION['success']; 
                                    unset($_SESSION['success']);
                                    
                                  ?>
                                 </h3>
                              </div>
                           <?php endif ?>

                        
                           
                     </a>
                     
                     
                  </div>
               </div>
               <div class="col-lg-5 my-auto mio" id="iphone">
                  <div class="device-container">
                     <div class="device-mockup iphoneXS">
                        <div class="device">
                        	<img class = "mani"id = "mani" src="img/mani.gif">
                           <div class="screen" id="schermo">

                              <a href="" class="typewrite" data-period="2000" data-type='[ "Welcome to our website. Here you can reserve your place to watch a movie.", "Simply press the big central button to choose your movie."," "]'>
                                <span class="wrap"></span>
                              </a>
                           </div>
                           <div class="button" id="iPhoneBtn">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </header>

      
	<section class="about" id="about" style="min-width: 100%; min-height: 100%">
	   <div class="section-heading text-center">
	      <h2 class="titoloAboutUs">About Us</h2>
	   </div>
	   <div class="container aboutus" style="max-width: 100%">
	      <div class="row">
	         <div class="col-lg noemi" style="height: 50%; text-align: center; ">
	            <a href="https://www.instagram.com/yelsew10/" target="_blank">
	            <img class="foto" id="noemi" src="img/noemi.jpg" style="width: 45%; border-radius: 10%; border: 2px solid white;">
	            </a>
	         </div>
	         <div class="col-lg vins" style="text-align: center;" >
	            <a href="https://www.instagram.com/vinsssssssssssssss/" target="_blank">
	            <img class="foto" id ="vins" src="img/vins.jpg" href ="www.google.it" style="width: 45%; margin-top: 3%; border-radius: 10%; border: 2px solid white;">
	            </a>
	         </div>
	      </div>
	      <div class="row">
	         <div class="col">
	            <p class="descrsotto" style=" margin-left: 7%;">
Ci siamo conosciuti durante le lezioni di Ingegneria Informatica nel 2016. Siamo appassionati di tecnologia fin dall'infanzia e siamo sempre a caccia dell' ultimo gadget e dell'ultima trovata tecnologica.<br>
Il nostro <strong>obiettivo</strong> e' di creare una Multi Utility semplice ed utilizzabile da chiunque che risolve dei piccoli problemi di tutti i giorni.<br>
I nostri <strong> valori </strong> fondamentali: pazienza, attenzione al dettaglio e lavoro di squadra. Facciamo del nostro meglio per creare un servizio con la massima qualita'.
</p>
	         </div>
	      </div>
	   </div>
	   </div>
	</section>
    <footer>
         <div class="container">
            <p>&copy; Cinema Booking 2022. All Rights Reserved.</p>
         </div>
    </footer>
      
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrapjs/bootstrap.bundle.min.js"></script>
      <script src="js/jquery.easing.min.js"></script>
      <script src="js/index.js"></script>
      <script src="js/multiutility.min.js"></script>
      <script src="js/nuovo.js"></script>
      <script src="js/jquery.js"></script>
   </body>
</html>
