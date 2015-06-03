<?php
import('ORG.Util.Cookie');
import('ORG.Net.UploadFile');
class VedioAction extends Action{
  public function teacherindex(){
    $zhang_id = $_GET['id'];
    $course = new CourseModel();
    $zhang = new ZhangModel();
    $vedio = new VedioModel();
    $vediolist = $vedio->where("zhang_id='$zhang_id'")->select();
    $zhanglist = $zhang->where("zhang_id='$zhang_id'")->find();
    $course_id = $zhanglist['course_id'];
    $result = $course->where("course_id='$course_id'")->find();

    $username = Cookie::get('username');
    $userid = Cookie::get('userid');
    $usertype = Cookie::get('usertype');
    
    $this->assign('course',$result);
    $this->assign('vediolist',$vediolist);
    $this->assign('zhang',$zhanglist);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->assign('usertype',$usertype);
    $this->display();
  }

  public function studentindex(){
    $zhang_id = $_GET['id'];
    $course = new CourseModel();
    $zhang = new ZhangModel();
    $vedio = new VedioModel();
    $vediolist = $vedio->where("zhang_id='$zhang_id'")->select();
    $zhanglist = $zhang->where("zhang_id='$zhang_id'")->find();
    $course_id = $zhanglist['course_id'];
    $result = $course->where("course_id='$course_id'")->find();

    $username = Cookie::get('username');
    $userid = Cookie::get('userid');
    $usertype = Cookie::get('usertype');
    
    $this->assign('course',$result);
    $this->assign('vediolist',$vediolist);
    $this->assign('zhang',$zhanglist);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->assign('usertype',$usertype);
    $this->display();
  }

  public function index(){
    $course_id = $_GET['id'];
    $course = new CourseModel();
    $zhang = new ZhangModel();
    $vedio = new VedioModel();
    $zhanglist = $zhang->where("course_id ='$course_id'")->select();
    $result = $course->where("course_id='$course_id'")->find();

    $username = Cookie::get('username');
    $userid = Cookie::get('userid');
    $usertype = Cookie::get('usertype');
    
    $this->assign('course',$result);
    $this->assign('zhanglist',$zhanglist);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->assign('usertype',$usertype);
    if ($usertype === 'Teacher') {
      $urlturn = 'teacherindex';
    }else{
      $urlturn = 'studentindex';
    }
    $this->assign('urlturn',$urlturn);
    $this->display();
  }

  public function addvedio(){
    $zhang_id = $_POST['zhang_id'];
    $vedio_title = $_POST['vedio_title'];
    $course_id = $_POST['course_id'];
    $upload = new UploadFile($_POST['file']);
    $upload->allowExts  = array('mp4');
    $upload->savePath =  './../Public/Uploads/vedio/';
    if(!$upload->upload()) {
        $this->error($upload->getErrorMsg());
    }else{
        $info = $upload->getUploadFileInfo();
        $vedio = M('vedio');
        $vedio->create();
        $vedio->vedio_title = $vedio_title;
        $vedio->vedio_name = $info[0]['savename'];
        $vedio->zhang_id = $zhang_id;
        $result = $vedio->add();
        $this->assign("jumpUrl","__APP__/Vedio/index/id/{$course_id}");
        if ($result) {  
          $this->success("添加成功！");
        }else{
          $this->error("添加不成功");
        }
      }

    }
}
?>