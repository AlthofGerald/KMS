<?php

namespace App\Controllers\Knowledge;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\KnowledgeModel;
use CodeIgniter\HTTP\ResponseInterface;
use SebastianBergmann\Type\TrueType;

class ValidateKnowledgeController extends BaseController
{
    protected KnowledgeModel $knowledgeModel;
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->knowledgeModel = new KnowledgeModel;
        $this->categoryModel = new CategoryModel;

        #helper('upload');
    }
    public function index()
    {
        $itemPerPage = 20;
        $Type = 'Belum Terverifikasi';


        $knowledges = $this->knowledgeModel
            ->select('knowledge.*, kategori.namakategori')
            ->join('kategori', 'knowledge.idkategori = kategori.idkategori', 'LEFT')
            ->where('status', 'FALSE')
            ->paginate($itemPerPage, 'knowledges');


        $data = [
            'knowledge'     => $knowledges,
            'pager'         => $this->knowledgeModel->pager,
            'Type'          => $Type,
            'currentPage'   => $this->request->getVar('') ?? 1,
            'itemPerPage'   => $itemPerPage,

        ];

        return view('validate/index', $data);
    }

    public function validating($slug = null)
    {
        $knowledge = $this->knowledgeModel->select('knowledge.*')->where('slug', $slug)->first();
        if (empty($knowledge)) {
            throw new PageNotFoundException('Knowledge with slug \'' . $slug . '\' not found');
        }

        if (!$this->knowledgeModel->save([
            'idknowledge' => $knowledge['idknowledge'],
            'status' => TRUE,
        ])) {

            session()->setFlashdata(['msg' => 'Validating failed']);
        }

        session()->setFlashdata(['msg' => 'Pengetahuan berhasil divalidasi']);
        return redirect()->to("KMS/unverified");
    }
}
