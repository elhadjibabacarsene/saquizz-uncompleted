
<div class="cadre-logo position-absolute">
    <img src="public/source/images/logo-quizzsa.png" alt="">
</div>
<div id="form-login-div" class="position-absolute">
    <form id="form-login" method="POST" action="">
        <div class="form-group">
            <div class="input-div">
                <label for="login_email" class="mb-0 color-blue-ciel">Email ou login</label>
                <input type="text" class="form-control input-text-login rounded text-secondary" id="loginEmail"
                    placeholder="Email ou login" name="loginEmail" value="<?=$arrayData['loginEmail']?>">
                <small id="helpId" class="form-text text-danger comments"
                    error="loginEmail"><?=$arrayData['loginEmailError']?></small>
            </div>
            <div class="input-div">
                <label for="password" class="mb-0 color-blue-ciel">Mot de pass</label>
                <input type="password" class="form-control input-text-login rounded text-secondary" id="password"
                    placeholder="Password" name="password" value="<?=$arrayData['password']?>">
                <small id="helpId" class="form-text text-danger comments"
                    error="password"><?=$arrayData['passwordError']?></small>
            </div>

        </div>
        <button type="submit" id="btn-login" class="rounded-lg text-white" name="btn_login">Se connecter</button>
    </form>
</div>

<script>


$(document).ready(function(e){
    

    $("#form-login").submit(function (e) {
        e.preventDefault();
        alert("envoi des données");
        
        $('.comments').empty();
        let postdata = $('#form-login').serialize();

        $.ajax({

            type: "POST",
            url: "controllers/login.controller.php",
            dataType: "json",
            data: postdata

        }).done(function(response){
            if(response.isSuccess){
                alert("success");
                console.log(response);
                if(response.isGood){
                    alert("good");
                }
                if(response.redirection !== ""){
                    location.replace(response.redirection);    
                }
            }else{
                $('#loginEmail + .comments').html(response.loginEmailError);
                $('#password + .comments').html(response.passwordError);
            }
        })
        .fail(function(xhr,status,error){
            //console.log(xhr);
        })
        
    });
})



</script>



