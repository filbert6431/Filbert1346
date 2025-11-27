<?php
namespace App\Http\Controllers;

use App\Models\Multipleupload;
use App\Models\pelanggan;
use Illuminate\Http\Request;

class MultipleUploadController extends Controller
{
    public function index()
    {
        // Ambil pelanggan_id dari request
        $pelangganId = request('pelanggan_id');

        if (! $pelangganId) {
            return redirect()->route('pelanggan.index')
                ->with('error', 'ID Pelanggan tidak ditemukan');
        }

        $pelanggan = Pelanggan::findOrFail($pelangganId);

        return view('multipleuploads', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*'   => 'required|file|max:2048',
            'ref_table' => 'required',
            'ref_id'    => 'required',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // PERSIS SEPERTI USER CONTROLLER
                $filePath = $file->store('uploads', 'public');
                // Hasil: "uploads/timestamp_namafile.png"

                Multipleupload::create([
                    'filename'  => $filePath, // SIMPAN FULL PATH seperti user
                    'ref_table' => $request->ref_table,
                    'ref_id'    => $request->ref_id,
                ]);
            }

            return redirect()->route('pelanggan.index')
                ->with('success', 'File berhasil diupload!');
        }

        return back()->with('error', 'Tidak ada file yang diupload');
    }

    public function showByPelanggan($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $files     = Multipleupload::where('ref_table', 'pelanggan')
            ->where('ref_id', $id)
            ->get();

        return view('admin.Pelanggan.files', compact('pelanggan', 'files'));
    }

    public function destroy($id)
    {
        $file = Multipleupload::findOrFail($id);

        // Hapus file dari storage
        if (\Storage::exists('public/uploads/' . $file->filename)) {
            \Storage::delete('public/uploads/' . $file->filename);
        }

        // Hapus record dari database
        $file->delete();

        return back()->with('success', 'File berhasil dihapus!');
    }
}
