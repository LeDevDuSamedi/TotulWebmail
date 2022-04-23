<?php 
session_start();
if($_SESSION['mail'] != true){
    header("Location: https://totul.fr/webmail/login.php");
}
if(empty($_GET['uid'])){
    header("Location: main");
}
$uid = $_GET['uid'];
if(!empty($_GET['folder'])){
$folder = $_GET['folder'];
}else{
    $folder = "INBOX";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Visionneuse de mail</title>
    </head>
    <body>
        <iframe class="nonSelectionnable"width="1000px" style="resize:both;"src="fullscreen/<?=$uid?>/<?=$folder?>">
            <h1>Votre navigateur ne permet pas à la visionneuse de mail de fonctionner</h1>
        </iframe>
    </body>
    <style>
        .nonSelectionnable
{
 -moz-user-select: none; /* Firefox */
 -webkit-user-select: none; /* Chrome, Safari, Opéra depuis la version 15 */
 -ms-user-select: none; /* Internet explorer depuis la version 10 et Edge */
 user-select: none; /* Propriété standard */
}
    </style>
</html>