<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>

    <title>Verifier Etape</title>
    <link rel="icon" href="navi.ico" type="image/x-icon">
    <meta content="text/html;charset=utf-8" http-equiv="content-type"/>
    <link href="style.css" type="text/css" media="screen" rel="stylesheet"/>
    <header>
        <h1>NAVI_GPS</h1>
    </header>
</head>

<body>
  <div class="title">
      <h>  Verifier etapes !</h>
  </div>

  <div class="set" style="text-align: left">
      <input type="button" id="but1" onclick="window.location.href='information.html'"></input>
      <input type="button" id="but2" onclick="histoire"></input>
  </div>
  <div class="Divetat" style="text-align: right">
    <input type="button" id="but3" onclick="window.location.href='homepage.html'" value="Acceuil">
      <input type="button" id="but3" onclick="window.location.href='login.html'" value="Login"><!--未登陆时显示-->
      <input type="button" id="but3" onclick="logout" value="Logout"><!--登陆时显示-->
  </div>




  <div class="nextbox">
    <form method="post" action="verifier1.php">
    <?php
    session_start();
    $resultuse=$_SESSION['cheminuse'];
    $i=$_SESSION['fois'];

    if($i<sizeof($resultuse[0][3])) {
    //print_r($resultuse);


    echo "</br>roule sur :  ";
    print_r($resultuse[0][3][$i]);
    echo "  route</br>vous avez atteint la ville ";
    print_r($resultuse[0][0][$i+1]);
    echo " ？</br>";
    $_SESSION['fois']= $i+1;
    }
    else {
      if(isset($_SESSION['username']))
      {
        $username=$_SESSION['username'];
        $histoire=$resultuse[0][0];
        addhistoire($username,$histoire);
      }
      echo "<script>alert('vous avez fini tous etape')</script>";
      header("refresh:0;url=homepage.html");
    }
    echo "<input type='submit' id='but3' value='verifier'>";

    function addhistoire($susername,$shistoire){
      $dom = new DOMDocument();
      $dom->formatOutput = true;
      $dom->load('./utilisateur.xml');
      $utilisateurs=$dom->getElementsByTagName('utilisateur');
      $j=0;
      foreach ($utilisateurs as $i) {
        $usernames=$i->getElementsByTagName('username');
        $username=$usernames->item(0)->nodeValue;

        if($username==$susername){

            $utilisateur =$dom->getElementsByTagName('utilisateur')->item($j);
            $histoire = $dom->createElement('hisoire');
            $j++;
            foreach ($shistoire as $k) {
              $ville = $dom->createElement('villepasse',$k);
              $histoire->appendChild($ville);
            }

            $utilisateur->appendChild($histoire);

            $dom->save('./utilisateur.xml');
            //header("refresh:0;url=homepage.html");
            break;
          }
        }

    }



    ?>
    <input type='button' id='but3' value='perdu' onclick="window.location.href='information.html'">
  </form>
  </div>
</br>


</body>
