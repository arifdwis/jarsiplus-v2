<?php

namespace App\Http\Middleware;

use App\Domain\User\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => fn () => $request->user()?->only([
                    'id', 'uid', 'name', 'email', 'photo', 'phone', 'level',
                ]),
                'roles' => fn () => $request->user()
                    ? $request->user()->roles()->pluck('slug')->toArray()
                    : [],
                'permissions' => fn () => $request->user()
                    ? $request->user()->roles()
                        ->with('permissions:id,slug')
                        ->get()
                        ->pluck('permissions')
                        ->flatten()
                        ->pluck('slug')
                        ->unique()
                        ->values()
                        ->toArray()
                    : [],
            ],
            'menu' => fn () => $request->user() ? $this->buildMenu($request->user()) : [],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'appName' => config('app.name'),
        ]);
    }

    /**
     * Build hierarchical menu for the authenticated user based on their roles.
     */
    private function buildMenu($user): array
    {
        $roleIds = $user->roles()->pluck('roles.id')->toArray();

        $menuIds = \DB::table('role_menu')
            ->whereIn('role_id', $roleIds)
            ->pluck('menu_id')
            ->unique()
            ->toArray();

        if (empty($menuIds)) {
            return [];
        }

        $allMenus = Menu::whereIn('id', $menuIds)
            ->orWhereIn('id', function ($q) use ($menuIds) {
                $q->select('parent_id')->from('menu')->whereIn('id', $menuIds);
            })
            ->orderBy('order')
            ->get()
            ->map(fn ($m) => [
                'id' => $m->id,
                'parent_id' => (int) $m->parent_id,
                'order' => (int) $m->order,
                'title' => $m->title,
                'icon' => $m->icon,
                'uri' => $m->uri,
            ])
            ->toArray();

        return $this->nestMenu($allMenus, 0);
    }

    /**
     * Recursively nest menu items by parent_id.
     */
    private function nestMenu(array $items, int $parentId): array
    {
        $branch = [];
        foreach ($items as $item) {
            if ($item['parent_id'] === $parentId) {
                $children = $this->nestMenu($items, $item['id']);
                if ($children) {
                    $item['items'] = $children;
                }
                $branch[] = $item;
            }
        }
        return $branch;
    }
}
