<?php

namespace App\Http\Controllers;

use App\Domain\Cms\Models\Faq;
use Inertia\Inertia;

class FaqController extends Controller
{
    /**
     * Display FAQ page
     */
    public function index()
    {
        $faq = Faq::all();

        return Inertia::render('Faq', [
            'faq' => $faq,
        ]);
    }
}
