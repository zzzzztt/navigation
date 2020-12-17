<?php

 $postusername = $_REQUEST['username'];
 $postmdp =$_REQUEST['mdp'];

 $dom = new DOMDocument();
 $dom->load('./utilisateur.xml');
 $utilisateur=$dom->getElementsByTagName('utilisateur');
 session_start();
foreach ($utilisateur as $i) {
  $usernames=$i->getElementsByTagName('username');
  $username=$usernames->item(0)->nodeValue;
  if($username==$postusername){
    $mdps=$i->getElementsByTagName('mdp');
    $mdp=$mdps->item(0)->nodeValue;
    if($mdp==$postmdp){
      $_SESSION['login'] = 1;
      $_SESSION['username'] = $username;
      echo "<script>alert('Bienvenue $username');</script>";
      header("refresh:0;url=homepage.html");
      break;
    }
    else {

      header("refresh:0;url=login.html");
      break;
    }
  }
  else{
    continue;
  }
}

/* for($i=0;$i++){
   $a= $listusername[$i]->utilisateur->nodeValue；
   if($a==$username){
     for($j=0;$j++){
       $b= $listusername[$j]->utilisateur->nodeValue；
       if($b==$mdp){
          $_SESSION['views'] = 1;
          break;
       }
     }
   }
 }
 */
 //$a= $x[$i]->utilisateur->nodeValue
?>
