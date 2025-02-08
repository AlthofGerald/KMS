<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoryModel;
use App\Models\KnowledgeModel;



class DashboardController extends BaseController
{
    protected KnowledgeModel $knowledgeModel;
    protected CategoryModel $categoryModel;


    public function __construct()
    {
        $this->knowledgeModel = new KnowledgeModel;
        $this->categoryModel = new CategoryModel;
    }

    public function index()
    {

        return redirect('KMS/dashboard');
    }

    public function dashboard()
    {
        $data = array_merge(
            $this->getAllKnowledge(),
            $this->getSummaries(),
        );
        return view('Dashboard/index', $data);
    }

    public function getSummaries(): array
    {
        return [

            'totalKnowledge'        => $this->knowledgeModel->findAll(),
            'totalCategories'       => $this->categoryModel->findAll(),
        ];
    }
    public function getAllKnowledge(): array
    {
        $itemPerPage = 20;

        if ($this->request->getGet('search')) {
            $keyword = $this->request->getGet('search');
            $knowledges = $this->knowledgeModel
                ->select('knowledge.*, users.username as user, kategori.namakategori')
                ->join('users', 'knowledge.iduser = users.id', 'LEFT')
                ->join('kategori', 'knowledge.idkategori = kategori.idkategori', 'LEFT')
                ->where('knowledge.status', TRUE)
                ->like('knowledgetitle', $keyword, insensitiveSearch: true)
                ->orLike('knowledge.slug', $keyword, insensitiveSearch: true)
                ->orLike('bidang', $keyword, insensitiveSearch: true)
                ->orLike('kategori.namakategori', $keyword, insensitiveSearch: true)
                ->orLike('users.username', $keyword, insensitiveSearch: true)
                ->paginate($itemPerPage, 'knowledges');
        } else {
            $knowledges = $this->knowledgeModel
                ->select('knowledge.*, users.username as user, kategori.namakategori as namakategori')
                ->join('users', 'knowledge.iduser = users.id', 'LEFT')
                ->join('kategori', 'knowledge.idkategori = kategori.idkategori', 'LEFT')
                ->where('knowledge.status', TRUE)
                ->paginate($itemPerPage, 'knowledges');
           
        }
         $data = [
            'knowledge'     => $knowledges,
            'pager'         => $this->knowledgeModel->pager,
            'currentPage'   => $this->request->getVar('') ?? 1,
            'itemPerPage'   => $itemPerPage,
             ];

        

        return ($data);
    }

    public function showbidang()
    {
        $itemPerPage = 20;
        $bidang = $this->request->getGet('bidang');
        $text = "Bidang Pengetahuan ";
        $pilih = $text . $bidang;
        if ($this->request->getGet('bidang')) {
            $keyword = $this->request->getGet('bidang');
            $knowledges = $this->knowledgeModel
                ->select('knowledge.*, users.username as user, kategori.namakategori')
                ->join('users', 'knowledge.iduser = users.id', 'LEFT')
                ->join('kategori', 'knowledge.idkategori = kategori.idkategori', 'LEFT')
                ->where('bidang', $keyword)
                ->where('knowledge.status', TRUE)
                ->paginate($itemPerPage, 'knowledges');
            $data = [
                'knowledge'     => $knowledges,
                'pager'         => $this->knowledgeModel->pager,
                'currentPage'   => $this->request->getVar('') ?? 1,
                'itemPerPage'   => $itemPerPage,
                'search'        => $pilih,
            ];
        } else {
            $knowledges = $this->knowledgeModel
                ->select('knowledge.*, users.username as user, kategori.namakategori as namakategori')
                ->join('users', 'knowledge.iduser = users.id', 'LEFT')
                ->join('kategori', 'knowledge.idkategori = kategori.idkategori', 'LEFT')
                ->where('knowledge.status', TRUE)
                ->paginate($itemPerPage, 'knowledges');

            $data = [
                'knowledge'     => $knowledges,
                'pager'         => $this->knowledgeModel->pager,
                'currentPage'   => $this->request->getVar('') ?? 1,
                'itemPerPage'   => $itemPerPage,
                'search'        => "Pilih bidang pengetahuan"
            ];
        }


        return view('Dashboard/bidang', $data);
    }
}
