<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>

    <title>Login</title>
    <link rel="icon" href="navi.ico" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    </script>
    <meta content="text/html;charset=utf-8" http-equiv="content-type"/>
    <link href="style.css" type="text/css" media="screen" rel="stylesheet"/>
    <header>
        <h1>NAVI_GPS</h1>
    </header>

</head>

<body>
  <div class="title">
      <h>  Histoire !</h>
  </div>
  <div class="set" style="text-align: left">
      <input type="button" id="but1" onclick="window.location.href='information.html'"></input>
  </div>
  <div class="Divetat" style="text-align: right">
      <input type="button" id="but3" onclick="window.location.href='homepage.html'" value="Acceuil">
      <input type="button" id="but3" onclick="window.location.href='login.html'" value="Login"><!--未登陆时显示-->
      <input type="button" id="but3" onclick="window.location.href='logout.html'" value="Logout"><!--登陆时显示-->
  </div>
<div  class="mainbox">

                <?php

                $dom = new DOMDocument();
                $dom->load('./utilisateur.xml');
                $utilisateur=$dom->getElementsByTagName('utilisateur');
                session_start();
                foreach ($utilisateur as $i) {
                 $usernames=$i->getElementsByTagName('username');
                 $username=$usernames->item(0)->nodeValue;
                 $susername=$_SESSION['username'];
                 if($username==$susername){
                   $histoires = $i->getElementsByTagName('hisoire');
                   $num=0;
                   foreach ($histoires as $k) {

                     $villes=$k->getElementsByTagName('villepasse');
                     $tmp=0;
                     $num++;
                     echo "</br>$num : ";
                     foreach ($villes as $j) {
                       echo "  ville[$tmp]->";
                       echo $villes->item($tmp)->nodeValue;
                       $tmp++;
                     }

                   }
                     break;
                   }
                   else{
                     continue;
                   }
                 }




                ?>
</div>
</br>


</body>
