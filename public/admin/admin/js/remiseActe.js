$(document).ready(function () {
//alert("vff")
    var $collectionHolder;
    var $addTagButton = $('.add_acte');

    $(document).ready(function () {
        $collectionHolder = $('#acte');
        /*$collectionHolder.append($addTagButton);*/
        $collectionHolder.data('index', $collectionHolder.find('.container').length)
        $collectionHolder.find('.container').each(function () {
            addRemoveButton($(this));
        })
        addForm();
        $('.add_acte').hide()
        /*  $('.vendeur').hide()*/
        /*     $addTagButton.click(function (e) {

                 //alert("jhghghg")
                 e.preventDefault();
                 addForm();
                 $(this).hide()
                 // $('select').select2();
             })*/

    })

    function addForm() {
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');
        var newForm = prototype;
        newForm = newForm.replace(/__name__/g, index);
        $collectionHolder.data('index', index + 1);

        var $card = $('<span class="container col-md-12"></span>')
        /*  var $cardbody = $('<div class="row"></div>').append(newForm);*/
        console.log(index)
        if (index <1){
            $card.append(newForm);
        }


        addRemoveButton($card);
        $collectionHolder.children("input[type='hidden']:first").before($card)
        $collectionHolder.find('.after').before($card);

    }

    function addRemoveButton($card) {

        var $removeButton = $('<a href="#" class="btn btn-danger supprimer" style="margin-left: -16px" data-card-tool="remove" data-toggle="tooltip"\n' +
            '           data-placement="top" title="" data-original-title="Remove Card"><i class="fe fe-trash-2 icon-nm"></i> </a>');
        /*var $cardFooter = $('<div class="modal-footer"></div>').append($removeButton);*/

        $removeButton.click(function (e) {
            console.log($(e.target).parent('.container'));

            $(e.target).parents('.container').slideUp(1000, function () {
                $(this).remove();

            });

        })

        $card.find(".supprimer").append($removeButton);
    }
    // $card.find(".supprimer").append($removeButton);

});