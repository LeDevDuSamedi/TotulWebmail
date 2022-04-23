
        <?php 
        session_start();
if($_SESSION['mail'] != true){
    header("Location: https://totul.fr/webmail/login.php");
}
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
{
    $url = "https";
}
else
{
    $url = "http"; 
}  
$url .= "://"; 
$url .= $_SERVER['HTTP_HOST']; 
$url .= $_SERVER['REQUEST_URI']; 
        $folder = $_GET['folder'];
                    /* gmail connection,with port number 993 */
            $host = '{'. $_SESSION['email_serv'].':993/imap/ssl/novalidate-cert/norsh}'.$folder;
            /* Your gmail credentials */
            $user = $_SESSION['email_addr'];
            $password = $_SESSION['email_pass'];
  
            /* Establish a IMAP connection */
            $conn = imap_open($host, $user, $password) 
                 or die('unable to connect mailbox: ' . imap_last_error());
  
            $uid = $_GET['uid'];
      $headerText = imap_fetchHeader($conn, $uid, FT_UID);
      $header = imap_rfc822_parse_headers($headerText);

      // REM: Attention s'il y a plusieurs sections
      $corps = imap_fetchbody($conn, $uid, 1, FT_UID);
            /* imap connection is closed */
            imap_close($conn);
        ?>
        <?=$corps?>
<meta charset="UTF-8">