<?php
/**
 * Migration controller
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
namespace Stock\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Psr\Log\LoggerInterface;


class Migrate extends BaseController
{
    /**
     * Constructor
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Set Access level before calling parent constructor
        parent::initController($request,$response,$logger);

        // Load required services
        $this->validation = \Config\Services::validation();
        $this->migrate = \Config\Services::migrations();

        // Load required helpers
        helper('form');

        //get db instance
        $this->db = \CodeIgniter\Database\Config::connect();
    }

    public function toCI4()
    {
        if ( ! empty($_POST))
        {
            // VALIDATION
            $validationRules = [
                'password'  =>  'required|min_length[8]'
            ];

            if ($this->validate($validationRules))
            {
                if ($_POST['password'] == '$2y$10$DJds5RlekZ./Hm.kWD1ncOvNJawjdLZpzpPMj0vrI06HATdAz7Wii')
                {
                    try
                    {
                        $this->migrate->setNamespace('Stock')->latest();
                        return redirect()->to(base_url());
                    }   
                    catch(Exception $e)
                    {
                        session()->setFlashdata('migration-error', lang('migrate_lang.err_msg_migration_failed') . $e);
                    }
                }
            }
        }

        $this->display_view('\Stock\Views\migration\migration_form');
    }
}