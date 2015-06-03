<?php
// 本类由系统自动生成，仅供测试用途
import('ORG.Util.Cookie');
class IndexAction extends Action {
    public function insert(){
      $content = new ContentModel();
      $result = $content->create();
      if (!$result) {
        $this->assign("jumpUrl","__URL__/index");
        $this->error($content->getError());
      }else{
        $content->$userid == Cookie::get('userid');
        $content->add();
        $this->assign("jumpUrl","__URL__/index");
        $this->success("添加成功！");
      }
    }

    public function index(){

      $username = Cookie::get('username');
      $usertype = Cookie::get('usertype');
      $userid = Cookie::get('userid');

      $this->assign('usertype',$usertype);
      $this->assign('username',$username);
      $this->assign('userid',$userid);
      $this->display();
    }

    public function delete(){
      $content = new ContentModel();
      $id = $_GET['id'];
      if ($content->where("id=$id")->delete()) {
        $this->assign("jumpUrl","__URL__/index");
        $this->success('删除成功！');
      }else{
        $this->assign("jumpUrl","__URL__/index");
        $this->error('删除失败！');
      }
    }

    public function edit(){
      $content = new ContentModel();
      $id = $_GET['id'];
      if ($id != '' ) {
        $data = $content->where("id=$id")->select();
        if (!empty($data)) {
          $this->assign('data',$data);
        }else{
          echo "data is NULL!";
        }
      }
      $this->assign('title','edit page');
      $this->display();
    }

    public function update(){
      $content = new ContentModel();
      $id = $_POST['id'];
      if ($id != '') {
        $data['id'] = $id;
        $data['title'] = $_POST['title'];
        $data['content'] = $_POST['content'];
        if ($content->save($data)) {
          $this->assign("jumpUrl","__URL__/index");
          $this->success("更新数据成功！");
        }else{
          $this->assign("jumpUrl","__URL__/index");
          $this->success("更新数据失败！");
        }
      }else{
        echo "保存数据失败！";
      }
    }

}
?>