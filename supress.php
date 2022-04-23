
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
            $host = '{'.$_SESSION['email_serv'].':993/imap/ssl/novalidate-cert/norsh}'.$folder;
            /* Your gmail credentials */
            $user = $_SESSION['email_addr'];
            $password = $_SESSION['email_pass'];
  
            /* Establish a IMAP connection */
            $conn = imap_open($host, $user, $password) 
                 or die('unable to connect mailbox: ' . imap_last_error());
  
            $uid = $_GET['uid'];
            imap_delete($conn, $uid, FT_UID);
            imap_close($conn);
            if($folder == "INBOX"){
                header("Location: https://totul.fr/webmail/main");
            }else{
                header("Location: https://totul.fr/webmail/folder/".$folder);
            }
        ?>
    <script>
        document.getElementsByTagName("a").setAttribute("target", "_BLANK");
    </script>