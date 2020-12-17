<?php
  session_start();
  //$postnompasse = $_POST['nompasse'];
  $posttypeville = $_POST['typeville'];
  $posttyperoute = $_POST['typeroute'];
  $posttouristique = $_POST['touristique'];
  $postradar = $_POST['radar'];
  $postpayant = $_POST['payant'];
  $postchemin = $_POST['chemin'];
  //echo "Pageviews=". $_SESSION['username'];
  $susername = $_SESSION['username'];

  $dom = new DOMDocument();
  $dom->formatOutput = true;
  $dom->load('./utilisateur.xml');
  $utilisateurs=$dom->getElementsByTagName('utilisateur');
  $xpath = new DOMXPath($dom);

$j=0;

    foreach ($utilisateurs as $i) {
      $usernames=$i->getElementsByTagName('username');
      $username=$usernames->item(0)->nodeValue;

      if($username==$susername){
          $utilisateur =$dom->getElementsByTagName('utilisateur')->item($j);
          $j++;
          $preference = $dom->createElement('preference');
          //$element1 = $dom->createElement('nompasse',$postnompasse);
          foreach ($posttypeville as $k) {
            $element2 = $dom->createElement('typeville',$k);
            $preference->appendChild($element2);
          }
          foreach ($posttyperoute as $k) {
            $element3 = $dom->createElement('typeroute',$k);
            $preference->appendChild($element3);
          }


          $element4 = $dom->createElement('touristique',$posttouristique);
          $element5 = $dom->createElement('radar',$postradar);
          $element6 = $dom->createElement('payant',$postpayant);
          $element7 = $dom->createElement('chemin',$postchemin);
          //$preference->appendChild($element1);
          // $preference->appendChild($element2);
          // $preference->appendChild($element3);
          $preference->appendChild($element4);
          $preference->appendChild($element5);
          $preference->appendChild($element6);
          $preference->appendChild($element7);
          $utilisateur->appendChild($preference);

          $dom->save('./utilisateur.xml');
          echo "<script>alert('reussi');</script>";
          header("refresh:0;url=homepage.html");
          break;
        //}
        // else {
        //   echo  "4";
        //   $preference = $i->getElementsByTagName('preference');
        //   foreach ($preference as $j){
        //     $element1 = $j->getElementsByTagName('nompasse');
        //     $element2 = $j->getElementsByTagName('typeville');
        //     $element3 = $j->getElementsByTagName('typeroute');
        //     $element4 = $j->getElementsByTagName('touristique');
        //     $element5 = $j->getElementsByTagName('radar');
        //     $element6 = $j->getElementsByTagName('payant');
        //     $element7 = $j->getElementsByTagName('chemin');
        //     $element1->item(0)->nodeValue=$postnompasse;
        //     $element2->item(0)->nodeValue=$posttypeville;
        //     $element3->item(0)->nodeValue=$posttyperoute;
        //     $element4->item(0)->nodeValue=$posttouristique;
        //     $element5->item(0)->nodeValue=$postradar;
        //     $element6->item(0)->nodeValue=$postpayant;
        //     $element7->item(0)->nodeValue=$postchemin;
        //     header("refresh:0;url=homepage.html");
        //     $dom->save('./utilisateur.xml');
        //     break;
        //   }

        //}

      }
      // else{
      //   continue;
      // }


  }




  ?>
