<?php
class CourseModel extends Model{
  protected $validate = array(
    array('course_name','require','课程名称不能为空'),
    array('course_score','require','课程学分不能为空'),
    array('course_teacher_id','require','教师ID不能为空'),
    array('course_teacher_name','require','教师名称不能为空'),
    );
}
?>