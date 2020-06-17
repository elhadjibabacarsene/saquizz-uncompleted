//VALIDATION FORMULAIRE D'INSCRIPTION
const formInscription = document.getElementById("form-inscription");
formValidation(formInscription);

/**
 * fonction qui permet de faire la validation d'un formulaire
 * @param {string} idForm 
 */
function formValidation(form){

    //On récupère tout les inputs du formulaire
    const allInput = getAllInputForm(form);
    const prenom = document.getElementById("prenom");
    const nom = document.getElementById("nom");
    const login = document.getElementById("login");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmerPassword = document.getElementById("confirmerPassword");
    const imageAvatar = document.getElementById("imageAvatar");

    //Si l'envoi du formulaire est fait
    form.addEventListener("submit",(e)=>{
        e.preventDefault();
        //Variable de contôle d'erreur
        tabValidate = [];
        //Contrôler si l'utilisateur a rempli un champ ou non
        getLength(login,5,8);
        //getLength(password,4,20);
        checkPasswordsMatch(password,confirmerPassword);
        checkEmail(email);
        checkRequired(allInput);
        checkFileExtension(imageAvatar);
        //checkFile(imageAvatar);
        //checkFileSize(imageAvatar);




        //On bloque l'envoi du formulaire s'il y'a erreur
        if(tabValidate.indexOf(true) !== -1){
            e.preventDefault();
        }else{
            formInscription.submit();
        }
    });
}


