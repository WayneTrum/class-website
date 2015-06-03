<?php
import('ORG.Util.Cookie');
class ManagerAction extends Action{
  public function login(){
    $this->display();
  }

  public function register(){
    $this->display();
  }

  public function checklogin(){
    $manager_name = $_POST['manager_name'];
    $manager_passwd = $_POST['manager_passwd'];
    $manager = D("manager");
    $managerinfo = $manager->where("manager_name='$manager_name'")->find();
    if (!empty($managerinfo)) {
      if ($managerinfo['manager_passwd'] == $manager_passwd) {
        Cookie::set('userid',$managerinfo['manager_id'],time()+3600*24);
        Cookie::set('username',$manager_name,time()+3600*24);
        Cookie::set('usertype','Manager',time()+3600*24);
        Cookie::set('lastlogintime',time(),time()+3600*24);
        
        $this->assign("jumpUrl","__APP__/Manager/index");
        $this->success("login success!");
      }else{
        $this->assign("jumpUrl","__APP__/Manager/login");
        $this->error("password error!");
      }
    }else{
      $this->assign("jumpUrl","__APP__/Manager/login");
      $this->error("name is not exist!");
    }
  }

  public function add(){
    $manager_name = $_POST['manager_name'];
    $manager_passwd = $_POST['manager_passwd'];
    $manager = D("manager");
    $managerinfo = $manager->where("manager_name='$manager_name'")->find();
    if (empty($managerinfo)) {
      $manager->create();
      $result = $manager->add();
      if ($result) {
        $this->assign("jumpUrl","__APP__/Manager/login");
        $this->success("register success!");
      }else{
        $this->assign("jumpUrl","__APP__/Manager/register");
        $this->error($manager->getError());
      }
    }else{
      $this->assign("jumpUrl","__APP__/Manager/register");
      $this->error("name has already exist!");
    }
  }

  public function loginout(){
    Cookie::delete('username');
    Cookie::delete('usertype');
    Cookie::delete('lastlogintime');
    $this->assign("jumpUrl","__APP__/Index/index");
    $this->success("您已退出成功！");
  }

  public function index(){
    $usertype = Cookie::get('usertype');
    if ($usertype === 'Manager') {
      $user = new UserModel();
      $teacher = new TeacherModel();
      $course = new CourseModel();
      $school = new SchoolModel();

      $userlist = $user->select();
      $teacherlist = $teacher->select();
      $courselist = $course->select();
      $schoollist = $school->select();


      $username = Cookie::get('username');
      $usertype = Cookie::get('usertype');
      $lastlogintime = Cookie::get('lastlogintime');

      $this->assign('userlist',$userlist);
      $this->assign('teacherlist',$teacherlist);
      $this->assign('courselist',$courselist);
      $this->assign('schoollist',$schoollist);
    
      $this->assign('username',$username);
      $this->assign('usertype',$usertype);
      $this->assign('lastlogintime',$lastlogintime);
      $this->display();
    }elseif ($usertype === 'teacher') {
      $this->assign("jumpUrl","__APP__/Teacher/login");
    }else{
      $this->assign("jumpUrl","__APP__/Index/index");
      $this->success("正在转向首页");
    }
    
  }

  public function deleteuser(){
    $user = new UserModel();
    $id = $_GET['id'];
    if ($user->where("user_id='$id'")->delete()) {
      $this->assign("jumpUrl","__APP__/Manager/index");
      $this->success("delete student success!");
    }else{
      $this->assign("jumpUrl","__APP__/Manager/index");
      $this->error("delete student failed!");
    }
  }

  public function deleteteacher(){
    $teacher = new TeacherModel();
    $id = $_GET['id'];
    if ($teacher->where("teacher_id='$id'")->delete()) {
      $this->assign("jumpUrl","__APP__/Manager/index");
      $this->success("delete teacher success!");
    }else{
      $this.assign("jumpUrl","__APP__/Manager/index");
      $this.error("delete teacher failed!");
    }
  }
  public function deletecourse(){
    $course = new CourseModel();
    $id = $_GET['id'];
    if ($course->where("course_id='$id'")->delete()) {
      $this->assign("jumpUrl","__APP__/Manager/index");
      $this->success("delete course success");
    }else{
      $this->assign("jumpUrl","__APP__/Manager/index");
      $this->error("delete course failed!");
    }
  }
  public function deleteschool(){
    $school = new SchoolModel();
    $id = $_GET['id'];
    if ($school->where("school_id='$id'")->delete()) {
      $this->assign("jumpUrl","__APP__/Manager/index");
      $this->success("delete school success");
    }else{
      $this->assign("jumpUrl","__APP__/Manager/index");
      $this->error("delete school failed!");
    }
  }

  public function addcourse(){
    $username = Cookie::get('username');
    $usertype = Cookie::get('usertype');
    $userid = Cookie::get('userid');

    $school = new SchoolModel();
    $teacher = new TeacherModel();

    $schoollist = $school->select();
    $teacherlist = $teacher->select();

    $this->assign('schoollist',$schoollist);
    $this->assign('teacherlist',$teacherlist);
    $this->assign('username',$username);
    $this->assign('usertype',$usertype);
    $this->assign('userid',$userid);
    $this->display();
  }

  public function addteacher(){
    $username = Cookie::get('username');
    $usertype = Cookie::get('usertype');
    $userid = Cookie::get('userid');

    $this->assign('username',$username);
    $this->assign('usertype',$usertype);
    $this->assign('userid',$userid);
    $this->display();
  }

  public function addschool(){
    $username = Cookie::get('username');
    $usertype = Cookie::get('usertype');
    $userid = Cookie::get('userid');

    $this->assign('username',$username);
    $this->assign('usertype',$usertype);
    $this->assign('userid',$userid);
    $this->display();
  }

  public function addstudent(){
    $username = Cookie::get('username');
    $usertype = Cookie::get('usertype');
    $userid = Cookie::get('userid');

    $this->assign('username',$username);
    $this->assign('usertype',$usertype);
    $this->assign('userid',$userid);
    $this->display();
  }
}
?>