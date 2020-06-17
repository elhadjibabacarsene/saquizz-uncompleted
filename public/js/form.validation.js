var tabValidate = [];
/**
 * fonction qui permet de récupérer l'ensemble des input d'un formulaire
 * @param {string} idForm 
 */
function getAllInputForm(form){
    const allInput = form.querySelectorAll("input");
    const inputs = [];
    allInput.forEach(input=>{
        if(input.type != "file"){
            inputs.push(input);
        }
    });
    return inputs;
}

/**
 * fonction qui retourne le small element qui doit contenir le message d'erreur
 * @param {objet} input 
 */
function getSmall(input){
     //On récupère la balise small qui doit afficher l'erreur
     if(input.type === "file"){
        var formControl = input.parentNode.parentNode;
        
    }else{
        var formControl = input.parentNode;
    }
    return formControl.querySelector("small");
}

/**
 * fonction qui permet d'afficher le message d'erreur de l'input
 * @param {objet} input 
 * @param {string} message 
 */
function showError(input,message){
   const small = getSmall(input);
    //Changer la coloration de notre input
    input.classList.add("is-invalid");
    //Afficher l'erreur
    small.innerText = message;
}

function showSuccess(input){
    //On initialise le message d'erreur
    const small = getSmall(input);
    small.innerText = "";
    //Changer la coloration de notre input
    input.classList.remove("is-invalid");
    input.classList.add("is-valid"); 
}

/**
 * fonction qui renvoi l'id de l'input avec la première lettre en majuscule
 * @param {objet} input 
 */
function getFieldName(input){
    //On récupère l'id de l'input
    const idName = input.id;
    //On met la première lettre en majuscule et on le concatène au reste du nom
    return idName.charAt(0).toUpperCase() + idName.slice(1);
}

function getLength(input,min,max){
    if(input.value.length>0){
        if(input.value.length<min){
            showError(input,`${getFieldName(input)} ne doit pas être inférieur à ${min}`);
            tabValidate.push(true);
        }else if(input.value.length>max){
            showError(input,`${getFieldName(input)} ne doit pas être supérieur à ${max}`);
            tabValidate.push(true);
        }else{
            showSuccess(input);
            tabValidate.push(false);
        }
    }
}
/**
 * fonction qui permet de vérifier si l'utilisateur a saisi une information dans l'input
 * @param {objet} input 
 */
function checkRequired(allInput){
    allInput.forEach(input=>{
        if(input.value.trim() === ""){
            tabValidate.push(true);
            showError(input,"Ce champ est obligatoire");
        }else{
            showSuccess(input);
            tabValidate.push(false);
        }    
    })
}

/**
 * fonction qui compare le mot de pass, le mot de pass de confirmation et qui renvoi un message d'erreur
 * @param {objet} password1  
 * @param {objet} password2 
 */
function checkPasswordsMatch(password1,password2){
    if(password1.value.length !==0 && password2.value.length !==0){
        if(password1.value !== password2.value){
            tabValidate.push(true);
            showError(password2,`Les deux mots de pass ne correspondent pas`);
        }else{
            showSuccess(password2);
            tabValidate.push(false);
        }
    }
    
}

/**
 * fonction qui permet de vérifier un email
 * @param {objet} input
 */
function checkEmail(input){
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(re.test(input.value.trim().toLowerCase())){
        showSuccess(input);
        tabValidate.push(false);
    }else{
        showError(input,"L'email n'est pas valide");
        tabValidate.push(true);
    }
}

/**
 * fonction qui permet de vérifier si l'utilisateur à choisi un avatar ou pas
 * @param {objet} input
 */
function checkFile(input){
    //On récupère l'input
    let fileName = $(input).val();
    //On teste la si un fichier existe
    if(fileName.length === 0){
        showError(input,"Vous devez avoir une image d'avatar");
        tabValidate.push(true);
    }
}

/**
 * fonction qui permet de vérifier l'extension du fichier
 * @param input
 */
function checkFileExtension(input) {
    const re = /.+\.(png|jpg|jpeg)$/i;
    if(input.value != ""){
        if (re.test($(input).val())) {
            showSuccess(input);
            tabValidate.push(false);
        } else {
            showError(input, "Seuls les images avec extensions PNG, JPG ou JPEG sont autorisés");
        }
    }
}






