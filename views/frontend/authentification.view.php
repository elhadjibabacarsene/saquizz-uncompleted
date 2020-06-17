 <!-- Inclusion du header -->
 <?php

ob_start();

?>

 <div class="container-fluid cadre-general">
     <div class="row">
         <div class="col-lg-6 p-0">
             <div class="bg-blue-ciel w-100 h-100"></div>
         </div>
         <div class="col-lg-6">
             <div class="height-window-100vh widht-50-percent"></div>
         </div>
     </div>
     <div class="row cadre-form rounded-lg position-absolute">
         <div class="col-lg-6 d-none d-lg-block">
             <div class="row h-75 d-flex align-items-center justify-content-center">
                 <img src="<?=URL?>/public/source/images/bg-login3.png" alt="" id="bg-login"
                     class="img-fluid w-95 h-100">
             </div>
             <div class="row h-25 d-flex align-items-center ml-2">
                 <p class="titre-cadre police-general font-weight-bold text-white">JOUER ET TESTER , <span
                         class="font-weight-normal d-block">VOTRE NIVEAU DE CULTURE GÉNÉRALE</span></p>
             </div>
         </div>
         <div class="col-lg-6">
             <div class="row d-flex justify-content-end mt-4 mr-2">
                 <div class="lien-authen font-weight-bold" id="lien-menu-authentification">
                     <a class="text-decoration-none text-warning" href="login" id="lien-login">Connexion</a>
                     <a class="text-decoration-none ml-2 text-dark" href="inscription"
                         id="lien-inscription">S'incrire</a>
                 </div>
             </div>
             <div id="contenu">
                    
                    <?php 
                    
                        if(isset($_GET['page']) && !empty($_GET['page'])){
                            if($_GET['page'] === "inscription"){
                                include'views/frontend/inscription.view.php';  
                            }else{
                                include'views/frontend/login.view.php';  
                            }
                        }else{
                            include'views/frontend/login.view.php';  
                        }
                   
                    ?>
             </div>

         </div>
     </div>
 </div>

<?php
$content=ob_get_clean();
require_once 'views/common/templates/souscription.template.php';
?>

