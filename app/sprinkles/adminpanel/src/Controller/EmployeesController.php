<?php

namespace UserFrosting\Sprinkle\AdminPanel\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\NotFoundException;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Sprinkle\Core\Facades\Debug; //For Debugging
use Illuminate\Database\Capsule\Manager as Capsule; //For DB safety
use UserFrosting\Sprinkle\AdminPanel\Database\Models\Employee;

class EmployeesController extends SimpleController
{
    public function pageList(Request $request, Response $response, $args)
    {

        $employees = Employee::all();

        return $this->ci->view->render($response, 'pages/employees.html.twig', [
            'employees' => $employees
        ]);
    }

    /**
     * Renders the modal form for creating a new user.
     *
     * This does NOT render a complete page.  Instead, it renders the HTML for the modal, which can be embedded in other pages.
     * If the currently logged-in user has permission to modify user group membership, then the group toggle will be displayed.
     * Otherwise, the user will be added to the default group and receive the default roles automatically.
     *
     * This page requires authentication.
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     *
     * @throws ForbiddenException If user is not authozied to access page
     */
    public function getModalCreate(Request $request, Response $response, array $args)
    {
        return $this->ci->view->render($response, 'modals/employee.html.twig');
    }

    public function getModalEdit(Request $request, Response $response, array $args)
    {
        // GET parameters
        $params = $request->getQueryParams();
        $id = $params['id'];
        $firstname = $params['firstname'];
        $lastname = $params['lastname'];
        $email = $params['email'];
        $phone = $params['phone'];
        $company = $params['company'];


        return $this->ci->view->render($response, 'modals/edit-employee.html.twig', [
            'id'        => $id,
            'firstname'      => $firstname,
            'lastname'      => $lastname,
            'email'     => $email,
            'phone'     => $phone,
            'company'     => $company,
        ]);
    }

    public function getModalConfirmDelete(Request $request, Response $response, array $args)
    {
        // GET parameters
        $params = $request->getQueryParams();
        $id = $params['id'];
        $name = $params['name'];

        return $this->ci->view->render($response, 'modals/confirm-delete-employee.html.twig', [
            'id'    => $id,
            'name'  => $name
        ]);
    }

    public function registerEmployee(Request $request, Response $response, array $args)
    {
        $ms = $this->ci->alerts;

        $params = $request->getParsedBody(); //Form Data
        $firstname = $params['firstname'];
        $lastname = $params['lastname'];
        $email = $params['email'];
        $phone = $params['phone'];
        $company = $params['company'];

        //Function for checking image size


        //Get Image Name and save to local storage

        //Create new company
        $employee = new Employee([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $employee_email,
            'phone' => $phone,
            'company' => $company
        ]);
        $employee->save();

        $ms->addMessage('success', 'Employee Added Successfully');

        return $response->withJson([], 200);
    }

    public function updateEmployee(Request $request, Response $response, array $args)
    {
        $ms = $this->ci->alerts;

        $params = $request->getParsedBody(); //Form Data

        $employee_id = $params['id'];
        $employee_firstname = $params['firstname'];
        $employee_lastname = $params['lastname'];
        $employee_email = $params['email'];
        $employee_company = $params['company'];

        $update_data = [
            'firstname'      => $employee_firstname,
            'lastname'      => $employee_lastname,
            'email'     => $employee_email,
            'phone'     => $employee_phone,
            'company'   => $employee_company
        ];

        //Function for checking image size and saving to local system

        //Get Image Name and save to local storage

        $employee = Employee::where('id', $employee_id)->update($update_data);

        $ms->addMessage('success', "Emploee: $emploee_name Has Been Updated Successfully");

        return $response->withJson([], 200);
    }

    public function deleteEmployee(Request $request, Response $response, array $args)
    {
        $ms = $this->ci->alerts;

        $params = $request->getParsedBody();
        $employee_id = $params['id'];
        $employee_firstname = $params['firstname'];

        $employee = Employee::where('id', $employee_id)->first();

        // Begin transaction - DB will be rolled back if an exception occurs
        Capsule::transaction(function () use ($employee) {
            $employee->delete();
            unset($employee);
        });

        $ms->addMessage('success', "Employee: $employee_name Has Been Deleted Successfully");

        return $response->withJson([], 200);
    }
}
