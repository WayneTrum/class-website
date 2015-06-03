<?php
import('ORG.Util.Cookie');
class CourseAction extends Action{
  public function addcourse(){
    $teacher = new TeacherModel();
    $school = new SchoolModel();
    $errorcourse = new CourseModel();

    $course_name = $_POST['course_name'];
    $course_score = $_POST['course_score'];
    $school_id = $_POST['school_id'];
    $teacher_id = $_POST['teacher_id'];

    $course = M('course');
    $schoolcourse = D("schoolcourse");

    $teacherlist = $teacher->where("teacher_id='$teacher_id'")->find();
    $schoollist = $school->where("school_id='$school_id'")->find();

    $id = rand(10000,20000);
    while ($course->where("course_id='$id'")->find()) {
       $id = $id - 1;
     }

    if (!empty($teacherlist) and !empty($schoollist)) {
      $data['course_id'] = $id;
      $data['course_name'] = $course_name;
      $data['course_score'] = $course_score;
      $data['course_teacher_id'] = $teacherlist['teacher_id'];
      $data['course_teacher_name'] = $teacherlist['teacher_name'];
      $result = $course->add($data);
      if ($result) {
        $schoolcourse->school_id = $school_id;
        $schoolcourse->course_id = $id;

        $resultScho = $schoolcourse->add();
        if ($resultScho) {
          if (Cookie::get('usertype') === 'Manager') {
            $this->assign("jumpUrl","__APP__/Manager/index");
            $this->success("添加课程成功！");
          }else{
            $this->assign("jumpUrl","__APP__/Course/index");
            $this->success("add course success!schoolcourse add success!");
          }
        }else{
          if (Cookie::get('usertype') === 'Manager') {
            $errorcourse->where("course_id='$id'")->delete();
            $this->assign("jumpUrl","__APP__/Manager/addcourse");
            $this->success("添加失败！");
          }else{
            $errorcourse->where("course_id='$id'")->delete();
            $this->assign("jumpUrl","__APP__/Course/add");
            $this->success("添加失败！");
          }
        }
      }else{
        if (Cookie::get('usertype') === 'Manager') {
          $errorcourse->where("course_id='$id'")->delete();
          $this->assign("jumpUrl","__APP__/Manager/addcourse");
          $this->success("添加失败！");
        }else{
          $errorcourse->where("course_id='$id'")->delete();
          $this->assign("jumpUrl","__APP__/Course/add");
          $this->success("添加失败！");
        }
      } 
    }else{
      if (Cookie::get('usertype') === 'Manager') {
        $errorcourse->where("course_id='$id'")->delete();
        $this->assign("jumpUrl","__APP__/Manager/addcourse");
        $this->success("添加失败！");
      }else{
        $errorcourse->where("course_id='$id'")->delete();
        $this->assign("jumpUrl","__APP__/Course/add");
        $this->success("添加失败！");
      }
    } 
  }

  public function add(){
    $teacher = new TeacherModel();
    $school = new SchoolModel();

    $teacherlist = $teacher->select();
    $schoollist = $school->select();

    $this->assign('teacherlist',$teacherlist);
    $this->assign('schoollist',$schoollist);
    $this->display();
  }

  public function index(){
    $course = new CourseModel();
    $school = new SchoolModel();

    $courselist = $course->select();
    $schoollist = $school->select();

    $username = Cookie::get('username');
    $usertype = Cookie::get('usertype');
    $userid = Cookie::get('userid');

    $this->assign('usertype',$usertype);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->assign('schoollist',$schoollist);
    $this->assign('courselist',$courselist);
    $this->display();
  }

  public function outSourse(){
    $this->display();
  }

  public function forschool(){
    $id = $_GET['id'];

    $schoolcourse = new SchoolcourseModel();
    $course = new CourseModel();
    $school = new SchoolModel();

    $list = array();

    $schoollist = $school->select();
    $thisschool = $school->where("school_id='$id'")->find();
    $schoolcourselist = $schoolcourse->where("school_id='$id'")->select();

    foreach ($schoolcourselist as $key) {
      $course_id = $key['course_id'];
      $result = $course->where("course_id='$course_id'")->find();
      if ($result) {
        $list[] = $result;
      }
    }

    $this->assign('schoollist',$schoollist);
    $this->assign('school_name',$thisschool['school_name']);
    $this->assign('list',$list);
    $this->display();
  }

  public function test(){
    $course = new CourseModel();
    $school = new SchoolModel();

    $courselist = $course->select();
    $schoollist = $school->select();

    $this->assign('schoollist',$schoollist);
    $this->assign('courselist',$courselist);
    $this->display();
  }
}
?>