<?php
class VedioModel extends Model{
  protected $validate = array(
    array('vedio_title','require','notnull'),
    array('vedio_name','require','notnull'),
    array('zhang_id','require','notnull'),
    );
}
?>