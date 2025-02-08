<?php

namespace App\Controllers\Knowledge;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\CommentModel;
use App\Models\KnowledgeModel;
use CodeIgniter\HTTP\ResponseInterface;

class ExplicitController extends BaseController
{
    protected KnowledgeModel $knowledgeModel;
    protected CategoryModel $categoryModel;
    protected CommentModel $commentModel;

    public function __construct()
    {
        $this->knowledgeModel = new KnowledgeModel;
        $this->categoryModel = new CategoryModel;
        $this->commentModel = new CommentModel;

        // #helper('upload');
    }


    public function index()
    {
        $itemPerPage = 20;
        $Type = "Explicit";

        $knowledges = $this->knowledgeModel
            ->select('knowledge.*, users.username as user, kategori.namakategori')
            ->join('users', 'knowledge.iduser = users.id', 'RIGHT')
            ->join('kategori', 'knowledge.idkategori = kategori.idkategori', 'RIGHT')
            ->where('knowledgetype', 'explicit')
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

    public function showmyexplicit()
    {
        $itemPerPage = 20;
        $userid = auth()->id();

        $knowledges = $this->knowledgeModel
            ->select('knowledge.*, users.username as user, kategori.namakategori')
            ->join('users', 'knowledge.iduser = users.id', 'RIGHT')
            ->join('kategori', 'knowledge.idkategori = kategori.idkategori', 'LEFT')
            ->where('knowledgetype', 'explicit')
            ->where('iduser', $userid)
            ->paginate($itemPerPage, 'knowledges');


        $data = [
            'knowledge'     => $knowledges,
            'pager'         => $this->knowledgeModel->pager,
            'currentPage'   => $this->request->getVar('') ?? 1,
            'itemPerPage'   => $itemPerPage,

        ];

        return view('knowledge/myexplicit', $data);
    }

    // don't forget about the comment section
    public function explicitdetail()
    {
        $itemPerPage = 20;
        $userid = auth()->id();

        $knowledges = $this->knowledgeModel
            ->select('knowledge.*')
            ->where('knowledgetype', 'explicit')
            ->where('iduser', $userid)
            ->paginate($itemPerPage, 'knowledges');


        $data = [
            'knowledge'     => $knowledges,
            'pager'         => $this->knowledgeModel->pager,
            'currentPage'   => $this->request->getVar('') ?? 1,
            'itemPerPage'   => $itemPerPage,

        ];

        return view('knowledge/myexplicit', $data);
    }

    // as the function name suggest, and it needs some helper to upload some file unlike tacit. Maybe will be the most chalanging part 
    // how to request to download a file again? one more chalanging part
    // life is kuyashi
    // brain implosion energy
    // tens of thousands of caffein 
    // nah nah nah you shouldn't
    public function newexplicit()
    {
        $categories = $this->categoryModel->findAll();
        $data = [
            'categories' => $categories,
            'validation' => \Config\Services::validation(),
        ];

        return view('knowledge/createexplicit', $data);
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

            return view('knowledge/createexplicit', $data);
        }
        $userid = auth()->id();
        $slug = url_title($this->request->getVar('knowledgetitle') . ' ' . rand(0, 1000), '-', true);

        $gambar = $this->request->getFile('gambar');
        if ($gambar->getError() == 4) {
            $namagambar = 'default.jpg';
        } else {
            $namagambar = $gambar->getName();
            $gambar->move('uploads');
        }

        $file = $this->request->getFile('file');
        if ($file->getError() == 4) {
            $namafile = 'default.jpg';
        } else {
            $namafile = $file->getName();
            $file->move('uploads');
        }

        $video = $this->request->getFile('video');
        if ($video->getError() == 4) {
            $namavideo = 'default.jpg';
        } else {
            $namavideo = $file->getName();
            $video->move('uploads');
        }



        if (!$this->knowledgeModel->save([
            'slug' => $slug,
            'knowledgetype' => 'explicit',
            'knowledgetitle' => $this->request->getVar('knowledgetitle'),
            'idkategori'  => $this->request->getVar('category'),
            'knowledgecontent'       => $this->request->getVar('isi'),
            'status' => FALSE,
            'bidang' => $this->request->getVar('bidang'),
            'iduser' => $userid,
            'file' => $namafile,
            'gambar' => $namagambar,
            'video' => $namavideo,
        ])) {
            $categories = $this->categoryModel->findAll();


            $data = [
                'categories' => $categories,
                'validation' => \Config\Services::validation(),
                'oldInput'   => $this->request->getVar(),
            ];

            session()->setFlashdata(['msg' => 'Insert failed']);
            return view('knowledge/createexplicit', $data);
        }

        session()->setFlashdata(['msg' => 'Insert new knowledge successful']);
        return redirect()->to('KMS/myexplicit');
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

        return view('knowledge/editexplicit', $data);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */

    public function update($slug = null)
    {
        $knowledge = $this->knowledgeModel->where('slug', $slug)->first();

        if (empty($knowledge)) {
            throw new PageNotFoundException('Knowledge with slug \'' . $slug . '\' not found');
        }

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

        $gambar = $this->request->getFile('gambar');
        if ($gambar->getError() == 4) {
            $namagambar = $this->request->getVar('gambarlama');
        } else {
            $namagambar = $gambar->getName();
            $gambar->move('uploads');
            unlink('uploads/' . $this->request->getVar('gambarlama'));
        }

        $file = $this->request->getFile('file');
        if ($file->getError() == 4) {
            $namafile = $this->request->getVar('filelama');
        } else {
            $namafile = $file->getName();
            $file->move('uploads');
            unlink('uploads/' . $this->request->getVar('filelama'));
        }

        $video = $this->request->getFile('video');
        if ($video->getError() == 4) {
            $namavideo = $this->request->getVar('videolama');
        } else {
            $namavideo = $file->getName();
            $video->move('uploads');
            unlink('uploads/' . $this->request->getVar('videolama'));
        }




        if (!$this->knowledgeModel->save([
            'idknowledge' => $knowledge['idknowledge'],
            'slug' => $slugbaru,
            'knowledgetype' => 'explicit',
            'knowledgetitle' => $this->request->getVar('knowledgetitle'),
            'idkategori'  => $this->request->getVar('category'),
            'knowledgecontent'       => $this->request->getVar('isi'),
            'status' => $knowledge['status'],
            'bidang' => $this->request->getVar('bidang'),
            'iduser' => $knowledge['iduser'],
            'file' => $namafile,
            'gambar' => $namagambar,
            'video' => $namavideo,
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
            return view('knowledge/editexplicit', $data);
        }

        session()->setFlashdata(['msg' => 'Update successful']);
        return redirect()->to('KMS/myexplicit');
    }



    public function delete($slug = null)
    {
        $knowledge = $this->knowledgeModel->where('slug', $slug)->first();

        if ($knowledge['file'] != 'default.jpg') {
            unlink('uploads/' . $knowledge['file']);
        }
        if ($knowledge['gambar'] != 'default.jpg') {
            unlink('uploads/' . $knowledge['gambar']);
        }
        if ($knowledge['video'] != 'default.jpg') {
            unlink('uploads/' . $knowledge['video']);
        }


        if (empty($knowledge)) {
            throw new PageNotFoundException('Knowledge with slug \'' . $slug . '\' not found');
        }



        if (!$this->knowledgeModel->delete($knowledge['idknowledge'])) {
            session()->setFlashdata(['msg' => 'Failed to delete knowledge', 'error' => true]);
            return redirect()->back();
        }

        session()->setFlashdata(['msg' => 'Knowledge deleted successfully']);
        return redirect()->to('KMS/myexplicit');
    }
}
