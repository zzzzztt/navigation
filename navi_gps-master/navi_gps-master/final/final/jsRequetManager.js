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
    request.onreadystatechange=$handler
}

var emailRegex = /^\w+@\w+(\.\w+)+$/;
/*--Login-------------------------------------------------------------------*/
function data_1_handler($request){

    $request=$request.currentTarget;
    if($request.readyState==4)
    {
        $request.responseText.replace(/\r|\n/ig,"");
        console.log("data_1: "+$request.responseText);
        $new=$request.responseText.replace(/\r|\n/ig,"");
        if($new=="1"){
            alert("vous avez login");
            window.location.href ='homepage.html';
        }else if($new=="0"){
            alert("le nom ou le mot de passe est incorrect !");
            window.location.href ='login.html';
        }
    }

}
function login(){ //pour login
    console.log("进入login");
    var loginname=document.getElementById("username").value;
    var loginpsw=document.getElementById("password").value;
    var flag=true;
    /*flag pour marquer les conditions: ssi un client qui n'est pas trouver dans le fichier,flag= true
    sinon flag = false;
    */
    console.log("Loginname:"+loginname);
    console.log("Loginpsw:"+loginpsw);
    if(loginname===""||loginpsw===""){ //comfirmer tous sont remplis.
        flag=false;
        alert("il faut remplir tous!");
    }
    else if(!emailRegex.test(loginname)){
        flag = false;
        alert("username n'est pas sous forme email");
    }
    else{
        console.log("gggg");
        post('dataManager.php', "protocol=data_1_LoginVerify&email="+loginname+"&pswd="+loginpsw,data_1_handler);

    }
}

/*--Inscription-------------------------------------------------------------------*/
// function data_2_handler($request){
//
//     $request=$request.currentTarget;
//     if($request.readyState==4)
//     {
//         $request.responseText.replace(/\r|\n/ig,"");
//         console.log("data_2: "+$request.responseText);
//         $new=$request.responseText.replace(/\r|\n/ig,"");
//         if($new=="1"){
//             alert('ce comtpe a deja inscript');window.location.href ='inscription.html';
//         }else if($new=="0"){
//             alert("Vous avez bien cree un compte");
//             window.location.href ='homepage.html';
//         }
//         else {
//             alert("on n a pas reussi de creer un compte");
//             window.location.href ='inscription.html';
//         }
//     }
//
// }
function enregistrerUser(){ //pour enregistrer l'info d'utilisateur
    //alert("ggg");
    console.log("进入存储新用户");
    var newname=document.getElementById("username").value;
    var pwd1=document.getElementById("mdp1").value;
    var pwd2=document.getElementById("mdp2").value;
    //document.getElementById("name1").value=newname;
    console.log("newname:"+newname);
    console.log("psw:"+pwd2);
    alert();
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
        alert("reusit");
        post('inscription.php', "username="+newname+"&mdp="+pwd1);
        //alert("vous ave")
        window.location.href ='login.html';
    }
}

/*--Confirmer changer le mot de passe---------------------------------------*/
function data_5_handler($request){

    $request=$request.currentTarget;
    if($request.readyState==4)
    {
        $request.responseText.replace(/\r|\n/ig,"");
        console.log("data_2: "+$request.responseText);
        $new=$request.responseText.replace(/\r|\n/ig,"");
        if($new=="1"){
            alert('Votre mot de passe a bien change');
            window.location.href ='login.html';
        }else {
            alert("Votre mot de passe n'est pas correct");
            window.location.href ='changerMdp.html';
        }
    }

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
        post('dataManager.php', "protocol=data_2_Register&pswd="+pwd+"&pswd1="+pwd1,data_5_handler);
        alert("Vous avez bien change le mot de passe");
    }
}

/*--Envoyer un code aleatoire----------------------------------------------------*/
/*
window.onload = function(){
    var envoyer=document.getElementById('envoyerCode'),
        times=600,
        timer=null;

    send.onclick=function(){
        // commencer a countdown
        timer=setInterval(function(){
            times--;
            if(times<=0){
                send.value="envoyer un code";
                clearInterval(timer);
                times=10;
                send.disabled=false;
            }else{
                send.value="renvoyer apres "+ times+" secondes";
                send.disabled=true;
            }
        },1000)
    }
}

*/
