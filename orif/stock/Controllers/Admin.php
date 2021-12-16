<?php
/**
 * Admin controller
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
namespace Stock\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Stock\Models\Item_tag_model;
use Stock\Models\Item_tag_link_model;
use Stock\Models\Stocking_place_model;
use Stock\Models\Supplier_model;
use Stock\Models\Item_group_model;
use Stock\Models\Item_model;


class Admin extends BaseController
{
    /**
     * Constructor
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Set Access level before calling parent constructor
        // Accessibility reserved to admin users
        $this->access_level=config('\User\Config\UserConfig')->access_lvl_admin;

        // Set Access level before calling parent constructor
        parent::initController($request,$response,$logger);

        // Load required helpers
        helper('form');

        // Load required services
        $this->validation = \Config\Services::validation();

        // Load required models
        $this->item_tag_model         = new Item_tag_model();
        $this->item_tag_link_model    = new Item_tag_link_model();
        $this->stocking_place_model   = new Stocking_place_model();
        $this->supplier_model         = new Supplier_model();
        $this->item_group_model       = new Item_group_model();
        $this->item_model             = new Item_model();

        //get db instance
        $this->db = \CodeIgniter\Database\Config::connect();

    }


    /* *********************************************************************************************************
    TAGS
    ********************************************************************************************************* */

    /**
    * As the name says, view the tags.
    */
    public function view_tags($with_deleted = false)
    {
      if ($with_deleted)
      {
        $data['items'] = $this->item_tag_model->withDeleted()->findAll();

        // Add the "active" info for each tag
        foreach ($data['items'] as &$tag)
        {
          $tag['active'] = isset($tag['archive']) ? lang('common_lang.no') : lang('common_lang.yes');
        }
        $data['columns'] = ['name'      => lang('stock_lang.field_name'),
                            'short_name'  => lang('stock_lang.field_short_name'),
                            'active'      => lang('stock_lang.field_active'),
                           ];
      }
      else
      {
        $data['items'] = $this->item_tag_model->findAll();

        $data['columns'] = ['name'        => lang('stock_lang.field_name'),
                            'short_name'  => lang('stock_lang.field_short_name'),
                           ];
      }

      // Prepare datas for common module generic items_list view
      $data['list_title'] = lang('stock_lang.title_tags');

      $data['primary_key_field']  = 'item_tag_id';
      $data['btn_create_label']   = lang('stock_lang.btn_add_tag');
      $data['field_display_deleted'] = lang("stock_lang.field_deleted_tags");
      $data['url_update'] = "stock/admin/modify_tag/";
      $data['url_delete'] = "stock/admin/delete_tag/";
      $data['url_create'] = "stock/admin/new_tag";
      $data['url_getView'] = "stock/admin/view_tags";
      $data['with_deleted'] = $with_deleted;

      return $this->display_view('Common\Views\items_list', $data);
    }

    /**
    * Modify a tag
    */
    public function modify_tag($id = NULL)
    {
      if(is_null($this->item_tag_model->withDeleted()->find($id)))
      {
        return redirect()->to("/stock/admin/view_tags");
      }

      if ( ! empty($_POST))
      {
        $short_max_length = config('\Stock\Config\StockConfig')->tag_short_max_length;
        // VALIDATION
        $validationRules = [
          'name'            => 'required|min_length[3]|max_length[45]|is_unique[item_tag.name,item_tag_id,'.$id.']',
          'short_name'      => 'required|max_length['.$short_max_length.']|is_unique[item_tag.short_name,item_tag_id,'.$id.']'
          ];

        if($this->validate($validationRules))
        {
            $this->item_tag_model->update($id, $_POST);

            return redirect()->to('/stock/admin/view_tags');
        }

      // The values of the tag are loaded only if no form is submitted, otherwise we don't need them and it would disturb the form re-population
      }
      else
      {
        $output['tag'] = $this->item_tag_model->withDeleted()->find($id);
      }

      if( ! is_null($this->item_tag_model->withDeleted()->find($id)))
      {
        $output['tag'] = $this->item_tag_model->withDeleted()->find($id);
      }
      else
      {
        return redirect()->to('/stock/admin/view_tags');
      }

      $this->display_view('Stock\admin\tags\form', $output);
    }

    /**
    * Create a new tag
    */
    public function new_tag()
    {
      if ( ! empty($_POST))
      {
        $short_max_length = config('\Stock\Config\StockConfig')->tag_short_max_length;
        // VALIDATION
        $validationRules = [
          'name'            => 'required|min_length[3]|max_length[45]|is_unique[item_tag.name]',
          'short_name'      => 'required|max_length['.$short_max_length.']|is_unique[item_tag.short_name]'
          ];

        if($this->validate($validationRules))
        {
          $this->item_tag_model->insert($_POST);

          return redirect()->to("/stock/admin/view_tags/");
        }
	    }

      $this->display_view('Stock\admin\tags\form');
    }

    /**
    * Delete a tag.
    * If $action is NULL, a confirmation will be shown. If it is anything else, the tag will be deleted.
    */
    public function delete_tag($id = NULL, $action = 0)
    {
      if(is_null($this->item_tag_model->withDeleted()->find($id)))
      {
        return redirect()->to('/stock/admin/view_tags');
      }

      switch ($action)
      {
        case 0:
          $output = array(
            'tag' => $this->item_tag_model->withDeleted()->find($id)
          );
          $this->display_view('\Stock\admin\tags\delete', $output);
          break;

          case 1: // Soft Delete item_tag
            $this->item_tag_model->delete($id, FALSE);
            return redirect()->to('/stock/admin/view_tags');
            break;

          case 2: // Delete item_tag_link and item_tag
            $this->item_tag_link_model->where('item_tag_id', $id)->delete();
            $this->item_tag_model->delete($id, TRUE);
            return redirect()->to('/stock/admin/view_tags');

          default: // Do nothing
            return redirect()->to('/stock/admin/view_tags');
      }
    }

    /**
     * Reactivate a disabled stocking_place.
     *
     * @param integer $id = ID of the stocking_place to affect
     * @return void
     */
    public function reactivate_tag($id)
    {
        $item_tag = $this->item_tag_model->withDeleted()->find($id);

        if (is_null($item_tag))
        {
            return redirect()->to('/stock/admin/view_tags');
        }
        else
        {
            $this->item_tag_model->withDeleted()->update($id, ['archive' => NULL]);
            return redirect()->to('/stock/admin/modify_tag/' . $id);
        }
    }

    /* *********************************************************************************************************
    STOCKING PLACES
    ********************************************************************************************************* */

    /**
    * As the name says, view the stocking places.
    */
    public function view_stocking_places($with_deleted = FALSE)
    {
      if ($with_deleted)
      {
        $data['items'] = $this->stocking_place_model->withDeleted()->findAll();

        // Add the "active" info for each stocking place
        foreach ($data['items'] as &$stocking_place)
        {
          $stocking_place['active'] = isset($stocking_place['archive']) ? lang('common_lang.no') : lang('common_lang.yes');
        }
        $data['columns'] = ['name'   => lang('stock_lang.field_name'),
                            'short'  => lang('stock_lang.field_short_name'),
                            'active' => lang('stock_lang.field_active'),
                           ];
      }
      else
      {
        $data['items'] = $this->stocking_place_model->findAll();

        $data['columns'] = ['name'  => lang('stock_lang.field_name'),
                            'short' => lang('stock_lang.field_short_name'),
                           ];
      }

      // Prepare datas for common module generic items_list view
      $data['list_title'] = lang('stock_lang.title_stocking_places');

      $data['primary_key_field']  = 'stocking_place_id';
      $data['btn_create_label']   = lang('stock_lang.btn_add_stocking_place');
      $data['field_display_deleted'] = lang("stock_lang.field_deleted_stocking_places");
      $data['url_update'] = "stock/admin/modify_stocking_place/";
      $data['url_delete'] = "stock/admin/delete_stocking_place/";
      $data['url_create'] = "stock/admin/new_stocking_place";
      $data['url_getView'] = "stock/admin/view_stocking_places";
      $data['with_deleted'] = $with_deleted;

      return $this->display_view('Common\Views\items_list', $data);
    }

    /**
    * As the name says, modify a stocking place, which id is $id
    */
    public function modify_stocking_place($id = NULL)
    {
      if (is_null($this->stocking_place_model->find($id)))
      {
        redirect()->to("/admin/view_stocking_places");
      }

      if ( ! empty($_POST))
      {
        $short_max_length = config('\Stock\Config\StockConfig')->stocking_short_max_length;
        // VALIDATION
        $validationRules = [
          'name'            => 'required|min_length[3]|max_length[45]|is_unique[stocking_place.name,stocking_place_id,'.$id.']',
          'short'           => 'required|max_length['.$short_max_length.']|is_unique[stocking_place.short,stocking_place_id,'.$id.']'
          ];

        if ($this->validate($validationRules))
        {
            $this->stocking_place_model->update($id, $_POST);

            return redirect()->to('/stock/admin/view_stocking_places');
        }

      // The values of the tag are loaded only if no form is submitted, otherwise we don't need them and it would disturb the form re-population
      }
      else
      {
        $output['stocking_place'] = $this->stocking_place_model->withDeleted()->find($id);
      }

      if( ! is_null($this->stocking_place_model->withDeleted()->find($id)))
      {
        $output['stocking_place'] = $this->stocking_place_model->withDeleted()->find($id);
      }
      else
      {
        return redirect()->to('/stock/admin/view_stocking_places');
      }

      $this->display_view('Stock\admin\stocking_places\form', $output);
    }

    /**
    * Create a new stocking_place
    */
    public function new_stocking_place()
    {
      if ( ! empty($_POST))
      {
        $short_max_length = config('\Stock\Config\StockConfig')->stocking_short_max_length;
        // VALIDATION
        $validationRules = [
          'name'            => 'required|min_length[3]|max_length[45]|is_unique[stocking_place.name]',
          'short'           => 'required|max_length['.$short_max_length.']|is_unique[stocking_place.short]'
          ];

        if($this->validate($validationRules))
        {
          $this->stocking_place_model->insert($_POST);

          return redirect()->to("/stock/admin/view_stocking_places");
        }
	    }

      $this->display_view('Stock\admin\stocking_places\form');
    }

    /**
    * Delete the stocking place $id. If $action is null, a confirmation will be shown
    */
    public function delete_stocking_place($id = NULL, $action = 0)
    {
      if(is_null($this->stocking_place_model->withDeleted()->find($id)))
      {
        return redirect()->to('/stock/admin/view_stocking_places');
      }

      switch ($action)
      {
        case 0:
          $output = array(
            'stocking_place' => $this->stocking_place_model->withDeleted()->find($id)
          );
          $this->display_view('\Stock\admin\stocking_places\delete', $output);
          break;

          case 1: // Soft delete stocking_place
            $this->stocking_place_model->delete($id, FALSE);
            return redirect()->to('/stock/admin/view_stocking_places');
            break;

          case 2: // Delete stocking_place and update every connected FK to NULL
            $stocking_place_id = $this->item_model->where('stocking_place_id', $id)->findAll();

            if ( ! is_null($stocking_place_id))
            {
              for ($i = 0; $i <= count($stocking_place_id) - 1; $i++)
              {
                $this->item_model->update($stocking_place_id[$i]['item_id'], ['stocking_place_id' => NULL]);
              }
            }

            $this->stocking_place_model->delete($id, TRUE);
            return redirect()->to('/stock/admin/view_stocking_places');

          default: // Do nothing
            return redirect()->to('/stock/admin/view_stocking_places');
      }
    }

    /**
     * Reactivate a disabled stocking_place.
     *
     * @param integer $id = ID of the stocking_place to affect
     * @return void
     */
    public function reactivate_stocking_place($id)
    {
        $stocking_place = $this->stocking_place_model->withDeleted()->find($id);

        if (is_null($stocking_place))
        {
            return redirect()->to('/stock/admin/view_stocking_places');
        }
        else
        {
            $this->stocking_place_model->withDeleted()->update($id, ['archive' => NULL]);
            return redirect()->to('/stock/admin/modify_stocking_place/' . $id);
        }
    }

    /* *********************************************************************************************************
    SUPPLIERS
    ********************************************************************************************************* */

    /**
    * As the name says, view the suppliers.
    */
    public function view_suppliers($with_deleted = false)
    {
      // Describe columns to display for common module generic items_list view
      $data['columns'] = ['name'    => lang('stock_lang.field_name'),
                          'address' => lang('stock_lang.field_address'),
                          'tel'     => lang('stock_lang.field_tel'),
                          'email'   => lang('stock_lang.field_email'),
      ];

      if ($with_deleted)
      {
        $suppliers = $this->supplier_model->withDeleted()->findAll();
        $data['columns']['active'] = lang('stock_lang.field_active');
      }
      else
      {
        $suppliers = $this->supplier_model->findAll();
      }

      // Order columns and construct contents for common module generic items_list view
      $data['items'] = [];
      foreach ($suppliers as $supplier)
      {
        $data['items'][] = [
          'supplier_id'     => $supplier['supplier_id'],
          'name'            => $supplier['name'],
          'address'         => (!empty($supplier['address_line1']) ? $supplier['address_line1']."<br>" : "").
                               (!empty($supplier['address_line2']) ? $supplier['address_line2']."<br>" : "").
                               ((!empty($supplier['zip']) || !empty($supplier['city'])) ? $supplier['zip']." ".$supplier['city']."<br>" : "").
                               (!empty($supplier['country']) ? $supplier['country'] : ""),
          'tel'             => $supplier['tel'],
          'email'           => $supplier['email'],
          'active'          => isset($supplier['archive']) ? lang('common_lang.no') : lang('common_lang.yes')
        ];
      }

      // Complete datas for common module generic items_list view
      $data['list_title'] = lang('stock_lang.title_suppliers');

      $data['primary_key_field']  = 'supplier_id';
      $data['btn_create_label']   = lang('stock_lang.btn_add_supplier');
      $data['field_display_deleted'] = lang("stock_lang.field_deleted_suppliers");
      $data['url_update'] = "stock/admin/modify_supplier/";
      $data['url_delete'] = "stock/admin/delete_supplier/";
      $data['url_create'] = "stock/admin/new_supplier";
      $data['url_getView'] = "stock/admin/view_suppliers";
      $data['with_deleted'] = $with_deleted;

      return $this->display_view('Common\Views\items_list', $data);
    }

    /**
    * Modify a supplier
    */
    public function modify_supplier($id = NULL)
    {
      if (is_null($this->supplier_model->withDeleted()->find($id)))
      {
        redirect()->to("/admin/view_suppliers");
      }

      if ( ! empty($_POST))
      {
        // VALIDATION
        $validationRules = [
          'name'            => 'required|min_length[3]|max_length[45]|is_unique[supplier.name,supplier_id,'.$id.']',
          'address_line1'   => 'max_length[100]',
          'address_line2'   => 'max_length[100]',
          'zip'             => 'max_length[45]',
          'city'            => 'max_length[100]',
          'country'         => 'max_length[45]',
          'tel'             => 'max_length[45]',
          ];

          if ($_POST['email'] != '')
          {
            $validationRules = [
              'email'       => 'max_length[45]|valid_email'
            ];
          }

        if ($this->validate($validationRules))
        {
            $this->supplier_model->update($id, $_POST);

            return redirect()->to('/stock/admin/view_suppliers');
        }

      // The values of the tag are loaded only if no form is submitted, otherwise we don't need them and it would disturb the form re-population
      }
      else
      {
        $output['supplier'] = $this->supplier_model->withDeleted()->find($id);
      }

      if( ! is_null($this->supplier_model->withDeleted()->find($id)))
      {
        $output['supplier'] = $this->supplier_model->withDeleted()->find($id);
      }
      else
      {
        return redirect()->to('/stock/admin/view_suppliers');
      }

      $this->display_view('Stock\admin\suppliers\form', $output);
    }

    /**
    * Create a new supplier
    */
    public function new_supplier()
    {
      if ( ! empty($_POST))
      {
        // VALIDATION
        $validationRules = [
          'name'            => 'required|min_length[3]|max_length[45]|is_unique[supplier.name]',
          'address_line1'   => 'max_length[100]',
          'address_line2'   => 'max_length[100]',
          'zip'             => 'max_length[45]',
          'city'            => 'max_length[100]',
          'country'         => 'max_length[45]',
          'tel'             => 'max_length[45]',
          ];

          if ( ! isset($_POST['email']))
          {
            $validationRules = [
              'email'       => 'max_length[45]|valid_email'
            ];
          }

        if($this->validate($validationRules))
        {
          $this->supplier_model->insert($_POST);

          return redirect()->to("/stock/admin/view_suppliers");
        }
	    }

      $this->display_view('Stock\admin\suppliers\form');
    }

    /**
    * Delete a supplier
    */
    public function delete_supplier($id = NULL, $action = 0)
    {
      if(is_null($this->supplier_model->withDeleted()->find($id)))
      {
        return redirect()->to('/stock/admin/view_suppliers');
      }

      switch ($action)
      {
        case 0:
          $output = array(
            'supplier' => $this->supplier_model->withDeleted()->find($id)
          );
          $this->display_view('\Stock\admin\suppliers\delete', $output);
          break;

          case 1: // Soft delete supplier
            $this->supplier_model->delete($id, FALSE);
            return redirect()->to('/stock/admin/view_suppliers');
            break;

          case 2: // Delete supplier and update every connected FK to NULL
            $supplier_id = $this->item_model->where('supplier_id', $id)->findAll();

            if ( ! is_null($supplier_id))
            {
              for ($i = 0; $i <= count($supplier_id) - 1; $i++)
              {
                $this->item_model->update($supplier_id[$i]['item_id'], ['supplier_id' => Null]);
              }
            }

            $this->supplier_model->delete($id, TRUE);
            return redirect()->to('/stock/admin/view_suppliers');

          default: // Do nothing
            return redirect()->to('/stock/admin/view_suppliers');
      }
    }

    /**
     * Reactivate a disabled supplier.
     *
     * @param integer $id = ID of the supplier to affect
     * @return void
     */
    public function reactivate_supplier($id)
    {
        $supplier = $this->supplier_model->withDeleted()->find($id);

        if (is_null($supplier))
        {
            return redirect()->to('/stock/admin/view_suppliers');
        }
        else
        {
            $this->supplier_model->withDeleted()->update($id, ['archive' => NULL]);
            return redirect()->to('/stock/admin/modify_supplier/' . $id);
        }
    }

    /* *********************************************************************************************************
    ITEM GROUPS
    ********************************************************************************************************* */

    /**
    * As the name says, view the item groups.
    */
    public function view_item_groups($with_deleted = FALSE)
    {
      if ($with_deleted)
      {
        $data['items'] = $this->item_group_model->withDeleted()->findAll();

        // Add the "active" info for each item group
        foreach ($data['items'] as &$item_group)
        {
          $item_group['active'] = isset($item_group['archive']) ? lang('common_lang.no') : lang('common_lang.yes');
        }
        $data['columns'] = ['name'   => lang('stock_lang.field_name'),
                            'short_name'  => lang('stock_lang.field_short_name'),
                            'active' => lang('stock_lang.field_active'),
                           ];
      }
      else
      {
        $data['items'] = $this->item_group_model->findAll();

        $data['columns'] = ['name'  => lang('stock_lang.field_name'),
                            'short_name' => lang('stock_lang.field_short_name'),
                           ];
      }

      // Complete datas for common module generic items_list view
      $data['list_title'] = lang('stock_lang.title_item_groups');

      $data['primary_key_field']  = 'item_group_id';
      $data['btn_create_label']   = lang('stock_lang.btn_add_item_group');
      $data['field_display_deleted'] = lang("stock_lang.field_deleted_item_groups");
      $data['url_update'] = "stock/admin/modify_item_group/";
      $data['url_delete'] = "stock/admin/delete_item_group/";
      $data['url_create'] = "stock/admin/new_item_group";
      $data['url_getView'] = "stock/admin/view_item_groups";
      $data['with_deleted'] = $with_deleted;

      return $this->display_view('Common\Views\items_list', $data);
    }

    /**
    * Modify a group
    */
    public function modify_item_group($id = NULL)
    {
      if(is_null($this->item_group_model->withDeleted()->find($id)))
      {
        return redirect()->to("/stock/admin/view_item_groups");
      }

      if ( ! empty($_POST))
      {
        // VALIDATION
        $validationRules = [
          'name'            => 'required|min_length[3]|max_length[45]|is_unique[item_group.name,item_group_id,'.$id.']',
          'short_name'      => 'required|max_length[2]|is_unique[item_group.short_name,item_group_id,'.$id.']'
          ];

        if($this->validate($validationRules))
        {
            $this->item_group_model->update($id, $_POST);

            return redirect()->to('/stock/admin/view_item_groups');
        }

      // The values of the tag are loaded only if no form is submitted, otherwise we don't need them and it would disturb the form re-population
      }
      else
      {
        $output['item_group'] = $this->item_group_model->withDeleted()->find($id);
      }

      if( ! is_null($this->item_group_model->withDeleted()->find($id)))
      {
        $output['item_group'] = $this->item_group_model->withDeleted()->find($id);
      }
      else
      {
        return redirect()->to('/stock/admin/view_item_groups');
      }

      $this->display_view('Stock\admin\item_groups\form', $output);
    }

    /**
    * Create a new group
    */
    public function new_item_group()
    {
      if ( ! empty($_POST))
      {
        // VALIDATION
        $validationRules = [
          'name'            => 'required|min_length[2]|max_length[45]|is_unique[stocking_place.name]',
          'short'           => 'required|max_length['.config('\Stock\Config\StockConfig')->stocking_short_max_length.']|is_unique[stocking_place.short_name]'
          ];

        if($this->validate($validationRules))
        {
          $this->item_groups_model->insert($_POST);

          return redirect()->to("/stock/admin/view_item_groups");
        }
	    }

      $this->display_view('Stock\admin\item_groups\form');
    }

    /**
    * Delete an unused item group
    */
    public function delete_item_group($id = NULL, $action = 0)
    {
      if(is_null($this->item_group_model->withDeleted()->find($id)))
      {
        return redirect()->to('/stock/admin/view_item_groups');
      }

      switch ($action)
      {
        case 0:
          $output = array(
            'item_group' => $this->item_group_model->withDeleted()->find($id)
          );
          $this->display_view('\Stock\admin\item_groups\delete', $output);
          break;

          case 1: // Soft delete item_group
            $this->item_group_model->delete($id, FALSE);
            return redirect()->to('/stock/admin/view_item_groups');
            break;

          case 2: // Delete item_group and update every connected FK to NULL
            $item_id = $this->item_model->where('item_group_id', $id)->findAll();

            if ( ! is_null($item_id))
            {
              for ($i = 0; $i <= count($item_id)-1; $i++)
              {
                $this->item_model->update($item_id[$i]['item_id'], ['item_group_id' => NULL]);
              }
            }

            $this->item_group_model->delete($id, TRUE);
            return redirect()->to('/stock/admin/view_item_groups');

          default: // Do nothing
            return redirect()->to('/stock/admin/view_item_groups');
      }
    }

    /**
     * Reactivate a disabled item_group.
     *
     * @param integer $id = ID of the item_group to affect
     * @return void
     */
    public function reactivate_item_group($id)
    {
        $item_group = $this->item_group_model->withDeleted()->find($id);

        if (is_null($item_group))
        {
            return redirect()->to('/stock/admin/view_item_groups');
        }
        else
        {
            $this->item_group_model->withDeleted()->update($id, ['archive' => NULL]);
            return redirect()->to('/stock/admin/modify_item_group/' . $id);
        }
    }
}
