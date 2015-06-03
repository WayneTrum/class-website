<?php
import('ORG.Util.Cookie');
import('ORG.Net.UploadFile');
class ZhangAction extends Action{
  public function addDoc(){
    $course_id = $_POST['course_id'];
    $zhang_name = $_POST['zhang_name'];
    $usertype = Cookie::get('usertype');
    $upload = new UploadFile($_POST['file']);
    $upload->allowExts  = array('zip', 'rar', 'gz');
    $upload->savePath =  './../Public/Uploads/document/';
    if(!$upload->upload()) {
        $this->error($upload->getErrorMsg());
    }else{
        $info = $upload->getUploadFileInfo();
    }
    $zhang = M('zhang');
    $zhang->create();
    $zhang->course_id = $course_id;
    $zhang->zhang_name = $zhang_name;
    $zhang->file = $info[0]['savename'];

    $result = $zhang->add();
    $this->assign("jumpUrl","__APP__/Document/teacherindex/id/{$course_id}");
    if ($result) {  
      $this->success("添加成功！");
    }else{
      $this->error($result->getErrorMsg());
    }
  }
}
?>