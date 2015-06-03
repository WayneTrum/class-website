<?php
class TestModel extends Model{
  protected $validate = array(
    array('test_title','require',''),
    array('test_option_a','require',''),
    array('test_option_b','require',''),
    array('test_option_c','require',''),
    array('test_option_d','require',''),
    array('test_option_right','require',''),
    array('zhang_id','require','')
    );
}
?>