<?php

namespace App\Controllers\Knowledge;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\CommentModel;
use App\Models\KnowledgeModel;
use App\Controllers\Comment\CommentController;
use CodeIgniter\I18n\Time;
use CodeIgniter\HTTP\ResponseInterface;


class TacitController extends BaseController
{
    protected KnowledgeModel $knowledgeModel;
    protected CategoryModel $categoryModel;
    protected CommentModel $commentModel;
    protected CommentController $commentController;


    public function __construct()
    {
        $this->knowledgeModel = new KnowledgeModel;
        $this->categoryModel = new CategoryModel;
        $this->commentModel = new CommentModel;

        $this->commentController = new CommentController;


        #helper('upload');
    }


    public function index()
    {
        $itemPerPage = 20;
        $Type = "Tacit";


        $knowledges = $this->knowledgeModel
            ->select('knowledge.*, users.username as user, kategori.namakategori')
            ->join('users', 'knowledge.iduser = users.id', 'RIGHT')
            ->join('kategori', 'knowledge.idkategori = kategori.idkategori', 'LEFT')
            ->where('knowledgetype', 'tacit')
            ->where('knowledge.status', TRUE)
            ->paginate($itemPerPage, 'knowledges');


        $data = [
            'knowledge'     => $knowledges,
            'Type'          => $Type,
            'pager'         => $this->knowledgeModel->pager,
            'currentPage'   => $this->request->getVar('') ?? 1,
            'itemPerPage'   => $itemPerPage,
        ];

        return view('knowledge/index', $data);
    }

    public function showmytacit()
    {
        $itemPerPage = 20;
        $userid = auth()->id();

        $knowledges = $this->knowledgeModel
            ->select('knowledge.*, users.username as user, kategori.namakategori')
            ->join('users', 'knowledge.iduser = users.id', 'RIGHT')
            ->join('kategori', 'knowledge.idkategori = kategori.idkategori', 'RIGHT')
            ->where('knowledgetype', 'tacit')
            ->where('iduser', $userid)
            ->paginate($itemPerPage, 'knowledges');


        $data = [
            'knowledge'     => $knowledges,
            'pager'         => $this->knowledgeModel->pager,
            'currentPage'   => $this->request->getVar('') ?? 1,
            'itemPerPage'   => $itemPerPage,

        ];

        return view('knowledge/mytacit', $data);
    }

    public function show($slug = null)
    {


        $knowledge = $this->knowledgeModel->select('knowledge.*, users.username as user, kategori.namakategori')
            ->join('kategori', 'knowledge.idkategori = kategori.idkategori')
            ->join('users', 'knowledge.iduser = users.id', 'RIGHT')
            ->where('knowledge.slug', $slug)
            ->first();

        $idknowledge = $knowledge['idknowledge'];
        $view = $knowledge['viewcount'];
        $increaseview = $view + 1;

        $data = [

            'viewcount'    => $increaseview,
        ];

        $this->knowledgeModel->update($idknowledge, $data);




        if (empty($knowledge)) {
            throw new PageNotFoundException('Knowledge with slug \'' . $slug . '\' not found');
        }

        // $comments = $this->commentModel->select('comment.*')->where('idknowledge', $idknowledge);
        $comment = $this->commentController->showComment($idknowledge);

        $data = [
            'knowledge'      => $knowledge,
            'comment'       => $comment,
        ];
        return view('knowledge/showknowledge', $data);
    }

    public function newtacit()
    {
        $categories = $this->categoryModel->findAll();
        $data = [
            'categories' => $categories,
            'validation' => \Config\Services::validation(),
        ];

        return view('knowledge/createtacit', $data);
    }

    public function create()
    {
        if (!$this->validate([

            'knowledgetitle'     => 'required|string|max_length[127]',
            'category'  => 'numeric',

        ])) {
            $categories = $this->categoryModel->findAll();


            $data = [
                'categories' => $categories,
                // 'bidang'      => $bidang,
                'validation' => \Config\Services::validation(),
                'oldInput'   => $this->request->getVar(),
            ];

            return view('knowledge/createtacit', $data);
        }
        $userid = auth()->id();
        $slug = url_title($this->request->getVar('knowledgetitle') . ' ' . rand(0, 1000), '-', true);



        if (!$this->knowledgeModel->save([
            'slug' => $slug,
            'knowledgetype' => 'tacit',
            'knowledgetitle' => $this->request->getVar('knowledgetitle'),
            'idkategori'  => $this->request->getVar('category'),
            'knowledgecontent'       => $this->request->getVar('isi'),
            'status' => FALSE,
            'bidang' => $this->request->getVar('bidang'),
            'iduser' => $userid,
        ])) {
            $categories = $this->categoryModel->findAll();


            $data = [
                'categories' => $categories,
                'validation' => \Config\Services::validation(),
                'oldInput'   => $this->request->getVar(),
            ];

            session()->setFlashdata(['msg' => 'Insert failed']);
            return view('knowledge/createtacit', $data);
        }

        session()->setFlashdata(['msg' => 'Insert new knowledge successful']);
        return redirect()->to('KMS/mytacit');
    }

