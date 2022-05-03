<?php
/**
 * Model User_model this represents the user table
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
namespace User\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;

class User_model extends \CodeIgniter\Model{
    protected $table='user';
    protected $primaryKey='id';
    protected $allowedFields=['archive','date_creation','email','username','password','fk_user_type'];
    protected $useSoftDeletes=true;
    protected $deletedField="archive";
    private $user_type_model=null;


    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->user_type_model=new User_type_model();
    }

    /**
     * Check username and password for login
     *
     * @param string $username
     * @param string $password
     * @return boolean true on success false otherwise
     */
    public function check_password_name($username, $password){
        $user=$this->where("username",$username)->first();
        //If a user is found we can verify his password because if his archive is not empty, he is not in the array
        if (!is_null($user)){
            return password_verify($password,$user['password']);
        }
        else{
            return false;

        }


    }

    /**
     * @param string $email
     * @param string $password
     * @return bool true on success false otherwise
     */
    public function check_password_email($email,$password){
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return false;
        }
        $user = $this->where('email',$email)->first();
        if (!is_null($user)){
            return password_verify($password,$user['password']);
        }
        else{
            return false;
        }
    }

    /**
     * return the access level of an user
     * @param $user
     * @return mixed
     */
    public function get_access_level($user){
        if ($this->user_type_model==null){
            $this->user_type_model=new User_type_model();

        }
        $user->access_level=$this->user_type_model->getWhere(['id'=>$user->fk_user_type])->getRow()->access_level;
        return $user->access_level;

    }
}