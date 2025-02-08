<?php

namespace App\Controllers\Comment;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CommentModel;
use App\Models\KnowledgeModel;

class CommentController extends BaseController
{
    protected KnowledgeModel $knowledgeModel;
    protected CommentModel $commentModel;

    public function __construct()
    {
        $this->knowledgeModel = new KnowledgeModel;
        $this->commentModel = new CommentModel;

        #helper('upload');
    }


    // get rid of html simbol <> </div> etc
    public function antihtml($text)
    {
        return $id = stripslashes(strip_tags(htmlspecialchars($text, ENT_QUOTES)));
    }


    public function addComment($idknowledge, $slugknowledge)
    {
        $userid = auth()->id();

        if (!$this->commentModel->save([
            'idknowledge'        => $idknowledge,
            'replyid'            => $this->request->getVar('replyid'),
            'iduser'             => $userid,
            'commentcontent'     => antihtml($this->request->getVar('commentcontent')),

        ])) {
            session()->setFlashdata(['msg' => 'Insert failed']);
            return redirect()->to("KMS/detailknowledge/$slugknowledge");
        }

        session()->setFlashdata(['msg' => 'Insert new knowledge successful']);
        return redirect()->to("KMS/detailknowledge/$slugknowledge");
    }

    public function getAllComment($idknowledge)
    {
        $comments = $this->commentModel->select('comment.*')->where('idknowledge', $idknowledge)-;
        foreach ($comments as $row) {
            $data[] = $row;
        }
        return ($data);
    }

    public function getComment($idknowledge)
    {
        $containall = array();
        $comments = $this->getAllComment($idknowledge);
        foreach ($comments as $comment_id) {
            array_push($containall, $comment_id['replyid']);
        }

        return ($this->showComment(0, $idknowledge, $containall));
    }

    public function getReply2($idcomment, $idknowledge)
    {
        // $output = '';
        // $query = $this->commentModel->select('comment.*')->where('replyid', '?');
        // $dewan1 = $db1->prepare($query);
        // $dewan1->bind_param("s", $idcomment);
        // $dewan1->execute();
        // $res1 = $dewan1->get_result();

        // if ($count > 0) {
        //     while ($row = $res1->fetch_assoc()) {
        //         $output .= '<div class="p-4 rounded-4 text-bg-light mb-3 ms-7">
        //       <div class="d-flex align-items-center gap-3">

        //           <h6 class="mb-0 fs-4">' . $comments["iduser"] . '</h6>
        //           <span class="p-1 text-bg-muted rounded-circle d-inline-block"></span>
        //       </div>
        //       <p' . $comments["comment"] . '
        //       </p>
        //   </div>';
        //     }
        //     return $output;
        // }
    }
    function getReply($idknowledge, $replyid)
    {
        $result = $this->commentModel->select('comment.*')->where('idknowledge', $idknowledge)->where('replyid', $replyid)->result_array();
        foreach ($result as $row) {
            $data[] = $row;
        }
        return $data;
    }


    public function showComment($replyid, $idknowledge, $containall)
    {
        $html = '';
        if (in_array($replyid, $containall)) {
            $result = $this->getReply($idknowledge, $replyid);
            $html .= '<p>' . $result['commentcontent'] . '</p>';
        }
        return $html;
    }







    // public function threadComment1($idknowledge)
    // {
    //     $store_all_id = array();
    //     $result = $this->commentModel->select('comment.*')
    //         ->where('idknowledge', $idknowledge);

    //     return  $this->showComment1(0, $idknowledge, $store_all_id);
    // }


    // public function showComment1($sortComment, $idknowledge, $store_all_id)
    // {
    //     $html = "";

    //     if (in_array($sortComment, $store_all_id)) {
    //         $result = $this->getCommentReply1($idknowledge, $sortComment);
    //         $html .= $sortComment == 0 ? " <p> Tidak ada balasan komen cuy" : "</p>";
    //         foreach ($result as $re) {
    //             // $html .= " <li class='comment_box'>
    //             // <div class='aut'>" . $re['iduser'] . "</div>

    //             // <div class='comment-body'>" . $re['comment'] . "</div>
    //             // <div class='timestamp'>" . date("F j, Y", $re['created_at']) . "</div>
    //             // <a  href='#comment_form' class='reply' id='" . $re['comment_id'] . "'>Replay </a>";
    //             // $html .= $this->in_parent($re['comment_id'], $ne_id, $store_all_id);
    //             $html .= "TEST TEST";
    //         }
    //         $html .=  "TEST";
    //     }
    //     return $html;
    // }

    // public function getComment1($idknowledge = null)
    // {
    //     $result = $this->commentModel->select('comment.*')
    //         ->where('idknowledge', $idknowledge);
    //     foreach ($result as $row) {
    //         $data[] = $row;
    //     }
    //     return $data;
    // }


    // public function getCommentReply1($idknowledge = null, $idcomment = null)
    // {
    //     $result = $this->commentModel->select('comment.*')
    //         ->where('idknowledge', $idknowledge)
    //         ->where('replyid', $idcomment);
    //     foreach ($result as $row) {
    //         $data[] = $row;
    //     }
    //     return $data;
    // }


    // function addComment1($idknowledge, $slugknowledge)
    // {
    //     $userid = auth()->id();

    //     if (!$this->commentModel->save([
    //         'idknowledge'  => $idknowledge,
    //         'replyid'       => $this->request->getVar('replyid'),
    //         'iduser'        => $userid,
    //         'comment' => $this->request->getVar('comment'),

    //     ])) {
    //         session()->setFlashdata(['msg' => 'Insert failed']);
    //         return redirect()->to("KMS/detailknowledge/$slugknowledge");
    //     }

    //     session()->setFlashdata(['msg' => 'Insert new knowledge successful']);
    //     return redirect()->to("KMS/detailknowledge/$slugknowledge");
    // }
}