    public function edit($slug = null)
    {
        $knowledge = $this->knowledgeModel
            ->select('knowledge.*, kategori.namakategori as namakategori')
            ->join('kategori', 'knowledge.idkategori = kategori.idkategori', 'LEFT')
            ->where('knowledge.slug', $slug)->first();

        if (empty($knowledge)) {
            throw new PageNotFoundException('Book with slug \'' . $slug . '\' not found');
        }

        $categories = $this->categoryModel->findAll();


        $data = [
            'knowledge'       => $knowledge,
            'categories' => $categories,
            'validation' => \Config\Services::validation(),
        ];

        return view('knowledge/edittacit', $data);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */



    public function update($slug = null)
    {
        $knowledge = $this->knowledgeModel->where('slug', $slug)->first();

        // if (empty($knowledge)) {
        //     throw new PageNotFoundException('Knowledge with slug \'' . $slug . '\' not found');
        // }

        // if (!$this->validate([
        //     // 'cover'     => 'is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[cover,5120]',
        //     // 'title'     => 'required|string|max_length[127]',
        //     // 'author'    => 'required|alpha_numeric_punct|max_length[64]',
        //     // 'publisher' => 'required|string|max_length[64]',
        //     // 'isbn'      => 'required|numeric|min_length[10]|max_length[13]',
        //     // 'year'      => 'required|numeric|min_length[4]|max_length[4]|less_than_equal_to[2100]',
        //     // 'rack'      => 'required|numeric',
        //     // 'category'  => 'required|numeric',
        //     // 'stock'     => 'required|numeric|greater_than_equal_to[1]',
        // ])) {
        //     $categories = $this->categoryModel->findAll();

        //     $data = [
        //         'knowledge'       => $knowledge,
        //         'categories' => $categories,
        //         'validation' => \Config\Services::validation(),
        //         'oldInput'   => $this->request->getVar(),
        //     ];

        //     return view('knowledge/edittacit', $data);
        // }

        //    getting new file if the user not upload a new file then it will keep the previous file (tho its not used in tacit knowledge)
        // $coverImage = $this->request->getFile('cover');

        // if ($coverImage->getError() == 4) {
        //     $coverImageFileName = $book['book_cover'];
        // } else {
        //     $coverImageFileName = updateBookCover(
        //         newCoverImage: $coverImage,
        //         formerCoverImageFileName: $book['book_cover']
        //     );
        // }


        $slugbaru = $this->request->getVar('knowledgetitle') != $knowledge['knowledgetitle']
            ? url_title($this->request->getVar('knowledgetitle') . ' ' . rand(0, 1000), '-', true)
            : $knowledge['slug'];

        if (!$this->knowledgeModel->save([
            'idknowledge' => $knowledge['idknowledge'],
            'slug' => $slugbaru,
            'knowledgetype' => 'tacit',
            'knowledgetitle' => $this->request->getVar('knowledgetitle'),
            'idkategori'  => $this->request->getVar('category'),
            'knowledgecontent'       => $this->request->getVar('isi'),
            'status' => $knowledge['status'],
            'bidang' => $this->request->getVar('bidang'),
            'iduser' => $knowledge['iduser'],
        ])) {
            // if fail to save 
            $categories = $this->categoryModel->findAll();

            $data = [
                'knowledge'       => $knowledge,
                'categories' => $categories,

                'validation' => \Config\Services::validation(),
                'oldInput'   => $this->request->getVar(),
            ];

            session()->setFlashdata(['msg' => 'Update failed']);
            return view('knowledge/edittacit', $data);
        }

        session()->setFlashdata(['msg' => 'Update successful']);
        return redirect()->to('KMS/mytacit');
    }

    public function delete($slug = null)
    {
        $knowledge = $this->knowledgeModel->where('slug', $slug)->first();

        if (empty($knowledge)) {
            throw new PageNotFoundException('Knowledge with slug \'' . $slug . '\' not found');
        }



        if (!$this->knowledgeModel->delete($knowledge['idknowledge'])) {
            session()->setFlashdata(['msg' => 'Failed to delete knowledge', 'error' => true]);
            return redirect()->back();
        }

        session()->setFlashdata(['msg' => 'Knowledge deleted successfully']);
        return redirect()->to('KMS/mytacit');
    }

    public function upload_image()
    {
        helper(['form', 'url']);

        $file = $this->request->getFile('file');

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);

            $image_url = base_url('uploads/' . $newName);
            return $this->response->setJSON(['url' => $image_url]);
        } else {
            return $this->response->setJSON(['error' => $file->getErrorString()]);
        }
        // $file = $this->request->getFile('image');

        // if ($file->isValid() && !$file->hasMoved()) {
        //     $newName = $file->getRandomName();
        //     $file->move('./uploads', $newName);

        //     $imageUrl = base_url('uploads/' . $newName);

        //     return $this->response->setJSON(['url' => $imageUrl]);
        // } else {
        //     return $this->response->setStatusCode(400)->setJSON(['error' => $file->getErrorString()]);
        // }
    }
    function uploadGambar()
    {
        if ($this->request->getFile('file')) {
            $dataFile = $this->request->getFile('file');
            $fileName = $dataFile->getRandomName();
            $dataFile->move("uploads/berkas/", $fileName);
            echo base_url("uploads/berkas/$fileName");
        }
    }

    function deleteGambar()
    {
        $src = $this->request->getVar('src');
        //--> uploads/berkas/1630368882_e4a62568c1b50887a8a5.png

        //https://localhost/ci4summernote/public
        if ($src) {
            $file_name = str_replace(base_url() . "/", "", $src);

            if (unlink('uploads/berkas/' . $src)) {
                echo "Delete file berhasil";
            }
        }
    }
}
