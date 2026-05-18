<?php

namespace App\Http\Controllers;

use App\Domain\DataDukung\Models\PermohonanFile;
use App\Domain\Innovation\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class FileUploadController extends Controller
{
    /**
     * Upload file for permohonan
     */
    public function upload(Request $request, Permohonan $permohonan)
    {
        $this->authorize('update', $permohonan);

        $validated = $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $file = $validated['file'];
        $path = $file->store("permohonan/{$permohonan->id}", 's3');

        PermohonanFile::create([
            'id_permohonan' => $permohonan->id,
            'uuid' => Str::uuid(),
            'nama_file' => $file->getClientOriginalName(),
            'path' => $path,
            'tipe_file' => $file->getClientMimeType(),
            'ukuran' => $file->getSize(),
        ]);

        return back()->with('success', 'File berhasil diupload');
    }

    /**
     * Download file
     */
    public function download(PermohonanFile $file)
    {
        $this->authorize('view', $file->permohonan);

        return \Storage::disk('s3')->download($file->path, $file->nama_file);
    }

    /**
     * Delete file
     */
    public function destroy(PermohonanFile $file)
    {
        $this->authorize('update', $file->permohonan);

        \Storage::disk('s3')->delete($file->path);
        $file->delete();

        return back()->with('success', 'File berhasil dihapus');
    }
}
