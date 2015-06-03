<?php
class CoursestudentModel extends Model{
  protected $validate = array(
    array('user_id','require',''),
    array('course_id','require',''),
    array('score','require',''),
    );
}
?>