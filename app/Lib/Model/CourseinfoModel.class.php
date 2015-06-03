<?php
class CourseinfoModel extends Model{
  protected $validate = array(
    array('courseinfo_title','require','课程简介不能为空'),
    array('courseinfo_content','require','课程内容概要不能为空'),
    array('courseinfo_reference','require','课程参考书目不能为空'),
    array('course_id','require','课程id不能为空'),
    );

}
?>