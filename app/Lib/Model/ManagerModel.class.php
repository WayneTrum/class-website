<?php
class ManagerModel extends Model{
  protected $validate = array(
    array('manager_name','require','name is must'),
    array('manager_passwd','require','password is must'),
    );
}
?>