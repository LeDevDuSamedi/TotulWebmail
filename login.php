<?php 
session_start();
$error = "";
if(isset($_POST['valider'])){
    if(!empty($_POST['email'] && !empty($_POST['mdp']))){
        $user = $_POST['email'];
            $password = $_POST['mdp'];
            $boite = stristr($user, "@");
            $boites = array(
                "@outlook.fr" => "outlook.office365.com",
                "@outlook.com" => "outlook.office365.com",
                "@hotmail.fr" => "outlook.office365.com",
                "@hotmail.com" => "outlook.office365.com",
                "@gmail.com" => "imap.gmail.com"
                );
            $boite = $boites[$boite];
            echo($boite);
            $host = '{'.$boite.':993/imap/ssl/novalidate-cert/norsh}INBOX';
            /* Your gmail credentials */
            
  
            /* Establish a IMAP connection */
            $imap_connect = imap_open($host, $user, $password) or die('unable to connect mailbox: ' . imap_last_error());
            $_SESSION['email_addr'] = $user;
            $_SESSION['email_serv'] = $boite;
            $_SESSION['email_pass'] = $password;
            $_SESSION['mail'] = true;
            sleep(2);
            header("Location: main");
    }else{
        $error = "Veuillez remplir tout les champs";
    }
}
?>
<form align="center" method="POST">
    <input type="email"name="email" placeholder="Adresse Email">
    <input type="password"name="mdp" placeholder="Mot de passe">
    <button name="valider">Se connecter à la boite mail</button>
</form>
<p align="center"><?=$error?></p>