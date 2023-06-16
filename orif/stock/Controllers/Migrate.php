<?php
/**
 * Controller for database migration.
 * This controller will try to delete itself after migration is done. If this does not work it is strongly recommended to manually delete it.
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

    public function index()
    {
        // Display migration form
        $this->display_view('\Stock\Views\migration\migration_form');
    }

    public function toLatest()
    {
        if (!empty($_POST))
        {
            // Check the given password before doing the migration
            $validationRules = [
                'password'  =>  'required|min_length[10]'
            ];

            if ($this->validate($validationRules))
            {
                if ($_POST['password'] == 'uzdSb8U8ZUD5h24')
                {
                    try
                    {
                        // Migrate to latest
                        $this->migrate->setNamespace('Stock')->latest();

                        // Delete migration files
                        unlink(ROOTPATH.'orif/stock/Views/migration/migration_form.php');
                        rmdir(ROOTPATH.'orif/stock/Views/migration');
                        unlink(ROOTPATH.'orif/stock/Controllers/Migrate.php');

                        // Go back to homepage
                        return redirect()->to(base_url());
                    }
                    catch(Exception $e)
                    {
                        // Display migration form with error message
                        session()->setFlashdata('migration-error', lang('migrate_lang.err_msg_migration_failed') . $e->getMessage());
                        return $this->display_view('\Stock\Views\migration\migration_form');
                    }
                }
            }
        }

        // Display migration form
        return $this->display_view('\Stock\Views\migration\migration_form');
    }
}