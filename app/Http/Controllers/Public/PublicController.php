<?php

namespace App\Http\Controllers\Public;

use App\Domain\Cms\Models\Faq;
use App\Domain\Cms\Models\Laman;
use App\Domain\Innovation\Models\Permohonan;
use App\Domain\Innovation\Models\Urusan;
use App\Domain\Integration\Models\AppSetting;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicController extends Controller
{
    /**
     * Welcome / landing page.
     */
    public function welcome()
    {
        return Inertia::render('Public/Welcome', [
            'stats' => [
                'inovasi' => Permohonan::count(),
                'pemohon' => \DB::table('pemohon')->count(),
                'urusan'  => Urusan::count(),
            ],
            'schedule' => $this->buildSchedule(),
        ]);
    }

    public function about()
    {
        return Inertia::render('Public/About');
    }

    public function contact()
    {
        return Inertia::render('Public/Contact');
    }

    public function faq()
    {
        return Inertia::render('Public/Faq', [
            'faq' => Faq::orderBy('id')->get(['id', 'label', 'jawaban', 'slug']),
        ]);
    }

    public function laman(string $slug)
    {
        $laman = Laman::where('slug', $slug)->firstOrFail();

        return Inertia::render('Public/Laman', [
            'laman' => $laman->only(['id', 'label', 'slug', 'content']),
        ]);
    }

    /**
     * Public gallery of approved innovations.
     */
    public function inovasiIndex(Request $request)
    {
        $inovasi = Permohonan::query()
            ->with(['pemohon:id,name,unit_kerja', 'urusan:id,label'])
            ->whereIn('status', ['approved', '4'])
            ->orderByDesc('updated_at')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Public/Inovasi/Index', [
            'inovasi' => $inovasi,
        ]);
    }

    public function inovasiShow(string $slug)
    {
        $inovasi = Permohonan::query()
            ->with(['pemohon:id,name,unit_kerja', 'urusan:id,label', 'kategori:id,label'])
            ->where('slug', $slug)
            ->firstOrFail();

        return Inertia::render('Public/Inovasi/Show', [
            'inovasi' => $inovasi,
        ]);
    }

    /**
     * Build schedule info for hero banner from app_settings.
     */
    private function buildSchedule(): ?array
    {
        $open = AppSetting::where('key', 'submission_open_date')->value('value');
        $close = AppSetting::where('key', 'submission_close_date')->value('value');
        $year = AppSetting::where('key', 'active_year')->value('value');

        if (! $open || ! $close) {
            return null;
        }

        try {
            $openAt = Carbon::parse($open);
            $closeAt = Carbon::parse($close);
            $now = now();

            return [
                'year'    => (int) ($year ?? $openAt->year),
                'open'    => $openAt->translatedFormat('d F Y'),
                'close'   => $closeAt->translatedFormat('d F Y'),
                'isOpen'  => $now->between($openAt, $closeAt),
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }
}
