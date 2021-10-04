<?php 

namespace  Stock\Models;

use CodeIgniter\Model;


class MyModel extends Model
{
    /* BaseModel variables definition */



    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table($this->table);
    }


    function dropdown()
    {
        $args = func_get_args();

        if(count($args) == 2)
        {
            list($key, $value) = $args;
        }
        else
        {
            $key = $this->primaryKey;
            $value = $args[0];
        }

        $this->trigger('before_dropdown', array( $key, $value ));

        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
        {
            $this->_database->where($this->soft_delete_key, FALSE);
        }
        
        $result = $this->builder->select(array($key, $value))
                           ->get(/*$this->table*/)
                            ->getResultArray();

        $options = array();

      //  echo var_dump($result);


        foreach ($result as $row)
        {
            $options[$row[$key]] = $row[$value];
         //   $options[$row->{$key}] = $row->{$value};
        }

        $options = $this->trigger('after_dropdown', $options);

        return $options;
    }

    public function trigger($event, $data = FALSE, $last = TRUE)
    {
        if (isset($this->$event) && is_array($this->$event))
        {
            foreach ($this->$event as $method)
            {
                if (strpos($method, '('))
                {
                    preg_match('/([a-zA-Z0-9\_\-]+)(\(([a-zA-Z0-9\_\-\., ]+)\))?/', $method, $matches);

                    $method = $matches[1];
                    $this->callback_parameters = explode(',', $matches[3]);
                }

                $data = call_user_func_array(array($this, $method), array($data, $last));
            }
        }

        return $data;
    }


}