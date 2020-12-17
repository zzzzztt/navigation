var emailRegex = /^\w+@\w+(\.\w+)+$/;
function login(){ //pour login
	var loginname=document.getElementById("username").value;
	var loginpsw=document.getElementById("password").value;
	var flag=true;
	/*flag pour marquer les conditions: ssi un client qui n'est pas trouver dans le fichier,flag= true
	sinon flag = false;
	*/
	console.log("loginname:"+loginname);
	console.log("loginpsw:"+loginpsw);
	if(loginname===""||loginpsw===""){ //comfirmer tous sont remplis.
		flag=false;
		alert("il faut remplir tous!");
	}
	else if(!emailRegex.test(loginname)){
		flag = false;
		alert("username n'est pas sous forme email");
	}
}