<?php
  $mdp =$_POST['mdp'];
  $username = $_POST['username'];

  if(verif($username)){
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;
    $dom->load('./utilisateur.xml');
    $data=$dom->getElementsByTagName('data')->item(0);
    $utilisateurs = $dom->createElement('utilisateurs');
    $listutilisateur = $dom->createElement('utilisateur');
    $element1 = $dom->createElement('username',$username);
    //$newtext1=$dom->createTextNode($username);
    $element2 = $dom->createElement('mdp',$mdp);
    //$newtext2=$dom->createTextNode($mdp);
    $listutilisateur->appendChild($element1);
    $listutilisateur->appendChild($element2);
    $data->appendChild($listutilisateur);
    //$listutilisateur[0]->appendChild($element2);
    $dom->save('./utilisateur.xml');
    //echo "<script>alert('reussi');</script>";
    //header("refresh:0;url=homepage.html");
  }
  else {
    echo "exist";
    //echo "<script>alert('il exist deja');</script>";
    //header("refresh:0;url=inscription.html");
  }



  function verif($user){
    $ok = true;
    $dom = new DOMDocument();
    $dom->load('./utilisateur.xml');
    $utilisateur=$dom->getElementsByTagName('utilisateur');

    foreach ($utilisateur as $i) {
      $usernames=$i->getElementsByTagName('username');
      $username=$usernames->item(0)->nodeValue;
      if($username==$user){
        $ok = false;
        break;
      }
      else{
        continue;
      }
    }

    return $ok;
  }




  //header("refresh:0;url=homepage.html");




?>
