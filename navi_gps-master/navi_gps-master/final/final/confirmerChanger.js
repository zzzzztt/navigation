function post($url, $prama,$handler) {

    var request;
    if(window.XMLHttpRequest){
        request=new XMLHttpRequest()
    }else{
        request=new ActiveXObject(Miscrosoft.XMLHTTP)
    }
    request.open("POST",$url,true);
    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    request.send($prama);
    request.onreadystatechange=$handler;
}


function confirmerChanger(){ //pour login
	var pwd = document.getElementById("mdp_current").value;
	var pwd1=document.getElementById("password").value;
	var pwd2=document.getElementById("repassword").value;
	var flag=true;
	/*flag pour marquer les conditions: ssi un client qui n'est pas trouver dans le fichier,flag= true
	sinon flag = false;
	*/
	console.log("mdp1:"+pwd1);
	console.log("mdp2:"+pwd2);
	if(pwd===""||pwd1===""||pwd2===""){
		flag=false;
		alert("il faut remplir tous!");
	}
	else if(pwd1!==pwd2){
		flag=false;
		alert("les deux nouveaux mots de passe sont differents!");
		/*hideEnregistrer();*/
		}
	else {
		post('changerMdp.php', "mdp="+pwd1+"&mdp_current="+pwd);
    window.location.href ='login.html';
		//alert("Vous avez bien change le mot de passe");
	}
}
