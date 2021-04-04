$(document).ready(function() {
    // Bind creation button
    bindEmployeeCreationButton($("#widget-employees"));

    bindEmployeeDeleteButtons($(".widget-employees-delete"));

    bindEmployeeEditButtons($(".widget-employees-edit"));
});
