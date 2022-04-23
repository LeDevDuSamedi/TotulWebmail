<?php
session_start();
if($_SESSION['mail'] != true){
    header("Location: https://totul.fr/webmail/login.php");
}
$folder = $_GET['folder'];
$boite = $_SESSION['email_serv'];
            /* gmail connection,with port number 993 */
            $host = '{'.$boite.':993/imap/ssl/novalidate-cert/norsh}'.$folder;
            /* Your gmail credentials */
            $user = $_SESSION['email_addr'];
            $password = $_SESSION['email_pass'];
            
            /* Establish a IMAP connection */
            $imap_connect = imap_open($host, $user, $password) 
                 or die('unable to connect mailbox: ' . imap_last_error());
            /* Search emails from gmail inbox*/
            $mails = imap_search($imap_connect, 'ALL');
  
            /* loop through each email id mails are available. */
            if ($mails) {
  
                /* Mail output variable starts*/
                $mailOutput = '';
                $mailOutput.= '<table><tr><th>Subject </th><th> From  </th> 
                           <th> Date Time </th></tr>';
  
                /* rsort is used to display the latest emails on top */
                rsort($mails);
  
                /* For each email */
                foreach ($mails as $email_number) {
  
                    /* Retrieve specific email information*/
                    $headers = imap_fetch_overview($imap_connect, $email_number, 0);
  
                    /*  Returns a particular section of the body*/
                    $message = imap_fetchbody($imap_connect, $email_number, '1');
                    $subMessage = substr($message, 0, 150);
                    $finalMessage = trim(quoted_printable_decode($subMessage));
  
                    $mailOutput.= '<div class="row">';
  
                    /* Gmail MAILS header information */           
                    $uid = $headers[0]->uid;
                    $from = str_replace('"', '', $headers[0]->from);
                    /* Formatage de la date */
                    $date = str_replace("Mon", "Lundi", $headers[0]->date);
                    $date = str_replace("Tue", "Mardi", $date);
                    $date = str_replace("Wed", "Mercredi", $date);
                    $date = str_replace("Thu", "Jeudi", $date);
                    $date = str_replace("Fri", "Vendredi", $date);
                    $date = str_replace("Sat", "Samedi", $date);
                    $date = str_replace("Sun", "Dimanche", $date);
                    /* Mois */
                    $date = str_replace("Jan", "Janvier", $date);
                    $date = str_replace("Feb", "Fevrier", $date);
                    $date = str_replace("Mar", "Mars", $date);
                    $date = str_replace("Apr", "Avril", $date);
                    $date = str_replace("May", "Mai", $date);
                    $date = str_replace("Far", "Juin", $date);
                    $date = str_replace("Jul", "Juillet", $date);
                    $date = str_replace("Aug", "Août", $date);
                    $date = str_replace("Sep", "Septembre", $date);
                    $date = str_replace("Oct", "Octobre", $date);
                    $date = str_replace("Nov", "Novembre", $date);
                    $date = str_replace("Dec", "Decembre", $date);
                    
                    $subject = ucfirst(strtolower($headers[0]->subject));
                    if(stripos($date, "+0000")){
                          $date = str_replace("+0000", "", $date);
                    }
                    $date = str_replace(",", "", $date);
                    /* Fin de la ligne */
                    $mailOutput.= '<tr><td><span class="columnClass">' .
                                $subject . '</span></td> ';
                    $mailOutput.= '<td><span class="columnClass">' . 
                                $from . '</span></td>';
                    $mailOutput.= '<td><span class="columnClass">' .
                                 $date . '</span></td><td><span class="columnClass"><a href="../mail.php?uid='.$uid.'&folder='.$folder.'"><i class="fa-regular fa-envelope env"></i></a></span></td>';
                    $mailOutput.= '</div>';
                }// End foreach
                $mailOutput.= '</table>';
            }//endif 
  
            /* imap connection is closed */
            imap_close($imap_connect);
            $foldern = ucfirst(strtolower($folder));
            $foldern =str_replace("Inbox", "Boîte de récéption", $foldern);
            $foldern =str_replace("Drafts", "Brouillons", $foldern);
            $foldern =str_replace("Oubox", "Boîte d'envoi'", $foldern);
            $foldern =str_replace("Junk", "Boîte des indésirables", $foldern);
            ?>
<!DOCTYPE html>
<html>
  
<head>
    <script src="https://kit.fontawesome.com/fc44161755.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
  
    <script>
        function getEmails() {
            document.getElementById('dataDivID')
                .style.display = "block";
        }
    </script>
</head>
  
<body>
    <h2 align="center"><?=$foldern?> - TotMail</h2>
    <br>
    <div class="folder"></div>
    <div id="dataDivID" class="form-container">
        <?=$mailOutput?>
    </div>
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