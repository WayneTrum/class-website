<?php
class TeachercourseModel extends Model{
  protected $validate = array(
    array('teacher_id','require','教师id不能为空！'),
    array('course_id','require','课程id不能为空！'),
    );
}
?>