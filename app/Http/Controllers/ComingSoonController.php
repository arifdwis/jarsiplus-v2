<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

/**
 * Generic stub controller for admin pages that aren't built yet.
 * Renders Pages/Admin/ComingSoon with the supplied title/description/icon.
 */
class ComingSoonController extends Controller
{
    public function __invoke(string $title, string $description = '', string $icon = 'pi pi-hammer')
    {
        return Inertia::render('Admin/ComingSoon', [
            'title'       => $title,
            'description' => $description,
            'icon'        => $icon,
        ]);
    }
}
