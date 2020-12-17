 <?php
	set_time_limit(0);
	$dom = new DOMDocument();
	$dom->load('./carte2.xml');
  session_start();
      $_SESSION['fois']=0;

  $postdepart = $_POST['depart'];
  $postdestination = $_POST['destination'];
  $posttypeville = $_POST['typeville'];
  $posttyperoute = $_POST['typeroute'];
  $posttouristique = $_POST['touristique'];
  $postradar = $_POST['radar'];
  $postpayant = $_POST['payant'];
  $postchemin = $_POST['chemin'];
  $susername = $_SESSION['username'];

  $xpath=new DOMXPath($dom);
  $query="//reseau/ville[nom='".$postdepart."']";
  $V0=$xpath->query($query)[0];
  $query="//reseau/ville[nom='".$postdestination."']";
  $V1=$xpath->query($query)[0];


	$radar=true;
	$payant=true;
	$touristique=false;
	$typeVille=array(true,true,true);
	$typeRoute=array(true,true,true,true);
  // print_r(Aetoile($V0,$V1,distance($V0,$V1),$dom,$xpath,$radar,$payant,$touristique,$typeVille,$typeRoute));
  // echo '<br>';
  // print_r(AetoileTemp($V0,$V1,distance($V0,$V1),$dom,$xpath,$radar,$payant,$touristique,$typeVille,$typeRoute));
  // echo '<br>';
  $a[0][]=Aetoile($V0,$V1,distance($V0,$V1),$dom,$xpath,$radar,$payant,$touristique,$typeVille,$typeRoute);
  $a[1][]=AetoileTemp($V0,$V1,distance($V0,$V1),$dom,$xpath,$radar,$payant,$touristique,$typeVille,$typeRoute);

  if(isset($postradar) ){
    if($postradar=='radar'){
      $radar=false;
      //unset($_SESSION['cheminuse']);
    }
  }

  if(isset($postpayant) ){
    if($postpayant=='payant'){
      $payant=false;
    }
  }

  if(isset($postradar) ) {
    if($postradar=='radar'){
      $radar=false;
    }
  }

  if(isset($posttouristique)){
    if($posttouristique=='touristique'){
      $touristique=false;
    }
  }

  if(isset($posttyperoute)){
    for($i=0;$i<4;$i++){
      if(!isset($posttyperoute[$i])){
        $typeRoute[$i]=false;
      }
    }
  }

  if(isset($posttypeville)){
    for($i=0;$i<3;$i++){
      if(!isset($posttypeville[$i])){
        $typeVille[$i]=false;
      }
    }
  }

  if($postchemin=='pluscourt'){
    // print_r(Aetoile($V0,$V1,distance($V0,$V1),$dom,$xpath,$radar,$payant,$touristique,$typeVille,$typeRoute));
    $a[2][]=Aetoile($V0,$V1,distance($V0,$V1),$dom,$xpath,$radar,$payant,$touristique,$typeVille,$typeRoute);

  }
  else{
    // print_r(AetoileTemp($V0,$V1,distance($V0,$V1),$dom,$xpath,$radar,$payant,$touristique,$typeVille,$typeRoute));
    $a[2][]=AetoileTemp($V0,$V1,distance($V0,$V1),$dom,$xpath,$radar,$payant,$touristique,$typeVille,$typeRoute);

  }
   $_SESSION['result']=$a;

   // if(isset($_POST['resultchemin'])){
   //   $i=$_POST['resultchemin'];
   //   $_SESSION['cheminuse']=$a[$i];
   //   $_SESSION['fois']=0;
   // }

   header("refresh:0;url=verifier.php");
   print_r($a);



	//echo cout($V9,$V7,$dom,$xpath)+cout($V7,$V6,$dom,$xpath)+cout($V6,$V4,$dom,$xpath);


	function successeurs($n,$dom,$xpath,$typeVille){
		$successeur=array();
		$query1="//reseau/route/troncon[ville1='".$n->getElementsByTagName('nom')[0]->nodeValue."']";
		$lesTroncon1=$xpath->query($query1);
		foreach($lesTroncon1 as $s){
			array_push($successeur,$s->getElementsByTagName('ville2')[0]->nodeValue);
		}
		$query2="//reseau/route/troncon[ville2='".$n->getElementsByTagName('nom')[0]->nodeValue."']";
		$lesTroncon2=$xpath->query($query2);
		foreach($lesTroncon2 as $s){
			array_push($successeur,$s->getElementsByTagName('ville1')[0]->nodeValue);
		}
		$successeur=array_unique($successeur);
		foreach ($successeur as $s){
			$query="//reseau/ville[nom='".$s."']";
			$ville=$xpath->query($query)[0];
			if ((!$typeVille[0] and $ville->getElementsByTagName('type')[0]->nodeValue=='petite')or(!$typeVille[1] and $ville->getElementsByTagName('type')[0]->nodeValue=='moyenne')or(!$typeVille[2] and $ville->getElementsByTagName('type')[0]->nodeValue=='grande')){
				unset($s);
			}
		}
		return $successeur;
	}

	function Aetoile($depart,$destination,$h,$dom,$xpath,$radar,$payant,$touristique,$typeVille,$typeRoute)
	{
		$dejaDev=array();
		$g=array($depart->getElementsByTagName('nom')[0]->nodeValue=>0);
		$f=array($depart->getElementsByTagName('nom')[0]->nodeValue=>0);
		$f[$depart->getElementsByTagName('nom')[0]->nodeValue]=$h;
		$frontiere=array($depart->getElementsByTagName('nom')[0]->nodeValue=>$f[$depart->getElementsByTagName('nom')[0]->nodeValue]);
		$pere=array();
		while($frontiere!=[]){
			$x=choixFMin($frontiere);
			/*print_r($frontiere);
			echo '<br>';
			echo $x;
			echo '<br>';*/
			$query="//reseau/ville[nom='".$x."']";
			$n=$xpath->query($query)[0];
			if($n->getElementsByTagName('nom')[0]->nodeValue==$destination->getElementsByTagName('nom')[0]->nodeValue)
      {return constuireSolution($n->getElementsByTagName('nom')[0]->nodeValue,$pere,$dom,$xpath,$typeRoute,$radar,$payant,$touristique,true);}
			else{
				unset($frontiere[$n->getElementsByTagName('nom')[0]->nodeValue]);
				array_push($dejaDev,$n->getElementsByTagName('nom')[0]->nodeValue);
				foreach (successeurs($n,$dom,$xpath,$typeVille) as $s){
					$query="//reseau/ville[nom='".$s."']";
					$s=$xpath->query($query)[0];
					if(! in_array($s->getElementsByTagName('nom')[0]->nodeValue,$dejaDev) and ! array_key_exists($s->getElementsByTagName('nom')[0]->nodeValue,$frontiere)){
						$pere[$s->getElementsByTagName('nom')[0]->nodeValue]=$n->getElementsByTagName('nom')[0]->nodeValue;
						$g[$s->getElementsByTagName('nom')[0]->nodeValue]=$g[$n->getElementsByTagName('nom')[0]->nodeValue]+cout($n,$s,$dom,$xpath,$typeRoute,$radar,$payant,$touristique)[0];
						$f[$s->getElementsByTagName('nom')[0]->nodeValue]=$g[$s->getElementsByTagName('nom')[0]->nodeValue]+distance($s,$destination);
						$frontiere[$s->getElementsByTagName('nom')[0]->nodeValue]=$f[$s->getElementsByTagName('nom')[0]->nodeValue];
					}
					else if($g[$s->getElementsByTagName('nom')[0]->nodeValue]>$g[$n->getElementsByTagName('nom')[0]->nodeValue]+cout($n,$s,$dom,$xpath,$typeRoute,$radar,$payant,$touristique)[0]){
						$pere[$s->getElementsByTagName('nom')[0]->nodeValue]=$n->getElementsByTagName('nom')[0]->nodeValue;
						$g[$s->getElementsByTagName('nom')[0]->nodeValue]=$g[$n->getElementsByTagName('nom')[0]->nodeValue]+cout($n,$s,$dom,$xpath,$typeRoute,$radar,$payant,$touristique)[0];
						$f[$s->getElementsByTagName('nom')[0]->nodeValue]=$g[$s->getElementsByTagName('nom')[0]->nodeValue]+distance($s,$destination);
						$frontiere[$s->getElementsByTagName('nom')[0]->nodeValue]=$f[$s->getElementsByTagName('nom')[0]->nodeValue];
					}
				}
			}
		}
		return null;
	}

	function AetoileTemp($depart, $destination, $h,$dom,$xpath,$radar,$payant,$touristique,$typeVille,$typeRoute){
		$dejaDev=array();
		$g=array($depart->getElementsByTagName('nom')[0]->nodeValue=>0);
		$f=array($depart->getElementsByTagName('nom')[0]->nodeValue=>0);
		$f[$depart->getElementsByTagName('nom')[0]->nodeValue]=$h;
		$frontiere=array($depart->getElementsByTagName('nom')[0]->nodeValue=>$f[$depart->getElementsByTagName('nom')[0]->nodeValue]);
		$pere=array();
		while($frontiere!=[]){
			$x=choixFMin($frontiere);
			/*print_r($frontiere);
			echo '<br>';
			echo $x;
			echo '<br>';*/
			$query="//reseau/ville[nom='".$x."']";
			$n=$xpath->query($query)[0];
			if($n->getElementsByTagName('nom')[0]->nodeValue==$destination->getElementsByTagName('nom')[0]->nodeValue){return constuireSolution($n->getElementsByTagName('nom')[0]->nodeValue,$pere,$dom,$xpath,$typeRoute,$radar,$payant,$touristique,false);}
			else{
				unset($frontiere[$n->getElementsByTagName('nom')[0]->nodeValue]);
				array_push($dejaDev,$n->getElementsByTagName('nom')[0]->nodeValue);
				foreach (successeurs($n,$dom,$xpath,$typeVille) as $s){
					$query="//reseau/ville[nom='".$s."']";
					$s=$xpath->query($query)[0];
					if(! in_array($s->getElementsByTagName('nom')[0]->nodeValue,$dejaDev) and ! array_key_exists($s->getElementsByTagName('nom')[0]->nodeValue,$frontiere)){
						$pere[$s->getElementsByTagName('nom')[0]->nodeValue]=$n->getElementsByTagName('nom')[0]->nodeValue;
						$g[$s->getElementsByTagName('nom')[0]->nodeValue]=$g[$n->getElementsByTagName('nom')[0]->nodeValue]+temp($n,$s,$dom,$xpath,$typeRoute,$radar,$payant,$touristique)[0];
						$f[$s->getElementsByTagName('nom')[0]->nodeValue]=$g[$s->getElementsByTagName('nom')[0]->nodeValue]+distanceTemp($s,$destination);
						$frontiere[$s->getElementsByTagName('nom')[0]->nodeValue]=$f[$s->getElementsByTagName('nom')[0]->nodeValue];
					}
					else if($g[$s->getElementsByTagName('nom')[0]->nodeValue]>$g[$n->getElementsByTagName('nom')[0]->nodeValue]+temp($n,$s,$dom,$xpath,$typeRoute,$radar,$payant,$touristique)[0]){
						$pere[$s->getElementsByTagName('nom')[0]->nodeValue]=$n->getElementsByTagName('nom')[0]->nodeValue;
						$g[$s->getElementsByTagName('nom')[0]->nodeValue]=$g[$n->getElementsByTagName('nom')[0]->nodeValue]+temp($n,$s,$dom,$xpath,$typeRoute,$radar,$payant,$touristique)[0];
						$f[$s->getElementsByTagName('nom')[0]->nodeValue]=$g[$s->getElementsByTagName('nom')[0]->nodeValue]+distanceTemp($s,$destination);
						$frontiere[$s->getElementsByTagName('nom')[0]->nodeValue]=$f[$s->getElementsByTagName('nom')[0]->nodeValue];
					}
				}
			}
		}
		return null;
	}

	function cout($v1,$v2,$dom,$xpath,$typeRoute,$radar,$payant,$touristique){
		$lescouts=array();
		$route='nonTrouve';
		$cout=9999;
		$temp=9999;
		$query1="//reseau/route/troncon[ville1='".$v1->getElementsByTagName('nom')[0]->nodeValue."'][ville2='".$v2->getElementsByTagName('nom')[0]->nodeValue."']|//reseau/route/troncon[ville2='".$v1->getElementsByTagName('nom')[0]->nodeValue."'][ville1='".$v2->getElementsByTagName('nom')[0]->nodeValue."']";
		$lesTroncon1=$xpath->query($query1);
		foreach ($lesTroncon1 as $troncon){
			if ((!$radar and $troncon->getElementsByTagName('radar')[0]->nodeValue=='oui')or(!$payant and $troncon->getElementsByTagName('payant')[0]->nodeValue=='oui')or(!$touristique and $troncon->getElementsByTagName('touristique')[0]->nodeValue=='oui')or(!$typeRoute[0] and $troncon->parentNode->getElementsByTagName('type')[0]->nodeValue=='autoroute')or(!$typeRoute[1] and $troncon->parentNode->getElementsByTagName('type')[0]->nodeValue=='nationale')or(!$typeRoute[2] and $troncon->parentNode->getElementsByTagName('type')[0]->nodeValue=='departementale')or(!$typeRoute[0] and $troncon->parentNode->getElementsByTagName('type')[0]->nodeValue=='chemin de campagne')){
				unset($s);
			}
		}
		foreach($lesTroncon1 as $troncon){
			$x=$troncon->getElementsByTagName('longueur')[0]->nodeValue;
			if($x<$cout){
				$cout=$x;
				$route=$troncon->parentNode->getElementsByTagName('nom')[0]->nodeValue;
				$temp=$troncon->getElementsByTagName('longueur')[0]->nodeValue/$troncon->getElementsByTagName('vitesse')[0]->nodeValue;
			}
		}
		return [$cout,$route,$temp];
	}

	function temp($v1,$v2,$dom,$xpath,$typeRoute,$radar,$payant,$touristique){
		$lescouts=array();
		$route='nonTrouve';
		$temp=9999;
		$cout=9999;
		$query1="//reseau/route/troncon[ville1='".$v1->getElementsByTagName('nom')[0]->nodeValue."'][ville2='".$v2->getElementsByTagName('nom')[0]->nodeValue."']|//reseau/route/troncon[ville2='".$v1->getElementsByTagName('nom')[0]->nodeValue."'][ville1='".$v2->getElementsByTagName('nom')[0]->nodeValue."']";
		$lesTroncon1=$xpath->query($query1);
		foreach ($lesTroncon1 as $troncon){
			if ((!$radar and $troncon->getElementsByTagName('radar')[0]->nodeValue=='oui')or(!$payant and $troncon->getElementsByTagName('payant')[0]->nodeValue=='oui')or(!$touristique and $troncon->getElementsByTagName('touristique')[0]->nodeValue=='oui')or(!$typeRoute[0] and $troncon->parentNode->getElementsByTagName('type')[0]->nodeValue=='autoroute')or(!$typeRoute[1] and $troncon->parentNode->getElementsByTagName('type')[0]->nodeValue=='nationale')or(!$typeRoute[2] and $troncon->parentNode->getElementsByTagName('type')[0]->nodeValue=='departementale')or(!$typeRoute[0] and $troncon->parentNode->getElementsByTagName('type')[0]->nodeValue=='chemin de campagne')){
				unset($s);
			}
		}
		foreach($lesTroncon1 as $troncon){
			$x=$troncon->getElementsByTagName('longueur')[0]->nodeValue/$troncon->getElementsByTagName('vitesse')[0]->nodeValue;
			if($x<$temp){
				$temp=$x;
				$route=$troncon->parentNode->getElementsByTagName('nom')[0]->nodeValue;
				$cout=$troncon->getElementsByTagName('longueur')[0]->nodeValue;
			}
		}
		return [$temp,$route,$cout];
	}

	function distance($v1,$v2){
		return sqrt(pow($v1->getElementsByTagName('coordonnees')[0]->getElementsByTagName('latitude')[0]->nodeValue-$v2->getElementsByTagName('coordonnees')[0]->getElementsByTagName('latitude')[0]->nodeValue,2)+pow($v1->getElementsByTagName('coordonnees')[0]->getElementsByTagName('longitude')[0]->nodeValue-$v2->getElementsByTagName('coordonnees')[0]->getElementsByTagName('longitude')[0]->nodeValue,2))*100;
	}

	function distanceTemp($v1,$v2){
		return sqrt(pow($v1->getElementsByTagName('coordonnees')[0]->getElementsByTagName('latitude')[0]->nodeValue-$v2->getElementsByTagName('coordonnees')[0]->getElementsByTagName('latitude')[0]->nodeValue,2)+pow($v1->getElementsByTagName('coordonnees')[0]->getElementsByTagName('longitude')[0]->nodeValue-$v2->getElementsByTagName('coordonnees')[0]->getElementsByTagName('longitude')[0]->nodeValue,2));
	}

	function choixFMin($liste){
		reset($liste);
		asort($liste);
		return key($liste);
	}
	function constuireSolution($n,$pere,$dom,$xpath,$typeRoute,$radar,$payant,$touristique,$long){

		$route=array();
		$longueur=0;
		$temp=0;
		$x=$n;
		$chemin=array($x);
		while(array_key_exists($x, $pere)){
			array_unshift($chemin,$pere[$x]);

			$temp+=temp($xpath->query("//reseau/ville[nom='".$x."']")[0],$xpath->query("//reseau/ville[nom='".$pere[$x]."']")[0],$dom,$xpath,$typeRoute,$radar,$payant,$touristique)[0];
			if($long){
				array_unshift($route,cout($xpath->query("//reseau/ville[nom='".$x."']")[0],$xpath->query("//reseau/ville[nom='".$pere[$x]."']")[0],$dom,$xpath,$typeRoute,$radar,$payant,$touristique)[1]);
				$longueur+=cout($xpath->query("//reseau/ville[nom='".$x."']")[0],$xpath->query("//reseau/ville[nom='".$pere[$x]."']")[0],$dom,$xpath,$typeRoute,$radar,$payant,$touristique)[0];
				$temp+=cout($xpath->query("//reseau/ville[nom='".$x."']")[0],$xpath->query("//reseau/ville[nom='".$pere[$x]."']")[0],$dom,$xpath,$typeRoute,$radar,$payant,$touristique)[2];
			}
			else{
				array_unshift($route,temp($xpath->query("//reseau/ville[nom='".$x."']")[0],$xpath->query("//reseau/ville[nom='".$pere[$x]."']")[0],$dom,$xpath,$typeRoute,$radar,$payant,$touristique)[1]);
				$longueur+=temp($xpath->query("//reseau/ville[nom='".$x."']")[0],$xpath->query("//reseau/ville[nom='".$pere[$x]."']")[0],$dom,$xpath,$typeRoute,$radar,$payant,$touristique)[2];
				$temp+=temp($xpath->query("//reseau/ville[nom='".$x."']")[0],$xpath->query("//reseau/ville[nom='".$pere[$x]."']")[0],$dom,$xpath,$typeRoute,$radar,$payant,$touristique)[0];
			}
			$x=$pere[$x];
		}
		return [$chemin,$longueur,$temp,$route];
	}

//经过城市，type ville，速度排序，雷达，touristique
//typeville petite moyenne grande
//typeRoute autoroute,nationale,departementale,chemin de campagne
?>
