<?php

function hexami($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}

function decrypt($toDecrypt){
    $ret = false;
    $method = "AES-256-CBC";
    $s_key = hexami("63756c6574746f6d6172726f6e63696e6f646976616c6572696f656c756361");
    $s_iv = hexami("74757474657a6f7a7a65");

    $key =  hash('sha256', $s_key);

    $iv = substr(hash('sha256', $s_iv), 0, 16);
    $ret = openssl_decrypt(base64_decode($toDecrypt), $method, $key, 0, $iv);
    return $ret;
}

function multiexplode($delimiters, $string) // per scompattare array da stringa con "/"
{
    $ready  = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return $launch;
}

if (isset($_GET['cat_var'])) {
    $php_var = $_GET['cat_var'];
    if (!is_dir($php_var)) {
        if (@file_get_contents($php_var, FILE_USE_INCLUDE_PATH) == true) {
            echo file_get_contents($php_var, FILE_USE_INCLUDE_PATH);
        } else
            echo "Errore: Non disponi dei privilegi necessari ad aprire il file!";
    }
} else if (isset($_GET['cd_var'])) {
    $php_var = $_GET['cd_var'];
    if (is_dir($php_var)) {
        if (@chdir($php_var) !== true)
            echo "Errore!";
    } else {
        echo "Errore: Non puoi spostarti in un file";
        // tolgo l'utlima occorrenza del percorso
        $exploded = multiexplode(array("/"), $php_var);
        $removed  = array_pop($exploded);
        $removed  = array_pop($exploded);
        $separate = implode("/", $exploded);
        $result   = $separate;
        if (is_dir($result))
            chdir($result);
    }
} else if (isset($_GET['ls_var'])) {
    $php_var = $_GET['ls_var'];
    $row     = exec('ls ' . $php_var, $output, $error);
    while (list(, $row) = each($output))
        echo $row, "\n";
    if ($error)
        exit;
} else if (isset($_GET['ls-l_var'])) {
    $php_var = $_GET['ls-l_var'];
    $row     = exec('ls -l ' . $php_var, $output, $error);
    while (list(, $row) = each($output))
        echo $row, "\n";
    if ($error)
        exit;
} else if (isset($_GET['ping_var'])) {
    $php_var = $_GET['ping_var'];
    $out     = shell_exec("ping -c2 $php_var");
    echo $out . "\n";
} else if (isset($_GET['touch_var'])) {
    $php_var = $_GET['touch_var'];
    if (@fopen($php_var, "w") !== true)
        die("Non disponi dei permessi necessari!");
} else if (isset($_GET['mkdir_var'])) {
    $php_var = $_GET['mkdir_var'];
    if (@mkdir($php_var, 0777, true) !== true)
        die('Impossibile creare una Directory, Permesso negato...');
} else if (isset($_GET['rm_var'])) {
    $php_var = $_GET['rm_var'];
    try {
        if (@unlink($php_var) == true)
            echo 'File Rimosso con Successo';
        else
            echo "Errore: Non disponi dei privilegi necessari!";
    }
    catch (Exception $e) {
        echo $e->getMessage();
    } // stampa il messaggio d'errore scritto sopra
} else if (isset($_GET['rm-r_var'])) {
    $php_var = $_GET['rm-r_var'];
    if (is_dir($php_var)) {
        if (@rmdir($php_var) !== true)
            die('Impossibile rimuovere la Directory, Permesso negato...');
    }
    echo "Directory Rimossa con Successo!";
}

else if (isset($_GET['sudo_var'])) {
    $userToDelete = $_GET['sudo_var']; // userToDelete contiene l'utente da eliminare
    session_start();
    if (isset($_SESSION['username'])) {
        $loggedUser = $_SESSION['username']; //loggedUser = istanza utente loggato
        $servername = "localhost";
        $username   = "root";
        $password   = "";
        $dbname     = "registration";
        $conn       = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error)
            die("Connessione Fallita: " . $conn->connect_error);
        
        $sql    = "SELECT * FROM users";
        $result = $conn->query($sql);
        
        $idLoggedUser = 0; // verrà popolato con l'id dell'utente loggato
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row["username"] == $loggedUser)
                $idLoggedUser = $row["id"];
            while ($row = $result->fetch_assoc()) {
                if ($row["username"] == $loggedUser)
                    $idLoggedUser = $row["id"];
            }
            if ($idLoggedUser < 3) {
                // sei Root Finalmente
                echo "Procedo con l'eliminazione dell'utente \" " . $userToDelete . "\"\n";
                $sql    = "DELETE FROM users WHERE username = \"" . $userToDelete . "\"";
                $result = mysqli_query($conn, $sql);
                
                if ($conn->query($sql) === TRUE)
                    echo "Cancellazione Avvenuta con Successo!";
                else
                    echo "Errore nella Cancellazione: " . $conn->error;
                
            } else {
                echo "\nErrore: Non disponi dei privilegi di Super User!";
                exit();
            }
            
        } else
            echo "Nessun Risultato!";
        
        $conn->close();
    }
} else if (isset($_GET['print_db'])) {
    session_start();
    if (isset($_SESSION['username'])) {
        $loggedUser = $_SESSION['username']; //loggedUser = istanza utente loggato
        $servername = "localhost";
        $username   = "root";
        $password   = "";
        $dbname     = "registration";
        $conn       = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error)
            die("Connessione Fallita: " . $conn->connect_error);
        
        $sql    = "SELECT * FROM users";
        $result = $conn->query($sql);
        
        $idLoggedUser = 0; // verrà popolato con l'id dell'utente loggato
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row["username"] == $loggedUser)
                $idLoggedUser = $row["id"];
            while ($row = $result->fetch_assoc()) {
                if ($row["username"] == $loggedUser)
                    $idLoggedUser = $row["id"];
            }
            if ($idLoggedUser < 3) {
                echo "Sei Super User, benvenuto " . $loggedUser . "!";
                echo "\nEcco La Lista degli Utenti Registrati\n";
                $sql    = "SELECT * FROM users";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "  " . $row["id"] . " | " . $row["username"] . " | " . $row["email"] . " | "  . decrypt($row["password"]) . "\n";
                    while ($row = $result->fetch_assoc()) {
                        echo "  " . $row["id"] . " | " . $row["username"] . " | " . $row["email"] . " | " . decrypt($row["password"]) . "\n";
                    }
                }
            } else {
                echo "\nErrore: Non disponi dei privilegi di Super User!";
                exit();
            }
            
        } else
            echo "Nessun Risultato!";
        
        $conn->close();
    }
} else
    $php_var = "Ti sei dimenticato di settare la variabile!";

?>