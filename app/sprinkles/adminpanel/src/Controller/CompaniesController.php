<?php

namespace UserFrosting\Sprinkle\AdminPanel\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\NotFoundException;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Sprinkle\Core\Facades\Debug; //For Debugging
use Illuminate\Database\Capsule\Manager as Capsule; //For DB safety
use UserFrosting\Sprinkle\AdminPanel\Database\Models\Company;

class CompaniesController extends SimpleController
{
    public function pageList(Request $request, Response $response, $args)
    {

        $companies = Company::all();
        $logos = [];
        foreach($companies as $company){
            $logos[$company->id] = "public/".$this->ci->filesystem->disk('public')->url("companies/".$company->logo);
            echo $logos[$company->id];
        }

        return $this->ci->view->render($response, 'pages/companies.html.twig', [
            'companies' => $companies,
            'logos' => $logos
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
        return $this->ci->view->render($response, 'modals/company.html.twig');
    }

    public function getModalEdit(Request $request, Response $response, array $args)
    {
        // GET parameters
        $params = $request->getQueryParams();
        $id = $params['id'];
        $name = $params['name'];
        $email = $params['email'];
        $logo = "public/".$this->ci->filesystem->disk('public')->url("companies/".$params['logo']);
        $website = $params['website'];

        return $this->ci->view->render($response, 'modals/edit-company.html.twig', [
            'id'        => $id,
            'name'      => $name,
            'email'     => $email,
            'logo'      => $logo,
            'website'   => $website,
        ]);
    }

    public function getModalConfirmDelete(Request $request, Response $response, array $args)
    {
        // GET parameters
        $params = $request->getQueryParams();
        $id = $params['id'];
        $name = $params['name'];

        return $this->ci->view->render($response, 'modals/confirm-delete-company.html.twig', [
            'id'    => $id,
            'name'  => $name
        ]);
    }

    public function registerCompany(Request $request, Response $response, array $args)
    {
        $ms = $this->ci->alerts;

        $params = $request->getParsedBody(); //Form Data
        $files = $request->getUploadedFiles(); //Image Data
        $company_name = $params['name'];
        $company_email = $params['email'];
        $company_website = $params['website'];
        $logo = $files['logo'];

        //Function for checking image size


        //Get Image Name and save to local storage
        $extension = pathinfo($logo->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);
        $this->ci->filesystem->disk('public')->put("companies/$filename", $logo->getStream());

        //Create new company
        $company = new Company([
            'name' => $company_name,
            'email' => $company_email,
            'logo' => $filename,
            'website' => $company_website
        ]);
        $company->save();

        $ms->addMessage('success', 'Company Added Successfully');

        return $response->withJson([], 200);
    }

    public function updateCompany(Request $request, Response $response, array $args)
    {
        $ms = $this->ci->alerts;

        $params = $request->getParsedBody(); //Form Data
        $files = $request->getUploadedFiles(); //Image Data
        $company_id = $params['id'];
        $company_name = $params['name'];
        $company_email = $params['email'];
        $company_website = $params['website'];
        $company_logo = $files['logo'];

        $update_data = [
            'name'      => $company_name,
            'email'     => $company_email,
            'website'   => $company_website
        ];

        //Function for checking image size and saving to local system

        //Get Image Name and save to local storage
        $is_image = $company_logo->getClientMediaType();
        if(!empty($is_image)){
            $extension = pathinfo($company_logo->getClientFilename(), PATHINFO_EXTENSION);
            $basename = bin2hex(random_bytes(8));
            $filename = sprintf('%s.%0.8s', $basename, $extension);
            $this->ci->filesystem->disk('public')->put("companies/$filename", $company_logo->getStream());
            $update_data['logo'] = $filename;
        }

        $company = Company::where('id', $company_id)->update($update_data);

        $ms->addMessage('success', "Company: $company_name Has Been Updated Successfully");

        return $response->withJson([], 200);
    }

    public function deleteCompany(Request $request, Response $response, array $args)
    {
        $ms = $this->ci->alerts;

        $params = $request->getParsedBody();
        $company_id = $params['id'];
        $company_name = $params['name'];

        $company = Company::where('id', $company_id)->first();
        Debug::debug($company);

        // Begin transaction - DB will be rolled back if an exception occurs
        Capsule::transaction(function () use ($company) {
            $company->delete();
            unset($company);
        });

        $ms->addMessage('success', "Company: $company_name Has Been Deleted Successfully");

        return $response->withJson([], 200);
    }
}
