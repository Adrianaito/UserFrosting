function attachEmployeeForm() {
    $("body").on('renderSuccess.ufModal', function(data) {
        var modal = $(this).ufModal('getModal');
        var form = modal.find('.js-form');

        // Set up any widgets inside the modal
        form.find(".js-select2").select2({
            width: '100%'
        });



        // Set up the form for submission
        form.ufForm().on("submitSuccess.ufForm", function() {
            // Reload page on success
            window.location.reload();
        });
    });
}

//Merge Into One Function Later
function bindEmployeeCreationButton(el) {
    // Link create button
    el.find('.js-employee-create').click(function(e) {
        e.preventDefault();

        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/employees/create",
            msgTarget: $("#alerts-page")
        });

        attachEmployeeForm();
    });
};

function bindEmployeeDeleteButtons(el) {
    //Delete employee button
    el.find('.js-employee-delete').click(function(e) {
        e.preventDefault();

        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/employees/confirm-delete",
            ajaxParams: {
                id: $(this).data('id'),
                name: $(this).data('name')
            },
            msgTarget: $("#alerts-page")
        });

        attachEmployeeForm();
    });
}

function bindEmployeeEditButtons(el){
    //Delete employee button
    el.find('.js-employee-edit').click(function(e) {
        e.preventDefault();

        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/employees/edit",
            ajaxParams: {
                id: $(this).data('id'),
                firstname: $(this).data('firstname'),
                lastname: $(this).data('lastname'),
                email: $(this).data('email'),
                phone: $(this).data('phone'),
                company: $(this).data('company'),
            },
            msgTarget: $("#alerts-page")
        });

        attachEmployeeForm();
    });
}
