<?php
class TeacherModel extends Model{
  protected $validate = array(
    array('teacher_name','require','教师名字必填！'),
    array('teacher_passwd','require','密码须填写！'),
    array('class_name','require','请输入教师所教授的课程名！'),
    array('school_name','require','请输入教师所在学院！'),
    );
}
?>