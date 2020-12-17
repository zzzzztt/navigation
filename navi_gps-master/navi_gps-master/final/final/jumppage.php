<?php
    session_start();
    $i=$_POST['resultchemin'];
    $resultchemin=array();
    $resultchemin=$_SESSION['result'];
    $_SESSION['cheminuse']= $resultchemin[$i] ;
    $_SESSION['fois']=0;


     header("refresh:0;url=verifier1.php");
?>
