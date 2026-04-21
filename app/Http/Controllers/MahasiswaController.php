<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Services\MahasiswaService;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    // 1. Tampilkan semua data
    public function index()
    {
        $data = Mahasiswa::all();
        return response()->json($data);
    }

    // 2. Tambah data
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama'    => 'required|string|max:255',
                'nim'     => 'required|string|unique:mahasiswas',
                'jurusan' => 'required|string',
            ]);

            $service = new MahasiswaService();
            $mahasiswa = $service->tambahMahasiswa($validated);

            return response()->json([
                'message' => 'Data berhasil ditambahkan',
                'data'    => $mahasiswa
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menambahkan data',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // 3. Ubah data
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->all());

        return response()->json([
            'message' => 'Data berhasil diubah',
            'data'    => $mahasiswa
        ]);
    }

    // 4. Hapus data
    public function destroy($id)
    {
        Mahasiswa::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus'
        ]);
    }
}