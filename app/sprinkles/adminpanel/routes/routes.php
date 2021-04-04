<?php

$app->group('/companies', function () {
    $this->get('', 'UserFrosting\Sprinkle\AdminPanel\Controller\CompaniesController:pageList')
         ->setName('companies');

    $this->post('/register_company', 'UserFrosting\Sprinkle\AdminPanel\Controller\CompaniesController:registerCompany');

    $this->delete('/delete_company', 'UserFrosting\Sprinkle\AdminPanel\Controller\CompaniesController:deleteCompany');

    $this->post('/edit_company', 'UserFrosting\Sprinkle\AdminPanel\Controller\CompaniesController:updateCompany');
})->add('authGuard');


$app->group('/modals/companies', function () {
    $this->get('/confirm-delete', 'UserFrosting\Sprinkle\AdminPanel\Controller\CompaniesController:getModalConfirmDelete');

    $this->get('/create', 'UserFrosting\Sprinkle\AdminPanel\Controller\CompaniesController:getModalCreate');

    $this->get('/edit', 'UserFrosting\Sprinkle\AdminPanel\Controller\CompaniesController:getModalEdit');
})->add('authGuard');

$app->group('/employees', function () {
    $this->get('', 'UserFrosting\Sprinkle\AdminPanel\Controller\EmployeesController:pageList')
         ->setName('employees');

    $this->post('/register_employee', 'UserFrosting\Sprinkle\AdminPanel\Controller\EmployeesController:registerEmployee');

    $this->delete('/delete_employee', 'UserFrosting\Sprinkle\AdminPanel\Controller\EmployeesController:deleteEmployee');

    $this->post('/edit_employee', 'UserFrosting\Sprinkle\AdminPanel\Controller\EmployeesController:updateEmployee');
})->add('authGuard');


$app->group('/modals/employees', function () {
    $this->get('/confirm-delete', 'UserFrosting\Sprinkle\AdminPanel\Controller\EmployeesController:getModalConfirmDelete');

    $this->get('/create', 'UserFrosting\Sprinkle\AdminPanel\Controller\EmployeesController:getModalCreate');

    $this->get('/edit', 'UserFrosting\Sprinkle\AdminPanel\Controller\EmployeesController:getModalEdit');
})->add('authGuard');
