
//verifier email
var emailRegex = /^\w+@\w+(\.\w+)+$/;
function enregistrerUser(){ //pour enregistrer l'info d'utilisateur
	//alert("ggg");
	//document.getElementById("enregistrer").style.display="none";
	/*
	document.getElementById("login").style.display="block";
	*/
	console.log("进入存储新用户");
	var newname=document.getElementById("username").value;
	var pwd1=document.getElementById("mdp1").value;
	var pwd2=document.getElementById("mdp2").value;
	//document.getElementById("name1").value=newname;
	console.log("newname:"+newname);
	console.log("psw:"+pwd2);

	var flag=true;
	if(newname===""||pwd1===""||pwd2===""){
		flag=false;
		alert("il faut remplir tous!");
	}
	else if(!emailRegex.test(newname)){
		flag = false;
		alert("username n'est pas sous forme email");
	}
	else if(pwd1!==pwd2){
		flag=false;
		alert("les deux password sont pas meme!");
		/*hideEnregistrer();*/
		}
	else {
		alert("Vous avez bien cree un compte");
	}

}
