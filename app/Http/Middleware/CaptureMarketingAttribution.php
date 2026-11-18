<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureMarketingAttribution
{
    private const UTM_PARAMETERS = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasSession() && ! $request->session()->has('marketing_attribution')) {
            $attribution = [];

            foreach (self::UTM_PARAMETERS as $parameter) {
                $value = $this->cleanValue($request->query($parameter));

                if ($value !== null) {
                    $attribution[$parameter] = $value;
                }
            }

            $referralCode = $this->firstQueryValue($request, ['referral_code', 'ref', 'agent', 'forwarder']);

            if ($referralCode !== null) {
                $attribution['referral_code'] = $referralCode;
            }

            $referrer = $this->externalReferrerHost($request);

            if (! isset($attribution['utm_source']) && $referralCode !== null) {
                $attribution['utm_source'] = 'partner';
                $attribution['utm_medium'] ??= 'referral';
            } elseif (! isset($attribution['utm_source']) && $referrer !== null) {
                $attribution['utm_source'] = $referrer;
                $attribution['utm_medium'] ??= $this->isSearchEngine($referrer) ? 'organic' : 'referral';
            }

            if ($attribution !== []) {
                $attribution['referrer'] = $referrer;
                $attribution['landing_page'] = '/'.ltrim($request->path(), '/');

                $request->session()->put('marketing_attribution', $attribution);
            }
        }

        return $next($request);
    }

    private function firstQueryValue(Request $request, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = $this->cleanValue($request->query($key));

            if ($value !== null) {
                return $value;
            }
        }

        return null;
    }

    private function cleanValue(mixed $value): ?string
    {
        if (! is_string($value) && ! is_numeric($value)) {
            return null;
        }

        $value = trim(strip_tags((string) $value));

        return $value === '' ? null : mb_substr($value, 0, 255);
    }

    private function externalReferrerHost(Request $request): ?string
    {
        $referer = $request->headers->get('referer');
        $scheme = is_string($referer) ? parse_url($referer, PHP_URL_SCHEME) : null;
        $host = is_string($referer) ? parse_url($referer, PHP_URL_HOST) : null;

        if (! is_string($host) || ! in_array(strtolower((string) $scheme), ['http', 'https'], true)) {
            return null;
        }

        $host = strtolower(rtrim($host, '.'));
        $currentHost = strtolower(rtrim($request->getHost(), '.'));

        if ($host === $currentHost || preg_replace('/^www\./', '', $host) === preg_replace('/^www\./', '', $currentHost)) {
            return null;
        }

        return preg_replace('/^www\./', '', $host);
    }

    private function isSearchEngine(string $host): bool
    {
        return preg_match('/(^|\.)google\.[a-z.]+$/i', $host) === 1
            || preg_match('/(^|\.)bing\.com$/i', $host) === 1
            || preg_match('/(^|\.)yahoo\.com$/i', $host) === 1
            || preg_match('/(^|\.)duckduckgo\.com$/i', $host) === 1
            || preg_match('/(^|\.)baidu\.com$/i', $host) === 1
            || preg_match('/(^|\.)yandex\.[a-z.]+$/i', $host) === 1;
    }
}
