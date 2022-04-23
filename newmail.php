<?php
session_start();
if($_SESSION['mail'] != true){
    header("Location: https://totul.fr/webmail/login.php");
}
            /* gmail connection,with port number 993 */
            $host = '{smtp.office365.com:587}';
            /* Your gmail credentials */
            $user = 'adi_grigore@hotmail.com';
            $password = 'AdrianG2010';
  
            /* Establish a IMAP connection */
            $imap_connect = imap_open($host, $user, $password) 
                 or die('unable to connect smtp: ' . imap_last_error());
            
  
            /* imap connection is closed */
            imap_close($imap_connect);
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
    <h2 align="center">Boîte de récéption - TotMail</h2>
    <br>
    <div class="folder"></div>
    <div id="dataDivID" class="form-container">
        
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