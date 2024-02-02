<?php

namespace  Stock\Controllers;


/*
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
*/


/**
 * A controller to display and manage items
 *
 * @author      Orif (ViDi)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use PSR\Log\LoggerInterface;
use App\Controllers\BaseController;
use Stock\Models\Entity_model;
use Stock\Models\Inventory_control_model;
use Stock\Models\Item_model;
use Stock\Models\Loan_model;
use Stock\Models\Item_tag_model;
use Stock\Models\Item_condition_model;
use Stock\Models\Item_group_model;
use Stock\Models\Item_tag_link_model;
use Stock\Models\Stocking_place_model;
use Stock\Models\Supplier_model;
use Stock\Models\User_entity_model;
use Stock\Models\Item_common_model;
use User\Models\User_model;
use CodeIgniter\Database\BaseConnection;

class ItemCommon extends BaseController {

    // Properties
    protected $access_level = "*";
    protected Item_model $item_model;
    protected Loan_model $loan_model;
    protected Item_tag_link_model $item_tag_link_model;
    protected Inventory_control_model $inventory_control_model;
    protected Item_tag_model $item_tag_model;
    protected Item_condition_model $item_condition_model;
    protected Item_group_model $item_group_model;
    protected Stocking_place_model $stocking_place_model;
    protected Supplier_model $supplier_model;
    protected User_model $user_model;
    protected Entity_model $entity_model;
    protected User_entity_model $user_entity_model;
    protected Item_common_model $item_common_model;
    protected $config;
    protected BaseConnection $db;

    /**
     * Constructor
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        // Set Access level before calling parent constructor
        // Accessibility reserved to admin users
        $this->access_level = "*";
        parent::initController($request, $response, $logger);

        // Load required helpers
        helper('sort');
        helper('form');
        helper('\Stock\Helpers\MY_date');

        // Load required models 
        $this->item_model = new Item_model();
        $this->loan_model = new Loan_model();
        $this->item_tag_link_model = new Item_tag_link_model();
        $this->inventory_control_model = new Inventory_control_model();
        $this->item_tag_model = new Item_tag_model();
        $this->item_condition_model = new Item_condition_model();
        $this->supplier_model = new Supplier_model();
        $this->item_group_model = new Item_group_model();
        $this->stocking_place_model = new Stocking_place_model();
        $this->entity_model = new Entity_model();
        $this->user_entity_model = new User_entity_model();
        $this->item_common_model = new Item_common_model();
        $this->config = config('\Stock\Config\StockConfig');

        // Initialize db for query builder
        $this->db = \Config\Database::connect();
    }

    /**
     * Display details of one single item
     *
     * @param $id : the item to display
     * @return void
     */
    public function view($id = NULL) {

        if (is_null($id)) {
            // No item selected, display items list
            return redirect()->to(base_url());
        }

        $item_common = $this->item_common_model->where('item_common_id', $id)->first();

        if (!is_null($item_common)) {
            // Store current URL to redirect if user logs in
            $output['after_login_redirect'] = current_url();
 
            $item_common['tags'] = $this->item_common_model->getTags($item_common);
            $item_common['image'] = $this->item_common_model->getImagePath($item_common);
            $item_common['item_group'] = $this->item_common_model->getItemGroup($item_common);
            $item_common['entity'] = $this->entity_model->where('entity_id', $item_common['item_group']['fk_entity_id'])->first();
            
            $output['title'] = $item_common['name'];
            $output['item_common'] = $item_common;
            $output['entity_id'] = $item_common['entity']['entity_id'];

            if (isset($_SESSION['user_id'])) {
                $output['can_modify'] = $this->user_entity_model->check_user_item_common_entity($_SESSION['user_id'], $item_common['item_common_id']);
            }

            $items = $this->item_model->where('item_common_id', $item_common['item_common_id'])->findAll();

            if (count($items) > 0) {
                foreach ($items as $key => $item) {
                    $item['supplier'] = $this->item_model->getSupplier($item);
                    $item['stocking_place'] = $this->item_model->getStockingPlace($item);
                    $item['inventory_number'] = $this->item_model->getInventoryNumber($item);
                    $item['condition'] = $this->item_model->getItemCondition($item);
                    $item['current_loan'] = $this->item_model->getCurrentLoan($item);
                    $item['warranty_status'] = $this->item_model->getWarrantyStatus($item);
                    $item['last_inventory_control'] = $this->item_model->getLastInventoryControl($item);

                    if (!is_null($item['last_inventory_control'])) {
                        $item['last_inventory_control']['controller'] = $this->inventory_control_model->getUser($item['last_inventory_control']['controller_id']);
                    }

                    $items[$key] = $item;
                }

                $output['items'] = $items;

                $this->display_view('Stock\Views\item_common\details', $output);
            } else {
                // No items so we display the page with a concise message
                $this->display_view('Stock\Views\item_common\details', $output);
            }
        } else {
            // $id is not valid, display an error message
            $this->display_view('Stock\Views\errors\application\inexistent_item');
        }
    }

    /**
     * Modify an item common
     *
     * @param $id : the item common to modify
     * @return void
     */
    public function modify($id) {
        // Check if access is allowed
        if (isset($_SESSION['logged_in']) &&
            $_SESSION['logged_in'] == true &&
            isset($_SESSION['user_id']) &&
            $this->user_entity_model->check_user_item_common_entity($_SESSION['user_id'], $id) &&
            $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_registered) 
        {
            $imageId = $id;
            $upload_failed = false;
            $item_common = $this->item_common_model->find($id);

            // If image allready exist, get its id
            if (isset($item_common['image']) && $item_common['image'] !== '') {
                $imageId = explode('_', $item_common['image'])[0];
            }

            // Define image path variables
            $_SESSION['picture_prefix'] = str_pad($imageId, $this->config->inventory_number_chars, "0", STR_PAD_LEFT);
            $temp_image_name = $_SESSION["picture_prefix"].$this->config->image_picture_suffix.$this->config->image_tmp_suffix.$this->config->image_extension;
            $new_image_name = $_SESSION["picture_prefix"].$this->config->image_picture_suffix.$this->config->image_extension;

            // Check if the user cancelled the form
            if (isset($_POST['submitCancel'])) {
                $files = glob($this->config->images_upload_path.$temp_image_name);
                if (count($files)) $tmp_image_file = glob($this->config->images_upload_path.$temp_image_name)[0];
                else $tmp_image_file = false;

                // Check if there is a temporary image file, if yes then delete it
                if ($tmp_image_file != null || $tmp_image_file != false) {
                    unlink($tmp_image_file);
                }

                return redirect()->to(base_url("item_common/view/".$id));
            }

            if (isset($_FILES['linked_file']) && $_FILES['linked_file']['name'] != '') {

                // LINKED FILE UPLOADING
                $upload_path = '../../public/uploads/files/';
                $allowed_types = [
                    'application/pdf', //pdf
                    'application/msword', //doc
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document', //docx
                ];
                $max_size = 2 * 1024 * 1024; //2MB max

                $file = $this->request->getFile('linked_file');

                if (!is_null($file) && $file->isValid() && $file->getSize() <= $max_size && in_array($file->getMimeType(), $allowed_types)) {
                    $file->store($upload_path);
                    $linked_file = $file->getName();
                } else {
                    $upload_failed = true;
                    $output['upload_errors'] = [];
                    // Manually shove in the errors, as the upload library is no longer a thing
                    if (is_null($file) || !$file->isValid()) $data['upload_errors'][] = lang('upload.upload_file_partial');
                    if (!is_null($file) && $file->getSize() > $max_size) $data['upload_errors'][] = lang('upload.upload_file_exceeds_form_limit');
                    if (!is_null($file) && !in_array($file->getMimeType(), $allowed_types)) $data['upload_errors'][] = lang('upload.upload_invalid_filetype');
                }
            }

            if (!is_null($this->request->getVar('btn_submit')) && !$upload_failed) {
                // Turn Temporaty Image into a final one if there is one
                if (file_exists($this->config->images_upload_path.$temp_image_name)) {
                    if (file_exists($this->config->images_upload_path.$new_image_name)) {
                        // If new image name already exists, delete it
                        unlink(ROOTPATH.'public/' . $this->config->images_upload_path . $item_common['image']);
                    }
                    rename($this->config->images_upload_path.$temp_image_name, $this->config->images_upload_path.$new_image_name);
                }

                $itemCommonUpdate = array(
                    'item_common_id' => $id,
                    'name' => $this->request->getPost('item_common_name'),
                    'description' => $this->request->getPost('item_common_description'),
                    'image' => $new_image_name,
                    'linked_file' => isset($linked_file) ? $linked_file : null,
                    'item_group_id' => $this->request->getPost('item_common_group'),
                );

                $this->item_common_model->save($itemCommonUpdate);

                if (count($this->item_common_model->errors()) == 0) {
                    $item_tags_update = $this->request->getPost('item_common_tags');
                    $current_item_tags = $this->item_tag_link_model->where('item_common_id', $id)->findColumn('item_tag_id');

                    if (is_null($item_tags_update)) {
                        $this->item_tag_link_model->where('item_common_id', $id)->delete();
                    } else if (is_null($current_item_tags)) {
                        foreach ($item_tags_update as $item_tag) {
                            $this->item_tag_link_model->insert([
                                'item_tag_id' => $item_tag,
                                'item_common_id' => $id
                            ]);
                        }
                    } else {
                        $new_item_tags = array_diff($item_tags_update, $current_item_tags);

                        if (count($new_item_tags) > 0) {
                            foreach ($new_item_tags as $new_tag) {
                                $this->item_tag_link_model->insert([
                                    'item_tag_id' => $new_tag,
                                    'item_common_id' => $id
                                ]);
                            }
                        }
                    }

                    return redirect()->to(base_url("item_common/view/{$id}"));
                } else {
                    $output['errors'] = $this->item_common_model->errors();
                }
            } else if (!is_null($this->request->getVar('btn_submit_photo'))) {
                $_SESSION['POST'] = $_POST;
                return redirect()->to(base_url("picture/select_picture"));
            }

            $entity_id = $this->item_group_model->where('item_group_id', $item_common['item_group_id'])->findColumn('fk_entity_id');
            $entity = $this->entity_model->where('entity_id', $entity_id)->first();
            $item_groups = $this->item_group_model->where('fk_entity_id', reset($entity_id))->findAll();
            $item_tags = $this->item_tag_model->findAll();
            $item_tag_ids = $this->item_tag_link_model->where('item_common_id', $id)->findColumn('item_tag_id');

            $output['item_common'] = $item_common;
            $output['entity'] = $entity;
            $output['item_groups'] = $this->dropdown($item_groups, 'item_group_id');
            $output['item_tags'] = $this->dropdown($item_tags, 'item_tag_id');
            $output['item_tag_ids'] = $item_tag_ids;
            $output['config'] = config('\Stock\Config\StockConfig');
            $output['title'] = $item_common['name'];

            if (isset($_SESSION['POST'])) {
                foreach ($_SESSION['POST'] as $key => $value) {
                    // If it is a tag
                    if (substr($key, 0, 3) == "tag") {
                        // put it in the output array
                        $tag_link = [];
                        $tag_link['item_tag_id'] = substr($key, 3);
                        $output['item_tag_ids'][] = $tag_link;
                    } else {
                        $output[$key] = $value;
                    }
                }
            }
            unset($_SESSION['POST']);

            $this->display_view('Stock\Views\item_common\form', $output);
        } else {
            // Access not allowed
            return redirect()->to(base_url());
        }
    }

    /**
     * Delete an item
     * ACCESS RESTRICTED FOR ADMINISTRATORS ONLY
     *
     * @param integer $id
     * @return void
     */
    public function delete($id, $action = 0) {
        // Check if this is allowed
        if (isset($_SESSION['logged_in']) &&
            $_SESSION['logged_in'] == true &&
            isset($_SESSION['user_id']) &&
            $this->user_entity_model->check_user_item_common_entity($_SESSION['user_id'], $id) &&
            $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin)
        {
            $item_common = $this->item_common_model->find($id);

            switch($action) {
                case 0: // Display confirmation
                    $output = array(
                        'item_common' => $item_common,
                        'title' => lang('stock_lang.title_delete_item_common')
                    );
                    $this->display_view('Stock\Views\item_common\delete', $output);
                    break;
                case 1: // Delete item_common and related items
                    $items = $this->item_model->where('item_common_id', $id)->findAll();

                    if (count($items) > 0) {
                        foreach ($items as $item) {
                            $this->inventory_control_model->where('item_id', $item['item_id'])->delete();
                            $this->loan_model->where('item_id', $item['item_id'])->delete();

                            $this->item_model->delete($item['item_id']);
                        }
                    }

                    // Delete image file
                    if (!is_null($item_common['image']) && $item_common['image'] != $this->config->item_no_image) {
                        $items_using_imgage = $this->item_common_model->asArray()->where('image', $item_common['image'])->findAll();
                        $path_to_image = ROOTPATH.'public/' . $this->config->images_upload_path . $item_common['image'];
                        $image_file_exists = file_exists($path_to_image);

                        // Change this if soft deleting items is enabled
                        // Check if any other item uses this image
                        if ($image_file_exists && count($items_using_imgage) < 2) {
                            unlink($path_to_image);
                        }
                    }

                    // Delete linked file
                    if (!is_null($item_common['linked_file']) && $item_common['linked_file']) {
                        $items_using_linked_file = $this->item_common_model->asArray()->where('linked_file', $item_common['linked_file'])->findAll();
                        $path_to_file = ROOTPATH.'public/' . $this->config->files_upload_path . $item_common['linked_file'];
                        $linked_file_exists = file_exists($path_to_file);

                        // Change this if soft deleting items is enabled
                        // Check if any other item uses this linked_file
                        if ($linked_file_exists && count($items_using_linked_file) < 2) {
                            unlink($path_to_file);
                        }
                    }

                    $this->item_tag_link_model->where('item_common_id', $id)->delete();

                    $this->item_common_model->delete($id, TRUE);
                    return redirect()->to(base_url());
                default: // Do nothing
                    return redirect()->to("/item_common/view/{$item_common['item_common_id']}");
            }
        } else {
            // Access not allowed
            return redirect()->to(base_url());
        }
    }

    /**
    * Rename images and update the item_common
    * in case of wrong naming convention or 
    * unexisting image
    *
    * @return void
    * @Date used on the 25.01.2024
    */
    public function rename_images() {
        if (!isset($_SESSION['user_access']) || $_SESSION['user_access'] < config('\User\Config\UserConfig')->access_lvl_registered) {
            return redirect()->to(base_url());
        }

        $items = $this->item_common_model->findAll();
        $unchangedImages = [];

        foreach ($items as $i => $item) {
            $pathToImageFolder = 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
            $pathToFile = $pathToImageFolder . $item['image'];

            if (file_exists($pathToFile) && !is_null($item['image'])) {
                $newFilename = sprintf('%04d_picture.png', $item['item_common_id']);

                $key = array_search($newFilename, array_column($items, 'image'));

                if ($key) {
                    array_push($unchangedImages, $items[$i]);
                    continue;
                }

                $newPathToFile = $pathToImageFolder . $newFilename;

                rename($pathToFile, $newPathToFile);

                $this->item_common_model->update($item['item_common_id'], ['image' => $newFilename]);
            } else {
                $this->item_common_model->update($item['item_common_id'], ['image' => NULL]);
            }
        }

        $itemsWithImage = $this->item_common_model->where('image != \'no_image.png\' OR image != NULL')->findAll();

        if (count($unchangedImages) != count($itemsWithImage)) {
            $this->rename_images();
        }

        clearstatcache();

        return redirect()->to(base_url());
    }
}
