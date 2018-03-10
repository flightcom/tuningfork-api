$(function(){
    // Simply resets the datatable actions to ensure there are no conflicts
    resetDatatableActions = () => {
        $('.datatable-actions').removeClass('hide');
        $('.datatable-delete-confirmation:not(.hide)').addClass('hide');
    };

    // On delete, we want to ask the user for delete confirmation
    $('.datatable-delete').on('click', (e) => {
        resetDatatableActions();
        $(e.currentTarget).parent().toggleClass('hide');
        $(e.currentTarget).parent().parent().find('.datatable-delete-confirmation').toggleClass('hide');
    });

    // On cancel delete resource
    $('.datatable-cancel').on('click', (e) => {
        if ($(e.currentTarget).hasClass('edit-cancel')) {
            resetDatatableActions();

            $(e.currentTarget).toggleClass('hide');
            $(e.currentTarget).parent().find('.datatable-edit').toggleClass('hide')
            $(e.currentTarget).parent().find('.datatable-delete').toggleClass('hide');
            $(e.currentTarget).parent().find('.datatable-status').toggleClass('hide');
            $(e.currentTarget).parent().parent().parent().next('tr.row-details').children().children().toggleClass('visible');
        } else {
            resetDatatableActions();
        }
    });

    // Per page form simply adds a perPage url param and gets the new data
    $('#per-page-selector').on('change', (e) => {
        $('#per-page-form').submit();
    });

    // Just to make image uploads prettier
    $('.file-input-replacement').on('click', (e) => {
        console.log('here');
        $(e.currentTarget).find('input[type=hidden]').click();
    });

    // Ability to preview an image
    $('.file-input-replacement input').on('change', (e) => {
        const reader = new FileReader();

        reader.onload = (onloadEvent) => {
            // get loaded data and render thumbnail.
            $(e.currentTarget).parent().parent().find('img.img-preview')[0].src = onloadEvent.target.result;
        }

        // read the image file as a data URL.
        reader.readAsDataURL($(e.currentTarget)[0].files[0]);
    });

    // As we have system alers on the admin side, we want
    // them to fade out so they don't just sit there
    $('.system-alert').delay(3000).fadeOut(2000);
});
