<?php

namespace App\Http\Middleware;

use App\Domain\User\Models\Role;
use App\Models\User;
use Novay\SSO\Http\Middleware\SSOAutoLogin as Middleware;

class SSOAutoLogin extends Middleware
{
    /**
     * Manage user model from SSO response and auto-login.
     */
    public function handleLogin($response)
    {
        $data = $response['data'];

        // Find by uid first, fallback to email (handles users created before SSO migration)
        $user = User::where('uid', $data['id'])
            ->orWhere('email', $data['email'] ?? null)
            ->first();

        $attributes = [
            'uid' => $data['id'],
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'photo' => $data['photo'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'gender' => $data['gender'] ?? null,
            'date_birth' => !empty($data['date_birth']) ? $data['date_birth'] : null,
            'number_id' => $data['number_id'] ?? null,
            'type_id' => $data['type_id'] ?? null,
            'level' => $data['level'] ?? null,
        ];

        if ($user) {
            $user->fill($attributes);
            // Set password only if not already set (legacy users)
            if (empty($user->password)) {
                $user->password = 'sso';
            }
            $user->save();
            $wasRecentlyCreated = false;
        } else {
            $attributes['password'] = 'sso';
            $user = User::create($attributes);
            $wasRecentlyCreated = true;
        }

        // Auto-assign default role to new users
        if ($wasRecentlyCreated) {
            $defaultRole = Role::where('slug', 'pemohon')->first();
            if ($defaultRole) {
                $user->roles()->attach($defaultRole->id);
            }
        }

        auth()->guard(config('sso.guard', 'web'))->login($user, true);
    }
}
