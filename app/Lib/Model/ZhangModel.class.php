<?php
class ZhangModel extends Model{
  protected $validate = array(
    array('zhang_name','require','notnull'),
    array('course_id','require','notnull'),
    array('file','require','notnull'),
    );
}
?>