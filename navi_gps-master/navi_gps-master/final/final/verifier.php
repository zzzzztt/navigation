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


  <div  class="mainbox">
    <form method="post" action="jumppage.php">
    <?php
      session_start();
      $result=$_SESSION['result'];

      echo "1.pluscourt : Les ville passe : ";
      $i=0;
      foreach ($result[0][0][0] as $k) {
        echo "  ville[$i]->";
        echo $k;
        $i++;
      }
      //print_r($result[0][0][0]);
      echo " </br>| Longueur : ";
      echo $result[0][0][1];
      echo " </br>| Temp : ";

      echo $result[0][0][2];

      echo " </br>| Les route passe : ";
      $i=0;
      foreach ($result[0][0][3] as $k) {
        echo "  route[$i]->";
        echo $k;
        $i++;
      }
      echo " <input name='resultchemin' type='radio' value='0'> </br>";

      echo "2.plusrapide : Les ville passe : ";
      $i=0;
      foreach ($result[1][0][0] as $k) {
        echo "  ville[$i]->";
        echo $k;
        $i++;
      }
      echo " </br>| Longueur : ";
      echo $result[1][0][1];
      echo " </br>| Temp : ";

      echo $result[1][0][2];

      echo " </br>| Les route passe : ";
      $i=0;
      foreach ($result[1][0][3] as $k) {
        echo "  route[$i]->";
        echo $k;
        $i++;
      }
      echo " <input name='resultchemin' type='radio' value='1'></br>";

      echo "3.avec Preferences : Les ville passe : ";
      $i=0;
      foreach ($result[2][0][0] as $k) {
        echo "  ville[$i]->";
        echo $k;
        $i++;
      }
      echo " </br>| Longueur : ";
      echo $result[2][0][1];
      echo " </br>| Temp : ";

      echo $result[2][0][2];

      echo " </br>| Les route passe : ";
      $i=0;
      foreach ($result[2][0][3] as $k) {
        echo "  route[$i]->";
        echo $k;
        $i++;
      }
      echo " <input name='resultchemin' type='radio' value='2'></br>";
      echo "<input type='submit' id='but3' value='confirmer'>";


      ?>

    </form>
</div>


</br>


</body>
