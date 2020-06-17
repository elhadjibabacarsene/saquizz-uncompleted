let tabValidate = [];

function contentFileLoad(div,filename){
    div.load(`views/${filename}`,function(response,statuts,detail){
            if(statuts === "error"){
                alert("Aucune information à afficher")
            }
    })
}



/**
 * fonction qui permet de vérifier si l'utilisateur a saisi une information dans l'input
 * @param {objet} input 
 */
function checkRequired(tabInput){
    tabInput.each(function(i){
        if($(this).attr('type') !== "submit" ){
            if($(this).val() === ""){
                showError($(this),"Ce champ est obligatoire");
                $(this).keyup(function(e){
                    if($(this).val() !== ""){
                        showSuccess($(this));
                    }else{
                        showError($(this),"Ce champ est obligatoire");
                    }
                })
            }
        }
    })
}

function checkLenght(input,nameinput,min,max){
    
        let valInput = input.val();
        if(valInput !== ""){
            if(valInput.length<min){
                showError(input,nameinput + " doit dépasser " + min + " caractères");
            }else if(valInput.length>max){
                showError(input,nameinput + " ne doit pas dépasser " + max + " caractères");
            }else{
                showSuccess(input);
            }
        }
}


function checkImageAvatar(image){
   image.change(function() {

        let val = $(this).val();
        //checkFileName($(this));
        switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
            case 'png': case 'jpg': case 'jpeg':
                showSuccess(image);
                break;
            default:
                $(this).val('');
                showError(image,"Seuls les formats PNG, JPEG OU JPG sont autorisées");
                break;
        }
    });
}


function checkFileName(input){
    let filename = input.files.name;
    alert(filename);

}

function checkPasswordMatch(password1,password2){
    if(password1.val() !== password2.val()){
        showError(password2,"Les deux passwords ne sont pas identiques");
    }else{
        showSuccess(password2);
        
    }
}

function checkEmail(input){
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        //Si le mail est valid avec le regex
        if(re.test($.trim(input.val().toLowerCase())))
        {
            showSuccess(input);
        }else{
            showError(input,'Email is not valid');
        }
}


function getSmallError(input){
    const id = input.attr("id");
    return $("small[error="+id+"]");

}

function showError(input,message){
    input.addClass("is-invalid");
    const small  = getSmallError(input);
    small.text(message);
    tabValidate.push(false);
}
function showSuccess(input){
    $(input).removeClass("is-invalid");
    $(input).addClass("is-valid");
    const small = getSmallError(input);
    small.text("");
    tabValidate.push(true);
}

function showError2(input,message){
    input.addClass("is-invalid");
    const small  = getSmallError(input);
    small.text(message);
}