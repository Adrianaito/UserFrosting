/**
 * Set up the form in a modal after being successfully attached to the body.
 */
 function attachCompanyForm() {
    $("body").on('renderSuccess.ufModal', function(data) {
        var modal = $(this).ufModal('getModal');
        var form = modal.find('.js-form');

        // Set up any widgets inside the modal
        form.find(".js-select2").select2({
            width: '100%'
        });

        $("#logo_file").change(function(){
            const logo_check = new Image();
            logo_check.onload = function() {
                if(this.width < 1000 || this.height < 1000){
                    alert('Logo size must be at least 100 x 100');
                    $("#logo_file").val('');
                    $("#logo_create_preview").hide();
                    $("#logo_edit_preview").hide();
                }
            }
            logo_check.src = window.URL.createObjectURL(this.files[0]);
        });

        // Set up the form for submission
        form.ufForm().on("submitSuccess.ufForm", function() {
            // Reload page on success
            window.location.reload();
        });
    });
}

//Merge Into One Function Later
function bindCompanyCreationButton(el) {
    // Link create button
    el.find('.js-company-create').click(function(e) {
        e.preventDefault();

        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/companies/create",
            msgTarget: $("#alerts-page")
        });

        attachCompanyForm();
    });
};

function bindCompanyDeleteButtons(el) {
    //Delete company button
    el.find('.js-company-delete').click(function(e) {
        e.preventDefault();

        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/companies/confirm-delete",
            ajaxParams: {
                id: $(this).data('id'),
                name: $(this).data('name')
            },
            msgTarget: $("#alerts-page")
        });

        attachCompanyForm();
    });
}

function bindCompanyEditButtons(el){
    //Delete company button
    el.find('.js-company-edit').click(function(e) {
        e.preventDefault();

        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/companies/edit",
            ajaxParams: {
                id: $(this).data('id'),
                name: $(this).data('name'),
                email: $(this).data('email'),
                logo: $(this).data('logo'),
                website: $(this).data('website'),
            },
            msgTarget: $("#alerts-page")
        });

        attachCompanyForm();
    });
}
