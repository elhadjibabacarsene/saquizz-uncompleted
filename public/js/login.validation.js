//VALIDATION FORMULAIRE D'INSCRIPTION
const formLogin = document.getElementById("form-login");
formValidation(formLogin);

/**
 * fonction qui permet de faire la validation d'un formulaire
 * @param {string} idForm 
 */
function formValidation(form){

    //On récupère tout les inputs du formulaire
    const allInput = getAllInputForm(form);

    //Si l'envoi du formulaire est fait
    form.addEventListener("submit",(e)=>{
        //Variable de contôle d'erreur
        tabValidate = [];
        //Contrôler si l'utilisateur a rempli un champ ou non
        checkRequired(allInput);
        //On bloque l'envoi du formulaire s'il y'a erreur
        if(tabValidate.indexOf(true) !== -1){
            e.preventDefault();
        }else{
            formInscription.submit();
        }
    });
}