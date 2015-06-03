<?php
class Student_workModel extends Model{
  protected $validate = array(
    array('homework_id','require',''),
    array('answer_img','require',''),
    array('user_id','require',''),
    );
}
?>