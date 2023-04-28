<?php
/**
 * Custom rules for form validation
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Validations;


use Stock\Models\Item_group_model;

class CustomRules
{
    /**
     * Checks that a name doesn't already exist in an entity
     *
     * @param string $name = name to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if the username is unique, FALSE otherwise
     */
    public function is_unique_group_name_by_entity(string $name, string $params) : bool
    {
        // Separate the 2 parameters
        $params = explode(',', $params);

        $item_group_model = new Item_group_model();

        $item_group = $item_group_model->where('name', [$name])
                        ->where('fk_entity_id', $params[1])
                        ->where('item_group_id !=', $params[0])
                        ->first();

        return is_null($item_group);
    }

    /**
     * Checks that a name doesn't already exist in an entity
     *
     * @param string $name = name to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if the username is unique, FALSE otherwise
     */
    public function is_unique_group_short_name_by_entity(string $short_name, string $params) : bool
    {
        // Separate the 2 parameters
        $params = explode(',', $params);

        $item_group_model = new Item_group_model();

        $item_group = $item_group_model->where('short_name', $short_name)
                        ->where('fk_entity_id', $params[1])
                        ->where('item_group_id !=', $params[0])
                        ->first();

        return is_null($item_group);
    }
}