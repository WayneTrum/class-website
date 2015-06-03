<?php
class SchoolcourseModel extends Model{
  protected $validate = array(
    array('school_id','require','school id can not be null!'),
    array('course_id','require','course id can not be null!'),
    );
}
?>