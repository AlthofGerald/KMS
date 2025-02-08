<?php

namespace App\Controllers\Knowledge;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoryModel;
use App\Models\KnowledgeModel;

class CategoryController extends BaseController
{
    protected CategoryModel $categoryModel;
    protected KnowledgeModel $knowledgeModel;

    // construct this construct that
    public function __construct()
    {
        $this->categoryModel = new CategoryModel;
        $this->knowledgeModel = new KnowledgeModel;
    }

    // show category table 
    public function index()
    {
        $itemPerPage = 20;


        $categories = $this->categoryModel
            ->select('kategori.*')

            ->paginate($itemPerPage, 'categories');

        $knowledgeCountInCategories = [];

        foreach ($categories as $category) {
            array_push($knowledgeCountInCategories, $this->knowledgeModel
                ->where('idkategori', $category['idkategori'])
                ->countAllResults());
        }


        $data = [
            'category'     =>  $categories,
            'knowledgeCountInCategories' => $knowledgeCountInCategories,
            'pager'         => $this->categoryModel->pager,
            'currentPage'   => $this->request->getVar('') ?? 1,
            'itemPerPage'   => $itemPerPage,

        ];

        return view('category/index', $data);
    }

    // as the name suggest i don't think it need some detail just like a knowledge do only a card body 
    // kohi and pasta
    // consider its done

    // show all knowledge that related to category selected
    public function show()
    {
        // later
    }


    // return form input and get the data using validation services
    public function new()
    {

        return view('category/create', [
            'validation' => \Config\Services::validation(),
        ]);
    }

    // insert new category from validation data 
    public function create()
    {
        if (!$this->validate([
            'category'  => 'required|string|min_length[2]',
        ])) {
            $data = [
                'validation' => \Config\Services::validation(),
                'oldInput'   => $this->request->getVar(),
            ];

            return view('category/create', $data);
        }

        if (!$this->categoryModel->save([
            'namakategori' => $this->request->getVar('category'),
        ])) {
            $data = [
                'validation' => \Config\Services::validation(),
                'oldInput'   => $this->request->getVar(),
            ];

            session()->setFlashdata(['msg' => 'Insert failed']);
            return view('category/create', $data);
        }

        session()->setFlashdata(['msg' => 'Insert new category successful']);
        return redirect()->to('KMS/knowledgecategory');
    }


    // return form input and get the data using validation service again
    public function edit($id = null)
    {
        // showing edit input form
        $category = $this->categoryModel->where('idkategori', $id)->first();

        if (empty($category)) {
            throw new PageNotFoundException('Category not found');
        }

        $data = [
            'category'       => $category,
            'validation'     => \Config\Services::validation(),
        ];

        return view('category/update', $data);
    }


    // update the category
    public function update($id = null)
    {
        $category = $this->categoryModel->where('idkategori', $id)->first();

        if (empty($category)) {
            throw new PageNotFoundException('Category not found');
        }

        if (!$this->validate([
            'category'  => 'required|string|min_length[2]',
        ])) {
            $data = [
                'category'   => $category,
                'validation' => \Config\Services::validation(),
                'oldInput'   => $this->request->getVar(),
            ];

            return view('category/edit', $data);
        }

        if (!$this->categoryModel->save([
            'idkategori'   => $id,
            'namakategori' => $this->request->getVar('category'),
        ])) {
            $data = [
                'category'   => $category,
                'validation' => \Config\Services::validation(),
                'oldInput'   => $this->request->getVar(),
            ];

            session()->setFlashdata(['msg' => 'Insert failed']);
            return view('category/create', $data);
        }

        session()->setFlashdata(['msg' => 'Update category successful']);
        return redirect()->to('KMS/knowledgecategory');
    }


    // TERMINATE!!!
    public function delete($id = null)
    {
        $category = $this->categoryModel->where('idkategori', $id)->first();

        if (empty($category)) {
            throw new PageNotFoundException('Category not found');
        }

        if (!$this->categoryModel->delete($id)) {
            session()->setFlashdata(['msg' => 'Failed to delete category', 'error' => true]);
            return redirect()->back();
        }

        session()->setFlashdata(['msg' => 'Category deleted successfully']);
        return redirect()->to('KMS/knowledgecategory');
    }

    // what if there's knowledge that have id category that have been deleted? its simply not showing the name but only an id
    // the only solution it can do is to update the knowledge and change to existing category
}
