<?php
class Student_testModel extends Model{
  protected $validate = array(
    array('zhang_id','require',''),
    array('user_id','require',''),
    array('test_score','require',''),
    );
}
?>