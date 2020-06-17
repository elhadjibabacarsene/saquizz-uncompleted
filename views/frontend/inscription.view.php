
<div class="row d-flex align-items-center justify-content-between ml-2 mr-2">
    <div class="">
        <img src="public/source/images/logo-quizzsa.png" alt="" width="50" height="80">
    </div>
</div>
<form method="POST" id="form-inscription" enctype="multipart/form-data" action="">
    <div class="row h-75 mt-3">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="prenom" class="mb-0 color-blue-ciel">Prénom</label>
                <input type="text" class="form-control input-text-login rounded text-secondary" name="prenom"
                    id="prenom" aria-describedby="prenom" placeholder="Entrer votre prénom" value="<?=$arrayData['prenom']?>">
                <small id="prenom" class="form-text text-danger comments"
                    error="prenom"><?=$arrayData['prenomError']?></small>
            </div>
            <div class="form-group">
                <label for="nom" class="mb-0 color-blue-ciel">Nom</label>
                <input type="text" class="form-control input-text-login rounded text-secondary" name="nom" id="nom"
                    aria-describedby="nom" placeholder="Entrer votre nom" value="<?=$arrayData['nom']?>">
                <small id="nom" class="form-text text-danger comments"
                    error="nom"><?=$arrayData['nomError']?></small>
            </div>
            <div class="form-group">
                <label for="login" class="mb-0 color-blue-ciel">Login</label>
                <input type="text" class="form-control input-text-login rounded text-secondary" name="login" id="login"
                    aria-describedby="login" placeholder="Entrer votre login" value="<?=$arrayData['login']?>">
                <small id="login" class="form-text text-danger comments"
                    error="login"><?=$arrayData['loginError']?></small>
            </div>
            <div class="form-group">
                <label for="email" class="mb-0 color-blue-ciel">Email</label>
                <input type="email" class="form-control input-text-login rounded text-secondary" name="email" id="email"
                    aria-describedby="email" placeholder="Entrer votre email" value="<?=$arrayData['email']?>">
                <small id="email-error" class="form-text text-danger comments"
                    error="email"><?=$arrayData['emailError']?></small>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="password" class="mb-0 color-blue-ciel">Password</label>
                <input type="password" class="form-control input-text-login rounded text-secondary" name="password"
                    id="password" aria-describedby="password" placeholder="Entrer votre password"
                    value="<?=$arrayData['password']?>">
                <small id="password" class="form-text text-danger comments"
                    error="password"><?=$arrayData['passwordError']?></small>
            </div>
            <div class="form-group">
                <label for="confirmer-password" class="mb-0 color-blue-ciel">Confirmer Password</label>
                <input type="password" class="form-control input-text-login rounded text-secondary"
                    name="confirmerPassword" id="confirmerPassword" aria-describedby="confirmer_password"
                    placeholder="Confirmer password" value="<?=$arrayData['confirmerPassword']?>">
                <small id="confirmer_passwod" class="form-text text-danger comments"
                    error="confirmerPassword"><?=$arrayData['confirmerPasswordError']?></small>
            </div>
            <div class="form-group d-flex justify-content-center">
                <img src="public/source/images/avatars/avatar-default.png"
                    class="rounded-circle img-fluid border border-dark" alt="votre-photo-ici" width="100" height="100"
                    id="imageAvatarView">
            </div>
            <div class="form-group">
                <label class="custom-file">
                    <input type="file" name="imageAvatar" id="imageAvatar" placeholder="" class="custom-file-input"
                        aria-describedby="fileHelpId">
                    <label class="custom-file-label"
                        for="customFile"><?=(isset($_FILES['imageAvatar']) ? $image : "Choisir")?></label>
                </label>
                <small id="fileHelpId" class="form-text text-danger comments"
                    error="imageAvatar"><?=$arrayData['imageAvatarError']?></small>
            </div>
            <button type="submit" id="btn-login" class="rounded-lg text-white">S'inscrire</button>

        </div>

    </div>
</form>


<script>
    $("#form-inscription").submit(function(e){
            alert("envoi")
            e.preventDefault();
            $(".commments").empty();
            let postdata = $("#form-inscription").serialize();
            alert(postdata);
            $.ajax({
                type:"POST",
                url:"controllers/inscription.controller.php",
                dataType: "json",
                data:postdata
            }).done(function(response){
                console.log(response);
                if(response.isSuccess){
                    alert("success")
                    if(response.isGood){
                        alert("success")
                        location.replace("login");
                    }
                }else{
                    alert("error")
                    $('#prenom + .comments').html(response.prenomError);
                    $('#nom + .comments').html(response.nomError);
                    $('#login + .comments').html(response.loginError);
                    $('#password + .comments').html(response.passwordError);
                    $('#confirmerPassword + .comments').html(response.confirmerPasswordError);
                    $('#email + .comments').html(response.emailError);
                    $('#imageAvatar + .comments').html(response.imageAvatarError);
                }
            }).fail(function(xhr,status,error){
            console.log(xhr);
            console.log(status);
            console.log(error);
        })
        })
</script>

<!-- <script type="text/javascript">
    //let isSuccess = true;
    $(document).ready(function () {

        $("#btn-login").click(function (e) {
            tabValidate = [];
            e.preventDefault();
            //On récupère les objets inputs
            const allInputs = $(":input");
            const prenom = $("#prenom");
            const nom = $("#nom");
            const email = $("#email");
            const login = $("#login");
            const password = $("#password");
            const confirmerPassword = $("#confirmerPassword");
            const imageAvatar = $("#imageAvatar");

            let inputs = [];
            allInputs.each(function(e){
                if($(this).type !== "submit"){
                    inputs.push($(this));
                }
            }) 
            //Validations

            checkLenght(login, "Le login", 4, 15);
            checkLenght(password, "Le mot de pass", 5, 20);
            checkPasswordMatch(password, confirmerPassword);
            checkImageAvatar(imageAvatar);
            checkEmail(email);
            checkRequired(inputs);



            //On récupère les valeurs des inputs
            let form = $("#form-inscription");
            let valPrenom = prenom.val();
            let valNom = nom.val();
            let valLogin = login.val();
            let valEmail = email.val();
            let valPassword = password.val();
            let valConfirmerPassword = confirmerPassword.val();

            let valImageAvatar = "";
            //On récupère le nom de l'image
            $('input[type="file"]').change(function (e) {
                let fileName = e.target.files[0].name;
                valImageAvatar = fileName;
                //alert(valImageAvatar);

                //var action = form.attr("action");
            });

            //On bloque l'envoi du formulaire s'il y'a erreur
            if (tabValidate.indexOf(false) !== -1) {
                alert("Problème survenu lors de l'envoi de données. Réassayer !");
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: "login",
                    data: {
                        prenom: valPrenom,
                        nom: valNom,
                        login: valLogin,
                        email: valEmail,
                        password: valPassword,
                        confirmerPassword: valConfirmerPassword,
                        imageAvatar: valImageAvatar
                    },
                    dataType: "JSON",
                    success: function (data) {
                        if (data === "success") {
                            alert("okkkk");
                        } else {
                            alert("nonnnn");
                        }

                    }
                });
            }

        })
    })
</script> -->