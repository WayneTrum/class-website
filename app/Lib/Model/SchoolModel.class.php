<?php
class SchoolModel extends Model{
  protected $validate = array(
    array('school_name','require','学院名称不能为空！'),
    );
}
?>