var id_select = $('#dossier').val();
var vendeur = $('.vendeur').val();
var acheteur = $('.acheteur').val();
var lib = $('#libelleEtape');


$('#ident').click(function (event){
    event.preventDefault();
    const btn = $(this);
    $.ajax({
        method: "POST",
        url: "valider",
        data: { "id": id_select},
        dataType:   'json',
        contentType: "application/json",
    })
        .done(function( msg ) {
           //$("form").submit().ajaxSubmit();
           //$('.tt').get(0).click()
            btn.hide();
            lib.val("Recueil des pièces")
            $('.step-22').show()
             $('.sw-btn-next').click()
            $('#piece_valider').hide()
            $('.libelleVide').hide()
});
})

$('#piece_valider').click(function (event){
    event.preventDefault();
    const btn = $(this);
    $.ajax({
        method: "POST",
        url: "valider2",
        data: { id: id_select },
        dataType:   'json',
        contentType: "application/json",
    })
        .done(function( msg ) {
            btn.hide();
            lib.val("Signature")
            $('.step-33').show()
            $('.sw-btn-next').click()
            $('#signer').show()

            $('.libelleVide2').hide()
        });

    /*
        if(lib.val() === "Identification du client"){
             $('.step-22').hide()
             $('.libelleVide').show()
            //$('.sw-btn-next').click()
        }else if(lib.val() === "Recueil des pièces") {
            $('.step-22').show()
            $('.libelleVide').hide()
          // $('.sw-btn-next').click()
        }*/

})


$('#signer').click(function (event){
    event.preventDefault();
    const btn = $(this);
    $.ajax({
        method: "POST",
        url: "valider3",
        data: { id: id_select},
        dataType:   'json',
        contentType: "application/json",
    })
        .done(function( msg ) {
            btn.hide();
            lib.val("Enregistrement")
            $('.step-44').show()
            $('#enr').show()
            $('.sw-btn-next').click()
            $('.libelleVide3').hide()
        });

    /*
        if(lib.val() === "Identification du client"){
             $('.step-22').hide()
             $('.libelleVide').show()
            //$('.sw-btn-next').click()
        }else if(lib.val() === "Recueil des pièces") {
            $('.step-22').show()
            $('.libelleVide').hide()
          // $('.sw-btn-next').click()
        }*/

})


$('#enr').click(function (event){
    event.preventDefault();
    const btn = $(this);
    $.ajax({
        method: "POST",
        url: "valider4",
        data: { id: id_select },
        dataType:   'json',
        contentType: "application/json",
    })
        .done(function( msg ) {
            btn.hide();
            lib.val("Retrait titre de propriété")
            $('.step-55').show()
            $('.sw-btn-next').click()
            $('.libelleVide4').hide()
        });

    /*
        if(lib.val() === "Identification du client"){
             $('.step-22').hide()
             $('.libelleVide').show()
            //$('.sw-btn-next').click()
        }else if(lib.val() === "Recueil des pièces") {
            $('.step-22').show()
            $('.libelleVide').hide()
          // $('.sw-btn-next').click()
        }*/

})