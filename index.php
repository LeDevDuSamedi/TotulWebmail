<?php 
session_start();
if($_SESSION['mail'] != true){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
  
<head>
    <script src="https://kit.fontawesome.com/fc44161755.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
</head>
  
<body>
    <h2 align="center">Boîte de réception - TotMail</h2>
    <?php
    $mois = array(
                        "Jan" => "Janvier",
                        "Feb" => "Fevrier",
                        "Mar" => "Mars",
                        "Apr" => "Avril",
                        "May" => "Mai",
                        "Jun" => "Juin",
                        "Jul" => "Juillet",
                        "Aug" => "Aout",
                        "Sep" => "Septembre",
                        "Oct" => "Octobre",
                        "Nov" => "Novembre",
                        "Dec" => "Decembre"
        );
    $jours = array(
                        "Mon" => "Lundi",
                        "Tue" => "Mardi",
                        "Wed" => "Mercredi",
                        "Thu" => "Jeudi",
                        "Sat" => "Samedi",
                        "Sun" => "Dimanche",
                        "Fri" => "Vendredi",
                        );
    $email_srv = $_SESSION['email_serv'];
    $user = $_SESSION['email_addr'];
    $password = $_SESSION['email_pass'];
            /* Mail connection,with port number 993 */
            $host = '{'.$email_srv.':993/imap/ssl/novalidate-cert/norsh}INBOX';
            /* Your gmail credentials */
  
            /* Establish a IMAP connection */
            $imap_connect = imap_open($host, $user, $password) 
                 or die('unable to connect mailbox: ' . imap_last_error());
                 $list = imap_list($imap_connect, '{'.$email_srv.'}', "*");
if (is_array($list)) {
    foreach ($list as $val) {
        $folder = mb_convert_encoding($val, "utf-8", "UTF7-IMAP");
        $folder = str_replace('{'.$email_srv.'}', "", $folder);
        $link = "<a href='folder/".$folder."'>$folder</a><br>";
        echo($link);
    }
} else {
    echo "imap_list failed: " . imap_last_error() . "\n";
}

            /* Search emails from gmail inbox*/
            $mails = imap_search($imap_connect, 'ALL');
  
            /* loop through each email id mails are available. */
            if ($mails) {
  
                /* Mail output variable starts*/
                $mailOutput = '';
                $mailOutput.= '<table><tr><th>Sujet </th><th> De  </th> 
                           <th> Reçu le </th><th> Ouvrir </th><th> Supprimer </th></tr>';
  
                /* rsort is used to display the latest emails on top */
                rsort($mails);
  
                /* For each email */
                $i=1;
                foreach ($mails as $email_number) {
                    if($i==25) break;
                    $i++;
                    /* Retrieve specific email information*/
                    $headers = imap_fetch_overview($imap_connect, $email_number, 0);
  
                    /*  Returns a particular section of the body*/
                    $message = imap_fetchbody($imap_connect, $email_number, '1');
                    $subMessage = substr($message, 0, 150);
                    $finalMessage = trim(quoted_printable_decode($subMessage));
  
                    $mailOutput.= '<div class="row" >';
  
                    /* Gmail MAILS header information */           
                    $uid = $headers[0]->uid;
                    $from = str_replace('"', '', $headers[0]->from);
                    /* Formatage de la date */
                    
                    /* Mois */
                    
                    $subject = ucfirst(strtolower($headers[0]->subject));
                    $date = $jours[substr($headers[0]->date, 0, 3)];
                    /* Fin de la ligne */
                    $mailOutput.= '<tr class="mail" name='.$headers[0]->uid.'><td><span class="columnClass">' .
                                $subject . '</span></td> ';
                    $mailOutput.= '<td><span class="columnClass">' . 
                                $from . '</span></td>';
                    $mailOutput.= '<td><span class="columnClass">' .
                                 $date . '</span></td><td><span class="columnClass"><a href="mail/'.$uid.'"><i class="fa-regular fa-envelope env"></i></a></span></td><td><span class="columnClass"><a href="supress/'.$uid.'/INBOX"><i style="color:red;" class="fa-solid fa-trash-can"></i></a></span></td>';
                    $mailOutput.= '</div>';
                }// End foreach
                $mailOutput.= '</table>';
                echo $mailOutput;
            }//endif 
  
            /* imap connection is closed */
            imap_close($imap_connect);
            ?>
    <br>
    <div class="folder"></div>
    <style>
        body {
   font-family: Arial;
 }
  table {
     font-family: arial, sans-serif;
     border-collapse: collapse;
     width: 100%;
 }
  tr:nth-child(even) {
     background-color: #dddddd;
 }
 tr{
     transition: 1s;
 }
 tr:hover{
     background-color:#0036E3;
     color:white;
     transition: 1s;
 }
 td, th {
     padding: 8px;
     width:100px;
     border: 1px solid #dddddd;
     text-align: left;                
 }
 .form-container {
     padding: 20px;
     background: #F0F0F0;
     border: #e0dfdf 1px solid;                
     border-radius: 2px;
 }
 * {
     box-sizing: border-box;
 }
 
 .columnClass {
     float: left;
     padding: 10px;
 }
 
 .row:after {
     content: "";
     display: table;
     clear: both;
 }
 
 .btn {
     background: #333;
     border: #1d1d1d 1px solid;
     color: #f0f0f0;
     font-size: 0.9em;
     width: 200px;
     border-radius: 2px;
     background-color: #f1f1f1;
     cursor: pointer;
 }
 
 .btn:hover {
     background-color: #ddd;
 }
 
 .btn.active {
     background-color: #666;
     color: white;
 }
 .env:hover{
     transition: 0.5s;
     color: white;
 }
  .env{
     transition: 0.5s;
     color: black;
 }
    </style>
</body>
  
</html>