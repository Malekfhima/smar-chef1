function affiche_pass(){
    var mot_de_passe=document.getElementById("password");
    var mot_de_passe2=document.getElementById("confirm-password");
    var checked = document.getElementById("show-password").checked;
    if (checked) {
        mot_de_passe.type="text";
        mot_de_passe2.type="text";
    }else{
        mot_de_passe.type="password";
        mot_de_passe2.type="password";
    }
}