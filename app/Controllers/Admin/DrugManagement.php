<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DrugModel;
use App\Models\DrugCategoryModel;
use App\Models\DrugApprovalModel;

class DrugManagement extends BaseController
{
    protected $drugModel;
    protected $drugCategoryModel;
    protected $drugApprovalModel;

    public function __construct()
    {
        $this->drugModel = new DrugModel();
        $this->drugCategoryModel = new DrugCategoryModel();
        $this->drugApprovalModel = new DrugApprovalModel();
    }

    public function index()
    {
        $data['drugs'] = $this->drugModel->paginate(10);
        $data['categories'] = $this->drugCategoryModel->findAll();
        $data['total_drugs'] = $this->drugModel->countAll();
        $data['pager'] = $this->drugModel->pager;

        return view('admin/drug_management/index', $data);
    }

    public function categories()
    {
        $data['categories'] = $this->drugCategoryModel->findAll();
        return view('admin/drug_management/categories', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'category' => 'required|numeric',
                'description' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'status' => 'required|in_list[active,inactive,pending]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = $this->request->getPost();
            $data['image'] = $this->handleImageUpload();

            if ($this->drugModel->insert($data)) {
                return redirect()->to('/admin/drugs')->with('success', 'Drug added successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to add drug');
            }
        }

        $data['categories'] = $this->drugCategoryModel->findAll();
        return view('admin/drug_management/add', $data);
    }

    public function edit($id)
    {
        $drug = $this->drugModel->find($id);

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'category' => 'required|numeric',
                'description' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'status' => 'required|in_list[active,inactive,pending]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = $this->request->getPost();
            
            if ($this->request->getFile('image')->isValid()) {
                $data['image'] = $this->handleImageUpload();
            }

            if ($this->drugModel->update($id, $data)) {
                return redirect()->to('/admin/drugs')->with('success', 'Drug updated successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update drug');
            }
        }

        $data['drug'] = $drug;
        $data['categories'] = $this->drugCategoryModel->findAll();
        return view('admin/drug_management/edit', $data);
    }

    public function delete($id)
    {
        if ($this->drugModel->delete($id)) {
            return redirect()->to('/admin/drugs')->with('success', 'Drug deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete drug');
        }
    }

    public function pendingApprovals()
    {
        //$data['pending_approvals'] = $this->drugApprovalModel->getPendingApprovals(); //Removed
        $drugModel = new DrugModel();
        $pendingDrugs = $drugModel->where('is_approved', 0)->findAll();

        $data = [
            'title' => 'Pending Drug Approvals',
            'drugs' => $pendingDrugs
        ];

        return view('admin/drug_management/pending_approvals', $data);
    }

    public function approve($id)
    {
        $drug = $this->drugModel->find($id);

        if (!$drug) {
            return redirect()->to('/admin/drugs')->with('error', 'Drug not found');
        }

        $this->drugModel->update($id, ['status' => 'active']);
        return redirect()->to('/admin/drugs/pending')->with('success', 'Drug approved successfully');
    }

    public function reject($id)
    {
        $drug = $this->drugModel->find($id);

        if (!$drug) {
            return redirect()->to('/admin/drugs')->with('error', 'Drug not found');
        }

        $this->drugModel->update($id, ['status' => 'inactive']);
        return redirect()->to('/admin/drugs/pending')->with('success', 'Drug rejected successfully');
    }

    public function bulkUpload()
    {
        if ($this->request->getMethod() === 'POST') {
            $file = $this->request->getFile('csv_file');

            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads', $newName);

                $csvData = array_map('str_getcsv', file(WRITEPATH . 'uploads/' . $newName));
                array_shift($csvData); // Remove header row

                $drugs = [];
                foreach ($csvData as $row) {
                    $drugs[] = [
                        'name' => $row[0],
                        'category' => $row[1],
                        'description' => $row[2],
                        'price' => $row[3],
                        'image_url' => $row[4],
                        'status' => $row[5],
                        'is_featured' => $row[6],
                        'expiry_date' => $row[7],
                        'is_approved' => $row[8],
                        'dosage' => $row[9],
                        'form' => $row[10],
                        'side_effects' => $row[11],
                        'contraindications' => $row[12],
                        'generic_name' => $row[13],
                        'prescription_required' => $row[14],
                        'manufacturer' => $row[15],
                    ];
                }

                $this->drugModel->insertBatch($drugs);

                return redirect()->to('/admin/drugs')->with('success', 'Bulk upload completed successfully');
            }
        }

        return view('admin/drug_management/bulk_upload');
    }

    public function downloadTemplate()
    {
        $data = "Name,Category,Description,Price,Image URL,Status,Is Featured,Expiry Date,Is Approved,Dosage,Form,Side Effects,Contraindications,Generic Name,Prescription Required,Manufacturer\n";
        $data .= "Paracetamol,Pain Relief,For fever and mild pain,10.99,http://example.com/paracetamol.jpg,active,1,2025-12-31,1,500mg,Tablet,Nausea,Liver disease,Acetaminophen,0,Generic Pharma\n";

        return $this->response->download('drug_template.csv', $data);
    }

    private function handleImageUpload()
    {
        $img = $this->request->getFile('image');
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(ROOTPATH . 'public/uploads/drugs', $newName);
            return $newName;
        }
        return null;
    }
    public function editCategory($id)
    {
        $category = $this->drugCategoryModel->find($id);

        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            if ($this->drugCategoryModel->update($id, $data)) {
                return redirect()->to('/admin/drugs/categories')->with('success', 'Category updated successfully');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->drugCategoryModel->errors());
            }
        }

        $data['category'] = $category;
        return view('admin/drug_management/edit_category', $data);
    }

    public function deleteCategory($id)
    {
        if ($this->drugCategoryModel->delete($id)) {
            return redirect()->to('/admin/drugs/categories')->with('success', 'Category deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete category');
        }
    }



    public function addCategory()
    {
        if ($this->request->getMethod() === 'POST') {
            $name = $this->request->getPost('name');
            $description = $this->request->getPost('description');
            
            if ($this->drugCategoryModel->addCategory($name, $description)) {
                return redirect()->to('/admin/drugs/categories')->with('success', 'Category added successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to add category')->withInput();
            }
        }
        
        return view('admin/drug_management/add_category');
    }
}

