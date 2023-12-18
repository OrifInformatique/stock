<?php
/**
 * Custom rules for form validation
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Validations;

use Stock\Models\Item_common_model;
use Stock\Models\Item_group_model;
use Stock\Models\Stocking_place_model;
use User\Models\User_model;

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
     * Checks that a stocking place's short_name doesn't already exist in an entity
     *
     * @param string $name = name to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if the short_name is unique in the given entity, FALSE otherwise
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
     * Checks that a short_name doesn't already exist in an entity
     *
     * @param string $short_name = short name to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if the username is unique, FALSE otherwise
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

        $result = $item_group_model->select('item_group.fk_entity_id')
                                   ->join('item_common', 'item_common.item_group_id = item_group.item_group_id', 'inner')
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

        $result = $stocking_place_model->select('stocking_place.fk_entity_id')
                                       ->join('item', 'item.stocking_place_id = stocking_place.stocking_place_id', 'inner')
                                       ->where('stocking_place.stocking_place_id', $params[0])
                                       ->where('stocking_place.fk_entity_id', $stocking_place_entity_id)
                                       ->distinct()
                                       ->get()
                                       ->getRow();

        return $result ? $result->fk_entity_id === $entity_id : true;
    }

    /**
     * Callback method for change_password validation rule
     *
     * @param string $pwd = The previous password
     * @param string $user = The username
     * @return boolean = Whether or not the combination is correct
     */
    public function old_password_check($pwd, $user)
    {
        return (new User_model())->check_password_name($user, $pwd);
    }
    public function cb_not_null_user($user_id)
    {
        return $user_id == 0 || !is_null((new User_model())->withDeleted()->find($user_id));
    }
    /**
     * Checks that a username doesn't exist
     *
     * @param string $username = Username to check
     * @param int $user_id = ID of the user if it is an update
     * @return boolean = TRUE if the username is unique, FALSE otherwise
     */
    public function cb_unique_user($username, $user_id) : bool
    {
        $user = (new User_model())->withDeleted()->where('username', [$username])->first();
        return is_null($user) || $user['id'] == $user_id;
    }

    /**
     * Checks that a name doesn't already exist
     *
     * @param string $name = Name to check
     * @param int $id = id of the item_common if it is an update
     * @return boolean = TRUE if the name is unique, FALSE otherwise
     */
    public function cb_unique_name($name, $id) : bool
    {
        $item_common = (new Item_common_model())->where('name', [$name])->first();
        return is_null($item_common) || $item_common['item_common_id'] == $id;
    }

    /**
     * Checks that a date is later than, or identical to another one
     *
     * @param string $date1 = The date to compare
     * @param string $date2 = The date to be compared to
     * @return boolean = TRUE if the date is later than or equal to the other, FALSE otherwise
     */
    public function later_than_equal_to($date1, $date2): bool
    {
        return $date1 >= $date2;
    }
}