
if ($('#nbre').val() === 2 ){
    $('#piece_valider').hide()
}
//
if($('#libelleEtape').val() === "Identification du client"){
    $('.step-22').hide()
    //$('.libelleVide').show()
}else if($('#libelleEtape').val() === "Recueil des pièces" ) {
    $('.step-22').show()
    $('.step-33').hide()
    $('.sw-btn-next').click()
    $('.step-44').hide()
    $('.libelleVide').hide()
    $('.libelleVide2').show()
}
else if($('#libelleEtape').val() === "Signature" ) {

    $('.libelleVide2').hide()
    $('.libelleVide3').show()
    $('.step-44').hide()
    $('.sw-btn-next').click()
    $('.sw-btn-next').click()
    $('#piece_valider').hide()
}
else if($('#libelleEtape').val() === "Enregistrement") {
    $('.libelleVide').hide()
    $('.libelleVide2').hide()
    $('.libelleVide3').hide()
    $('.step-44').show()
    $('.sw-btn-next').click()
    $('.sw-btn-next').click()
    $('.sw-btn-next').click()
    $('#signer').hide()
    $('#piece_valider').hide()
}
else if($('#libelleEtape').val() === "Retrait titre de propriété ") {
    $('.libelleVide').hide()
    $('.libelleVide2').hide()
    $('.libelleVide3').hide()
    $('.step-55').show()
    $('.sw-btn-next').click()
    $('.sw-btn-next').click()
    $('.sw-btn-next').click()
    $('#piece_valider').hide()
    $('#signer').hide()
    $('#enr').hide()
}

$('.contenu').hide()
$('#dossier_identifications_1_acheteur').closest('span').find('row').hide()
// $('.add_groupe').click()
/* $('.add_groupe').click(function () {
     $(this).hide()
 })*/
//alert($('#dossier').val())

