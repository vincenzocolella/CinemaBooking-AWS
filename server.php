<?php
function hexami($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}
function encrypt($toDecrypt){
  $ret = false;
  $method = "AES-256-CBC";
  $s_key = hexami("63756c6574746f6d6172726f6e63696e6f646976616c6572696f656c756361");
  $s_iv = hexami("74757474657a6f7a7a65");

  $key =  hash('sha256', $s_key);

  $iv = substr(hash('sha256', $s_iv), 0, 16);
  $ret = openssl_encrypt($toDecrypt, $method, $key, 0, $iv);
  $ret = base64_encode($ret);
  return $ret;
}

session_start();

$username = "";
$email    = "";
$errors = array(); 

$db = mysqli_connect('localhost', 'root', '', 'registration');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // inserimento valori dal form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);


  if (empty($username)) { array_push($errors, "Inserire un Username"); }
  if (empty($email)) { array_push($errors, "Inserire l'email"); }
  if (empty($password_1)) { array_push($errors, "Inserire la Password"); }
  if ($password_1 != $password_2) {
    array_push($errors, "Le due password non coincidono");
  }


  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // se l'username già è in database
    if ($user['username'] === $username) {
      array_push($errors, "L'username inserito risulta già registrato");
    }

    if ($user['email'] === $email) {
      array_push($errors, "L'email inserita risulta già registrata");
    }
  }
  
  
  if (count($errors) == 0) {
  	$password = encrypt($password_1); // prima di salvare la password la cripto 

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = ""; // messaggio che mostra dopo la registrazione



  	header('location: index.php');
  }
}

if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $tmp = $_POST['password'];
  $password = mysqli_real_escape_string($db, $tmp);

  if (empty($username)) {
    array_push($errors, "Inserire un username");
  }
  if (empty($password)) {
    array_push($errors, "Inserire la password");
  }

  if (count($errors) == 0) {	// se non ci sono errori sono loggato
    $password = encrypt($password);
    $t1 = encrypt($tmp);
    $query = "SELECT * FROM users WHERE username='$username' AND password='$t1'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "";
      header('location: index.php');
    }else {
      array_push($errors, "Errore: Username o Password errate!");
    }
  }
}



?>