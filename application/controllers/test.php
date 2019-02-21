<?php

class Test extends MY_Controller {

    public function index($page = 1) {
        $output = $this->load_list($filters, array("value"=>"name","asc"=>true), $page);
        $this->display_view('item/list', $output);
    }
    
    public function load_list($filters, $sorting, $page)
    {
        // Get item(s) through filtered search on the database
        $output['items'] = $this->item_model->get_filtered($filters);

        //TODO "name" -> $sorting; true -> $sorting;
        // Sort output depending on the user's choice
        $sortValue = $sorting["value"];
        $asc = $sorting["asc"];

        // Verify the existence of the sort order key in filters
        if(array_key_exists("o", $filters)){
            switch ($filters['o']) {
            case 1:
                $sortValue = "stocking_place_id";
                break;
            case 2:
                $sortValue = "buying_date";
                break;
            case 3:
                $sortValue = "inventory_number";
                break;
            //In case of problem, it automatically switches to name
            default:
            case 0:
                $sortValue = "name";
                break;
            }
        }
        // If not 1, order will be ascending
        if(array_key_exists("ad", $filters)){
            $asc = $filters['ad'] != 1;
        }
        $output['items'] = sortBySubValue($output['items'], $sortValue, $asc);

        // Prepare search filters values to send to the view
        $output = array_merge($output, $filters);
        if (!isset($output["ts"])) $output["ts"] = '';
        if (!isset($output["c"])) $output["c"] = '';
        if (!isset($output["g"])) $output["g"] = '';
        if (!isset($output["s"])) $output["s"] = '';
        if (!isset($output["t"])) $output["t"] = '';
        if (!isset($output["o"])) $output["o"] = '';
        if (!isset($output["ad"])) $output["ad"] = '';

        // Add page title
        $output['title'] = $this->lang->line('page_item_list');

        // Load list of elements to display as filters
        $this->load->model('item_tag_model');
        $output['item_tags'] = $this->item_tag_model->dropdown('name');
        $this->load->model('item_condition_model');
        $output['item_conditions'] = $this->item_condition_model->dropdown('name');
        $this->load->model('item_group_model');
        $output['item_groups'] = $this->item_group_model->dropdown('name');
        $this->load->model('stocking_place_model');
        $output['stocking_places'] = $this->stocking_place_model->dropdown('name');
        $output['sort_order'] = array($this->lang->line('sort_order_name'),
                                        $this->lang->line('sort_order_stocking_place_id'),
                                        $this->lang->line('sort_order_date'),
                                        $this->lang->line('sort_order_inventory_number'));
        $output['sort_asc_desc'] = array($this->lang->line('sort_order_asc'),
                                            $this->lang->line('sort_order_des'));
        
        $output['pagination'] =  $this->load_pagination(count($output["items"]))->create_links();

        // Keep only the slice of items corresponding to the current page
        $output["items"] = array_slice($output["items"], ($page-1)*ITEMS_PER_PAGE, ITEMS_PER_PAGE);

        return $output;
    }
}
    
?>