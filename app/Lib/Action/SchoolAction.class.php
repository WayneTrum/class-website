<?php
class SchoolAction extends Action{
  public function add(){
    $this->display();
  }

  public function addschool(){
    $school_name = $_POST['school_name'];
    $school = D('school');
    $schoolinfo = $school->where("school_name='$school_name'")->find();
    if (empty($schoolinfo)) {
      $school->create();
      $result = $school->add();
      if ($result) {
        $this->assign("jumpUrl","__APP__/Manager/index");
        $this->success("添加成功！");
      }else{
        $this->assign("jumpUrl","__APP__/Manager/addschool");
        $this->error("添加失败！");
      }
    }else{
      $this->assign("jumpUrl","__APP__/Manager/addschool");
      $this->error("学院已存在！");
    }
  }
}
?>