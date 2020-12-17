<?php
session_start();
$postcurrent = $_REQUEST['mdp_current'];
$postmdp =$_REQUEST['mdp'];
$susername =$_SESSION['username'];

$dom = new DOMDocument();
$dom->load('./utilisateur.xml');
$utilisateur=$dom->getElementsByTagName('utilisateur');

foreach ($utilisateur as $i) {
 $usernames=$i->getElementsByTagName('username');
 $username=$usernames->item(0)->nodeValue;
 if($username==$susername){
   $mdps=$i->getElementsByTagName('mdp');
   $mdp=$mdps->item(0)->nodeValue;
   if($mdp==$postcurrent){
     $mdps->item(0)->nodeValue=$postmdp;
     $dom->save('./utilisateur.xml');
     header("refresh:0;url=homepage.html");
     break;
   }
   else {
     header("refresh:0;url=changerMdp.html");
     break;
   }
 }
 else{
   continue;
 }
 //header("refresh:0;url=changerMdp.html");
}



// function verif($postcurrent){
//   $ok = true;
//   $dom = new DOMDocument();
//   $dom->load('./utilisateur.xml');
//   $user=$_SESSION['username']
//   $utilisateur=$dom->getElementsByTagName('utilisateur');
//
//   foreach ($utilisateur as $i) {
//     $usernames=$i->getElementsByTagName('username');
//     $username=$usernames->item(0)->nodeValue;
//     if($username==$user){
//       $ok = false;
//       break;
//     }
//     else{
//       continue;
//     }
//   }
//
//   return $ok;
// }

?>
