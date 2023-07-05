<?php

namespace App\Controllers;

use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class ProductController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $limit = $this->request->getGet('limit') ?? 10;
        $page = $this->request->getGet('page') ?? 1;
        $products = model(ProductModel::class)->where('factory_id', auth()->user()->factory_id)->findAll($limit, (($page - 1) * $limit));
        if ($products === null) {
            return $this->failNotFound();
        }
        foreach ($products as $x => $product) {
            $products[$x]['images'] = model(ProductImageModel::class)->select('image')->where('product_id', $product['id'])->findAll();
        }
        return $this->respond($products, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $product = model(ProductModel::class)->where('factory_id', auth()->user()->factory_id)->find($id);
        if ($product === null) {
            return $this->failNotFound();
        }
        $product['images'] = model(ProductImageModel::class)->select('image')->where('product_id', $product['id'])->findAll();
        return $this->respond($product, 200);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $rules = [
            'name' => [
                'label' => 'Nama item',
                'rules' => 'required|max_length[256]|alpha_numeric_space'
            ],
            'desc' => [
                'label' => 'Deskripsi item',
                'rules' => 'required|regex_match[/\A[A-z0-9\s.,!?\/\(\)]+\z/]'
            ],
            'price' => [
                'label' => 'Harga item',
                'rules' => 'required|max_length[14]|regex_match[/\A[0-9,]+\z/]'
            ],
            'qty' => [
                'label' => 'Quantitas',
                'rules' => 'required|integer|max_length[11]'
            ],
        ];
        foreach ($this->request->getFileMultiple('images') ?? [] as $x => $image) {
            $rules += [
                'images.' . $x => [
                    'label' => 'Gambar item ' . ($x + 1),
                    'rules' => 'uploaded[images.' . $x . ']|max_size[images.' . $x . ',1024]|is_image[images.' . $x . ']',
                ]
            ];
        }
        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'factory_id' => auth()->user()->factory_id,
            'name' => $this->request->getPost('name'),
            'desc' => $this->request->getPost('desc'),
            'price' => doubleval(trim(str_replace(',', '', $this->request->getPost('price')) ?? '') / 1000),
            'qty' => $this->request->getPost('qty'),
        ];

        $db = db_connect();
        $db->transBegin();
        $productModel = model(ProductModel::class);
        if (!$productModel->save($data)) {
            $failed = true;
        }
        $productID = $productModel->getInsertID();
        foreach ($this->request->getFileMultiple('images') ?? [] as $image) {
            if ($image->isValid() && !$image->hasMoved()) {
                $newName = $image->getRandomName();
                if (!$image->move("img/product", $newName)) {
                    $saveImage = false;
                }
                if (!model(ProductImageModel::class)->save([
                    'product_id' => $productID,
                    'image' => $newName,
                ])) {
                    $failed = true;
                }
            }
        }
        if ($db->transStatus() === false || ($failed ?? false) || !($saveImage ?? true)) {
            $db->transRollback();
            log_message('error', json_encode(['failed' => ($failed ?? false), "saveImage" => ($saveImage ?? true)]));
            log_message('error', json_encode($db->error()));
            return $this->failServerError();
        }
        $db->transCommit();

        // Success!
        return $this->respondCreated([
            'status_code' => 201,
            'message' => 'Product has been created!',
        ]);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        if (auth()->user()->factory_id !== model(ProductModel::class)->select('factory_id')->find($id)['factory_id']) {
            return $this->failUnauthorized();
        }

        $rules = [
            'name' => [
                'label' => 'Nama item',
                'rules' => 'required|max_length[256]|alpha_numeric_space|is_unique[products.name,id,' . $id . ']'
            ],
            'desc' => [
                'label' => 'Deskripsi item',
                'rules' => 'required|regex_match[/\A[A-z0-9\s.,!?\/\(\)]+\z/]'
            ],
            'price' => [
                'label' => 'Harga item',
                'rules' => 'required|max_length[14]|regex_match[/\A[0-9,]+\z/]'
            ],
            'qty' => [
                'label' => 'Quantitas',
                'rules' => 'required|integer|max_length[11]'
            ],
        ];
        foreach ($this->request->getFileMultiple('images') ?? [] as $x => $image) {
            $rules += [
                'images.' . $x => [
                    'label' => 'Gambar item ' . ($x + 1),
                    'rules' => 'uploaded[images.' . $x . ']|max_size[images.' . $x . ',1024]|is_image[images.' . $x . ']',
                ]
            ];
        }
        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
            'desc' => $this->request->getPost('desc'),
            'price' => doubleval(trim(str_replace(',', '', $this->request->getPost('price')) ?? '') / 1000),
            'qty' => $this->request->getPost('qty'),
        ];

        $db = db_connect();
        $db->transBegin();
        $productModel = model(ProductModel::class);
        if (!$productModel->save($data)) {
            $failed = true;
        }
        $productID = $id;
        foreach ($this->request->getFileMultiple('images') ?? [] as $image) {
            if ($image->isValid() && !$image->hasMoved()) {
                $newName = $image->getRandomName();
                if (!$image->move("img/product", $newName)) {
                    $saveImage = false;
                }
                if (!model(ProductImageModel::class)->save([
                    'product_id' => $productID,
                    'image' => $newName,
                ])) {
                    $failed = true;
                }
            }
        }
        if ($db->transStatus() === false || ($failed ?? false) || !($saveImage ?? true)) {
            $db->transRollback();
            log_message('error', json_encode(['failed' => ($failed ?? false), "saveImage" => ($saveImage ?? true)]));
            log_message('error', json_encode($db->error()));
            return $this->failServerError();
        }
        $db->transCommit();

        // Success!
        return $this->respondUpdated([
            'status_code' => 200,
            'message' => 'Product has been updated!',
        ]);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        if (auth()->user()->factory_id !== model(ProductModel::class)->select('factory_id')->find($id)['factory_id']) {
            return $this->failUnauthorized();
        }

        if (!model(ProductModel::class)->delete($id)) {
            log_message('error', json_encode(model(ProductModel::class)->errors()));
            return $this->failServerError();
        }
        return $this->respondDeleted([
            'status_code' => 200,
            'message' => "Product has been deleted!",
        ]);
    }

    public function deleteImageProduct($id = null)
    {
        if (auth()->user()->factory_id !== model(ProductModel::class)->findProductImageModelID($id)) {
            return $this->failUnauthorized();
        }

        if (!model(ProductImageModel::class)->delete($id)) {
            log_message('error', json_encode(model(ProductImageModel::class)->errors()));
            return $this->failServerError();
        }
        return $this->respondDeleted([
            'status_code' => 200,
            'message' => "Product has been deleted!",
        ]);
    }
}
