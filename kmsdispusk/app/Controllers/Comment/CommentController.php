<?php

namespace App\Controllers\Comment;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CommentModel;
use App\Models\KnowledgeModel;
use CodeIgniter\Shield\Models\UserModel;

class CommentController extends BaseController
{
  protected KnowledgeModel $knowledgeModel;
  protected CommentModel $commentModel;

  public function __construct()
  {
    $this->knowledgeModel = new KnowledgeModel;
    $this->commentModel = new CommentModel();

    #helper('upload');
  }


  // get rid of html simbol <> </div> etc
  public function antihtml($text)
  {
    return $id = stripslashes(strip_tags(htmlspecialchars($text, ENT_QUOTES)));
  }


  public function addComment()
  {
    $userid = auth()->id();

    if (!$this->commentModel->save([
      'idknowledge'        => $this->request->getVar('idknowledge'),
      'replyid'            => $this->request->getVar('replyid'),
      'iduser'             => $userid,
      'commentcontent'     => $this->request->getVar('commentcontent'),

    ])) {
      session()->setFlashdata(['msg' => 'Insert failed']);

      return redirect()->back();
    }

    session()->setFlashdata(['msg' => 'Insert new knowledge successful']);

    return redirect()->back();
  }


  public function showComment($idknowledge)
  {
    $parentcomment = $this->getComment($idknowledge);

    $output = '';
    $userid = auth()->id();


    foreach ($parentcomment as $row) {
      $date = date('M, d-Y', strtotime($row['created_at']));
      if ($row['iduser'] == $userid) {
        $output .= '
      <div class="p-3 rounded-2 text-bg-light mb-3">
        <!-- name user -->
        <div class="d-flex align-items-center gap-2">
            <h6 class="mb-0 fs-5">' . $row["user"] . '</h6>
            <span class="p-1 text-bg-muted rounded-circle d-inline-block"></span>
            <p class="mb-0 fs-2 gap-1"> ' . $date . '</P>
        </div>
        <div class="d-flex gap-2 justify-content-end">
            <form action="' . base_url("KMS/deleteComment/{$row['idcomment']}") . '" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="validate" value="TRUE">
                <button type="submit" class="btn btn-outline-danger  " onclick="return confirm(`Are you sure?`);">
                    <i class="ti ti-delete"></i>
                    Hapus Komentar
                </button>
            </form>
        </div>
        
        

        <!-- content -->
        <p class="my-3">' . $row["commentcontent"] . '
        </p>

        <!-- reply button -->
       
        <hr>
        <form class="col-md-12" action="' . base_url('KMS/addComment') . '"  method="post">
          <div class="input-group mb-3">
          <input type="hidden" name="iduser" value="' .  $row["iduser"] . '">
          <input type="hidden" name="idknowledge" value="' . $row["idknowledge"] . '">
          <input type="hidden" name="replyid" value="' . $row["idcomment"] . '">
              <textarea type="text" name="commentcontent" class="form-control" placeholder="Balas komentar....." aria-label="" aria-describedby="basic-addon1"></textarea>
              <button class="btn bg-info-subtle text-info " type="submit">Kirim</button>
          </div>
        </form>
        <!end reply button -->

      </div>
        ';
      } else {
        $output .= '
        <div class="p-3 rounded-2 text-bg-light mb-3">
          <!-- name user -->
          <div class="d-flex align-items-center gap-2">
              <h6 class="mb-0 fs-5">' . $row["user"] . '</h6>
              <span class="p-1 text-bg-muted rounded-circle d-inline-block"></span>
              <p class="mb-0 fs-2 gap-1"> ' . $date . '</P>
          </div>
         
          
          
  
          <!-- content -->
          <p class="my-3">' . $row["commentcontent"] . '
          </p>
  
          <!-- reply button -->
         
          <hr>
          <form class="col-md-12" action="' . base_url('KMS/addComment') . '"  method="post">
            <div class="input-group mb-3">
            <input type="hidden" name="iduser" value="' .  $row["iduser"] . '">
            <input type="hidden" name="idknowledge" value="' . $row["idknowledge"] . '">
            <input type="hidden" name="replyid" value="' . $row["idcomment"] . '">
                <textarea type="text" name="commentcontent" class="form-control" placeholder="Balas komentar....." aria-label="" aria-describedby="basic-addon1"></textarea>
                <button class="btn bg-info-subtle text-info " type="submit">Kirim</button>
            </div>
          </form>
          <!end reply button -->
  
        </div>
          ';
      }


      $output .= $this->showReply($row["idcomment"]);
    }

    return ($output);
  }
  public function showReply($idknowledge)
  {
    $userid = auth()->id();
    $childcomment = $this->getreply($idknowledge);

    $output = '';
    foreach ($childcomment as $row) {
      $date = date('M, d-Y', strtotime($row['created_at']));
      if ($row['iduser'] == $userid) {
        $output .= '
        <div class="p-4 rounded-4 text-bg-light mb-3 ms-7">
                  <div class="d-flex align-items-center gap-3">
  
                      <h6 class="mb-0 fs-4">' . $row["user"] . '</h6>
                      <span class="p-1 text-bg-muted rounded-circle d-inline-block"></span>
                      <p class="mb-0 fs-2 gap-1"> ' . $date . '</P>
                      <div class="d-flex gap-2 justify-content-end">
                        <form action="' . base_url("KMS/deleteComment/{$row['idcomment']}") . '" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="validate" value="TRUE">
                            <button type="submit" class="btn btn-outline-danger  " onclick="return confirm(`Are you sure?`);">
                                <i class="ti ti-delete"></i>
                                Hapus Komentar
                            </button>
                        </form>
                    </div>
                  </div>
                  <p class="my-3">' . $row["commentcontent"] . '
                  </p>
        </div>';
      } else {
        $output .= '
        <div class="p-4 rounded-4 text-bg-light mb-3 ms-7">
                  <div class="d-flex align-items-center gap-3">
  
                      <h6 class="mb-0 fs-4">' . $row["user"] . '</h6>
                      <span class="p-1 text-bg-muted rounded-circle d-inline-block"></span>
                      <p class="mb-0 fs-2 gap-1"> ' . $row["created_at"] . '</P>
                      
                  </div>
                  <p class="my-3">' . $row["commentcontent"] . '
                  </p>
        </div>';
      }
    }

    return ($output);
  }

