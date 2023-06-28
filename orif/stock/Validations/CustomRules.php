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
use Stock\Models\Stocking_place_model;

class CustomRules
{
    /**
     * Checks that a name doesn't already exist in an entity
     *
     * @param string $name = name to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if the name is unique in the given entity, FALSE otherwise
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
     * Checks that a short_name doesn't already exist in an entity
     *
     * @param string $short name = short name to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if the short_name is unique in the given entity, FALSE otherwise
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

    /**
     * Checks that a stocking place's name doesn't already exist in an entity
     *
     * @param string $name = name to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if the name is unique in the given entity, FALSE otherwise
     */
    public function is_unique_place_name_by_entity(string $name, string $params) : bool
    {
        // Separate the 2 parameters
        $params = explode(',', $params);

        $stocking_place_model = new Stocking_place_model();

        $stocking_place = $stocking_place_model->where('name', [$name])
                            ->where('fk_entity_id', $params[1])
                            ->where('stocking_place_id !=', $params[0])
                            ->first();

        return is_null($stocking_place);
    }

    /**
     * Checks that a stocking place's short_name doesn't already exist in an entity
     *
     * @param string $short_name = short name to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if the short_name is unique in the given entity, FALSE otherwise
     */
    public function is_unique_place_short_name_by_entity(string $short_name, string $params) : bool
    {
        // Separate the 2 parameters
        $params = explode(',', $params);

        $stocking_place_model = new Stocking_place_model();

        $stocking_place = $stocking_place_model->where('short', $short_name)
                            ->where('fk_entity_id', $params[1])
                            ->where('stocking_place_id !=', $params[0])
                            ->first();

        return is_null($stocking_place);
    }

    /**
     * Checks that an entity change on an item_group does not affect any item.
     * The stocking place is also linked with the entity and we have to avoid data inconsistency.
     *
     * @param string $entity_id = entity id to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if no item linked to a stocking place in the current entity is affected by the change. FALSE otherwise.
     */
    public function item_group_has_same_entity(string $entity_id, string $params) : bool
    {
        // Separate the 2 parameters
        $params = explode(',', $params);

        $item_group_model = new Item_group_model();

        $item_group_entity_id = $item_group_model->where('item_group_id', $params[0])->findColumn('fk_entity_id');

        $result = $item_group_model->select('stocking_place.fk_entity_id')
                                   ->join('item', 'item.item_group_id = item_group.item_group_id', 'inner')
                                   ->join('stocking_place', 'stocking_place.stocking_place_id = item.stocking_place_id', 'inner')
                                   ->where('item_group.item_group_id', $params[0])
                                   ->where('item_group.fk_entity_id', $item_group_entity_id)
                                   ->distinct()
                                   ->get()
                                   ->getRow();

        return $result ? $result->fk_entity_id === $entity_id : true;
    }

    /**
     * Checks that an entity change on a stocking_place does not affect any item
     * The item group is also linked with the entity and we have to avoid data inconsistency.
     *
     * @param string $entity_id = entity id to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if no item linked to an item group in the current entity is affected by the change. FALSE otherwise.
     */
    public function stocking_place_has_same_entity(string $entity_id, string $params) : bool
    {
        // Separate the 2 parameters
        $params = explode(',', $params);

        $stocking_place_model = new Stocking_place_model();

        $stocking_place_entity_id = $stocking_place_model->where('stocking_place_id', $params[0])->findColumn('fk_entity_id');

        $result = $stocking_place_model->select('item_group.fk_entity_id')
                                       ->join('item', 'item.stocking_place_id = stocking_place.stocking_place_id', 'inner')
                                       ->join('item_group', 'item_group.item_group_id = item.item_group_id', 'inner')
                                       ->where('stocking_place.stocking_place_id', $params[0])
                                       ->where('stocking_place.fk_entity_id', $stocking_place_entity_id)
                                       ->distinct()
                                       ->get()
                                       ->getRow();

        return $result ? $result->fk_entity_id === $entity_id : true;
    }
}