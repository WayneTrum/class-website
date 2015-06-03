<?php
class HomeworkModel extends Model{
  protected $validate = array(
    array('homework_title','require',''),
    array('homework_img','',''),
    array('course_id','require',''),
    );
}
?>