<?php
class UserModel extends Model{
  protected $_validate = array(
    array('username','require','用户名不能为空'),
    array('passwd','require','密码不能为空'),
    );
}
?>