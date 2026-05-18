<?php

namespace App\Http\Controllers;

use App\Domain\Innovation\Models\Pemohon;
use App\Domain\Innovation\Models\Permohonan;
use App\Domain\Innovation\Models\Urusan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PermohonanController extends Controller
{
    /**
     * Display a listing of permohonan.
     *
     * Admin sees all; pemohon sees only their own (matched by user.uid -> pemohon).
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Permohonan::query()
            ->with(['pemohon:id,name,unit_kerja', 'urusan:id,label', 'kategori:id,label'])
            ->orderByDesc('created_at');

        // Non-admin: filter by pemohon mapped to current user (by email or uid)
        if (! $this->isAdmin($user)) {
            $pemohonIds = Pemohon::where('email', $user->email)
                ->orWhere('id_operator', $user->id)
                ->pluck('id');
            $query->whereIn('id_pemohon_0', $pemohonIds);
        }

        $permohonan = $query->paginate(15)->withQueryString();

        return Inertia::render('Permohonan/Index', [
            'permohonan' => $permohonan,
            'isAdmin' => $this->isAdmin($user),
        ]);
    }

    public function create()
    {
        return Inertia::render('Permohonan/Create', [
            'urusan' => Urusan::orderBy('label')->get(['id', 'label']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'urusan_utama' => 'required|exists:urusan,id',
            'rancang_bangun' => 'nullable|string',
            'tujuan_inovasi' => 'nullable|string',
            'manfaat_inovasi' => 'nullable|string',
            'hasil_inovasi' => 'nullable|string',
        ]);

        $user = $request->user();

        // Find or create pemohon record bound to current user
        $pemohon = Pemohon::firstOrCreate(
            ['email' => $user->email],
            [
                'uuid' => (string) Str::uuid(),
                'id_operator' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'nickname' => $user->nickname,
            ]
        );

        $permohonan = Permohonan::create([
            'uuid' => (string) Str::uuid(),
            'id_pemohon_0' => $pemohon->id,
            'urusan_utama' => $validated['urusan_utama'],
            'label' => $validated['label'],
            'slug' => Str::slug($validated['label']) . '-' . substr((string) Str::uuid(), 0, 8),
            'rancang_bangun' => $validated['rancang_bangun'] ?? null,
            'tujuan_inovasi' => $validated['tujuan_inovasi'] ?? null,
            'manfaat_inovasi' => $validated['manfaat_inovasi'] ?? null,
            'hasil_inovasi' => $validated['hasil_inovasi'] ?? null,
            'status' => 'draft',
        ]);

        return redirect()
            ->route('permohonan.show', $permohonan)
            ->with('success', 'Permohonan berhasil dibuat');
    }

    public function show(Permohonan $permohonan, Request $request)
    {
        $this->authorizePermohonan($request->user(), $permohonan);

        $permohonan->load([
            'pemohon', 'pemohonSekunder', 'urusan', 'kategori',
            'provinsi:id,name', 'kota:id,name',
            'files', 'histories.operator:id,name',
            'penilaians',
        ]);

        return Inertia::render('Permohonan/Show', [
            'permohonan' => $permohonan,
        ]);
    }

    public function edit(Permohonan $permohonan, Request $request)
    {
        $this->authorizePermohonan($request->user(), $permohonan);

        if ($permohonan->status !== 'draft' && ! $this->isAdmin($request->user())) {
            return redirect()
                ->route('permohonan.show', $permohonan)
                ->with('error', 'Hanya permohonan draft yang dapat diedit');
        }

        return Inertia::render('Permohonan/Edit', [
            'permohonan' => $permohonan,
            'urusan' => Urusan::orderBy('label')->get(['id', 'label']),
        ]);
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        $this->authorizePermohonan($request->user(), $permohonan);

        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'urusan_utama' => 'required|exists:urusan,id',
            'rancang_bangun' => 'nullable|string',
            'tujuan_inovasi' => 'nullable|string',
            'manfaat_inovasi' => 'nullable|string',
            'hasil_inovasi' => 'nullable|string',
        ]);

        $permohonan->update($validated);

        return redirect()
            ->route('permohonan.show', $permohonan)
            ->with('success', 'Permohonan berhasil diperbarui');
    }

    public function submit(Permohonan $permohonan, Request $request)
    {
        $this->authorizePermohonan($request->user(), $permohonan);

        if ($permohonan->status !== 'draft') {
            return back()->with('error', 'Hanya permohonan draft yang dapat disubmit');
        }

        $permohonan->update(['status' => 'submitted']);

        return back()->with('success', 'Permohonan berhasil disubmit');
    }

    public function destroy(Permohonan $permohonan, Request $request)
    {
        $this->authorizePermohonan($request->user(), $permohonan);

        if ($permohonan->status !== 'draft' && ! $this->isAdmin($request->user())) {
            return back()->with('error', 'Hanya permohonan draft yang dapat dihapus');
        }

        $permohonan->delete();

        return redirect()
            ->route('permohonan.index')
            ->with('success', 'Permohonan berhasil dihapus');
    }

    /**
     * Pass authorization for the current user against a permohonan.
     */
    private function authorizePermohonan($user, Permohonan $permohonan): void
    {
        if ($this->isAdmin($user)) {
            return;
        }

        $isOwner = Pemohon::where('id', $permohonan->id_pemohon_0)
            ->where(function ($q) use ($user) {
                $q->where('email', $user->email)->orWhere('id_operator', $user->id);
            })
            ->exists();

        abort_unless($isOwner, 403, 'Anda tidak memiliki akses ke permohonan ini');
    }

    private function isAdmin($user): bool
    {
        if (! $user) return false;
        return $user->roles()->whereIn('slug', ['administrator', 'superadmin'])->exists();
    }
}
