<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Product;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminProducts extends BaseController
{
    private function checkAdmin()
    {
        if (
            !session()->get('isLoggedIn') ||
            session()->get('user_role') !== 'admin'
        ) {
            return redirect()->to(site_url('admin/login'));
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $productModel = new Product();

        $data['products'] = $productModel
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('admin/products', $data);
    }

    public function new()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        return view('admin/product_form', [
            'product' => null,
            'pageTitle' => 'Add New Product'
        ]);
    }

    public function store()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[150]',
            'category' => 'required|max_length[100]',
            'description' => 'required',
            'price' => 'required|decimal',
            'stock' => 'required|integer',
            'image' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $imageName = $this->uploadImage($image);

        if (!$imageName) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengunggah gambar produk.');
        }

        helper('url');

        $productModel = new Product();
        $name = trim($this->request->getPost('name'));

        $productModel->insert([
            'name' => $name,
            'slug' => $this->makeUniqueSlug($name),
            'category' => trim($this->request->getPost('category')),
            'description' => trim($this->request->getPost('description')),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'image' => $imageName,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ]);

        return redirect()->to(site_url('admin/products'))
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $product = (new Product())->find($id);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound('Product not found.');
        }

        return view('admin/product_form', [
            'product' => $product,
            'pageTitle' => 'Edit Product'
        ]);
    }

    public function update($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $productModel = new Product();
        $product = $productModel->find($id);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound('Product not found.');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[150]',
            'category' => 'required|max_length[100]',
            'description' => 'required',
            'price' => 'required|decimal',
            'stock' => 'required|integer'
        ];

        $image = $this->request->getFile('image');
        $hasNewImage = $image && $image->getError() !== UPLOAD_ERR_NO_FILE;

        if ($hasNewImage) {
            $rules['image'] = 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $name = trim($this->request->getPost('name'));

        $updateData = [
            'name' => $name,
            'slug' => $this->makeUniqueSlug($name, $id),
            'category' => trim($this->request->getPost('category')),
            'description' => trim($this->request->getPost('description')),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($hasNewImage && $image->isValid()) {
            $imageName = $this->uploadImage($image);

            if (!$imageName) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengunggah gambar baru.');
            }

            $updateData['image'] = $imageName;

            // Hapus gambar lama setelah gambar baru berhasil diunggah.
            if (!empty($product['image'])) {
                $oldImage = FCPATH . 'uploads/products/' . $product['image'];

                if (is_file($oldImage)) {
                    unlink($oldImage);
                }
            }
        }

        $productModel->update($id, $updateData);

        return redirect()->to(site_url('admin/products'))
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function delete($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $productModel = new Product();
        $product = $productModel->find($id);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound('Product not found.');
        }

        // Soft delete: produk disembunyikan, data dan gambar tetap disimpan.
        $productModel->update($id, ['is_active' => 0]);

        return redirect()->to(site_url('admin/products'))
            ->with('success', 'Produk berhasil dinonaktifkan.');
    }

    private function uploadImage($image)
    {
        if (!$image || !$image->isValid() || $image->hasMoved()) {
            return false;
        }

        $uploadPath = FCPATH . 'uploads/products/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $newName = $image->getRandomName();

        if (!$image->move($uploadPath, $newName)) {
            return false;
        }

        return $newName;
    }

    private function makeUniqueSlug($name, $ignoreId = null)
    {
        helper('url');

        $baseSlug = url_title($name, '-', true);
        $slug = $baseSlug;
        $counter = 1;

        $productModel = new Product();

        while (true) {
            $builder = $productModel->where('slug', $slug);

            if ($ignoreId !== null) {
                $builder->where('id !=', $ignoreId);
            }

            if (!$builder->first()) {
                break;
            }

            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}