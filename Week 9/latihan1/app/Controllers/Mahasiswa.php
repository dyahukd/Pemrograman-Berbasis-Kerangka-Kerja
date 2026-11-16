<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;

class Mahasiswa extends BaseController
{
    protected $mahasiswaModel;

    public function __construct()
    {
        helper('form');
        $this->mahasiswaModel = new MahasiswaModel();
    }

    private function uploadFoto()
    {
        $foto = $this->request->getFile('foto');

        if (!$foto || $foto->getError() === 4) {
            return null;
        }

        if (!$foto->isValid() || $foto->hasMoved()) {
            return false;
        }

        $validationRule = [
            'foto' => [
                'label' => 'Foto Mahasiswa',
                'rules' => 'uploaded[foto]|is_image[foto]|max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return false;
        }

        $namaFoto = $foto->getRandomName();

        $foto->move(WRITEPATH . 'uploads/mahasiswa', $namaFoto);

        return $namaFoto;
    }

    // Menampilkan seluruh data mahasiswa
    public function index()
    {
        $data = [
            'title' => 'Data Mahasiswa',
            'mahasiswa' => $this->mahasiswaModel->findAll()
        ];

        return view('admin/mahasiswa/index', $data);
    }

    // Menampilkan foto mahasiswa
    public function foto($namaFoto)
    {
        $namaFoto = basename($namaFoto);
        $path = WRITEPATH . 'uploads/mahasiswa/' . $namaFoto;

        if (!is_file($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Foto mahasiswa tidak ditemukan.'
            );
        }

        $mimeType = mime_content_type($path);

        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Format foto tidak valid.'
            );
        }

        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setBody(file_get_contents($path));
    }

    // Menampilkan form tambah mahasiswa
    public function create()
    {
        return view('admin/mahasiswa/create', [
            'title' => 'Tambah Mahasiswa'
        ]);
    }

    // Menyimpan data mahasiswa baru
    public function store()
    {
        $rules = [
            'nrp' => 'required|max_length[20]',
            'nama' => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'jurusan' => 'required|max_length[100]',
            'angkatan' => 'required|integer|exact_length[4]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $namaFoto = $this->uploadFoto();

        if ($namaFoto === false) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->mahasiswaModel->insert([
            'nrp' => $this->request->getPost('nrp'),
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'jurusan' => $this->request->getPost('jurusan'),
            'angkatan' => $this->request->getPost('angkatan'),
            'foto' => $namaFoto,
        ]);

        return redirect()->to('/admin/mahasiswa')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    // Menampilkan form edit mahasiswa
    public function edit($id)
    {
        $mahasiswa = $this->mahasiswaModel->find($id);

        if (!$mahasiswa) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Data mahasiswa tidak ditemukan.'
            );
        }

        return view('admin/mahasiswa/edit', [
            'title' => 'Edit Mahasiswa',
            'mahasiswa' => $mahasiswa
        ]);
    }

    // Memperbarui data mahasiswa
    public function update($id)
    {
        $mahasiswa = $this->mahasiswaModel->find($id);

        if (!$mahasiswa) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Data mahasiswa tidak ditemukan.'
            );
        }

        $rules = [
            'nrp' => 'required|max_length[20]',
            'nama' => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'jurusan' => 'required|max_length[100]',
            'angkatan' => 'required|integer|exact_length[4]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $namaFoto = $this->uploadFoto();

        if ($namaFoto === false) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        if ($namaFoto !== null && !empty($mahasiswa['foto'])) {
            $fotoLama = WRITEPATH . 'uploads/mahasiswa/' . $mahasiswa['foto'];

            if (is_file($fotoLama)) {
                unlink($fotoLama);
            }
        }

        if ($namaFoto === null) {
            $namaFoto = $mahasiswa['foto'];
        }

        $this->mahasiswaModel->update($id, [
            'nrp' => $this->request->getPost('nrp'),
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'jurusan' => $this->request->getPost('jurusan'),
            'angkatan' => $this->request->getPost('angkatan'),
            'foto' => $namaFoto,
        ]);

        return redirect()->to('/admin/mahasiswa')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    // Menghapus data mahasiswa
    public function delete($id)
    {
        $mahasiswa = $this->mahasiswaModel->find($id);

        if (!$mahasiswa) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Data mahasiswa tidak ditemukan.'
            );
        }

        if (!empty($mahasiswa['foto'])) {
            $fotoPath = WRITEPATH . 'uploads/mahasiswa/' . $mahasiswa['foto'];

            if (is_file($fotoPath)) {
                unlink($fotoPath);
            }
        }

        $this->mahasiswaModel->delete($id);

        return redirect()->to('/admin/mahasiswa')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}