  public function getComment($idknowledge)
  {

    $comments = $this->commentModel->select('comment.*, users.username as user')
      ->join('users', 'comment.iduser = users.id', 'RIGHT')
      ->where('idknowledge', $idknowledge)
      ->where('replyid', 0)
      ->orderBy('idcomment', 'ASC')
      ->findAll();
    $newData = array();
    foreach ($comments as $item) {
      array_push($newData, ["idcomment" => $item['idcomment'], "idknowledge" => $item['idknowledge'], "iduser" => $item['iduser'], "user" => $item['user'], "commentcontent" => $item['commentcontent'], "replyid" => $item['replyid'], "created_at" => $item['created_at']]);
    }
    return ($newData);
  }


  public function getreply($replyid)
  {
    $comments = $this->commentModel->select('comment.*, users.username as user')
      ->join('users', 'comment.iduser = users.id', 'RIGHT')
      ->where('replyid', $replyid)
      ->orderBy('replyid', 'ASC')
      ->findAll();
    $newData = array();
    foreach ($comments as $item) {
      array_push($newData, ["idcomment" => $item['idcomment'], "idknowledge" => $item['idknowledge'], "user" => $item['user'], "iduser" => $item['iduser'], "commentcontent" => $item['commentcontent'], "replyid" => $item['replyid'], "created_at" => $item['created_at']]);
    }
    return ($newData);
  }

  public function deleteComment($idcomment)
  {
    $comment = $this->commentModel->select('comment.*')->where('idcomment', $idcomment)->first();
    $deleted = "<em>This comment is deleted</em>";

    if (!$this->commentModel->save([
      'idcomment' => $comment['idcomment'],
      'commentcontent' => $deleted,
    ])) {

      session()->setFlashdata(['msg' => 'Delete failed']);
    }

    session()->setFlashdata(['msg' => 'Komentar telah dihapus']);
    return redirect()->back();
  }
}
