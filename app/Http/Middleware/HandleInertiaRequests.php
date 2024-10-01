<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Gate;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
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
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'can' => [
                        'admin' => Gate::allows('is_admin'),
                    ],
                // 'municipio' => $acceso ? $acceso['municipio']:null,
                // 'psuv' => $acceso ? $acceso['nivel']==TipoEstructuraEnum::PSUV:null,
            ],
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'message' => $request->session()->get('message'),
                    'error' => $request->session()->get('error'),
                ];
            },
             'csrf_token' => csrf_token(),
        ];
    }
}
