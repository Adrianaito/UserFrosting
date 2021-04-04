/**
 * This script depends on widgets/companies.js, uf-table.js, moment.js, handlebars-helpers.js
 *
 * Target page: /companies
 */

 $(document).ready(function() {
    // Bind creation button
    bindCompanyCreationButton($("#widget-companies"));

    bindCompanyDeleteButtons($(".widget-companies-delete"));

    bindCompanyEditButtons($(".widget-companies-edit"));
});
