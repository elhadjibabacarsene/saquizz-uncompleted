$("#lien-menu-authentification a").click(function (e) {
    e.preventDefault();
    alert("lien cliquer");
    let page = $(this).attr("href");
    loadData(page,"frontend","#contenu");
    //return false;
});
    


function reloadScript(idScript,link) {
    $(idScript).remove();
    $.getScript(link, function() {
      $('script:last').attr('id', idScript);
    });
  }

function afficher(data,target) {
    $(target).fadeOut(200, () => {
        $(target).empty();
        $(target).append(data);
        $(target).fadeIn(200);
    });

}

function loadData(page, directory,target) {
    $(target).fadeOut(200, () => {
        $(target).empty();
        $(target).load(`views/${directory}/${page}.view.php`,function(response,status,detail){
            if(status === 'error'){
                alert("Erreur lors du chargement de données");
            }
        })
        $(target).fadeIn(200);
    });
}


