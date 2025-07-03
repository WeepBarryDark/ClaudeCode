<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'locale' => app()->getLocale(),
            'timezone' => $request->user()?->timezone ?? 'UTC',
            'translations' => $this->getTranslations(),
        ];
    }
    
    private function getTranslations(): array
    {
        $locale = app()->getLocale();
        $path = lang_path($locale . '/messages.php');
        
        // Debug log
        \Log::info('Loading translations', [
            'locale' => $locale,
            'path' => $path,
            'file_exists' => file_exists($path)
        ]);
        
        if (file_exists($path)) {
            $translations = include $path;
            \Log::info('Translations loaded', [
                'locale' => $locale,
                'translation_count' => count($translations)
            ]);
            return $translations;
        }
        
        // Fallback to English
        $fallbackPath = lang_path('en/messages.php');
        if (file_exists($fallbackPath)) {
            return include $fallbackPath;
        }
        
        return [];
    }
}
