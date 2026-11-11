<?php

namespace Municipal\Attestation\Support;

class LogoHelper
{
    /**
     * Resolve the current logo URL at runtime without caching so changes in
     * SiteSettings immediately reflect in print views.
     */
    public static function url(): string
    {
        $resolver = config('attestation.logo_resolver');

        if (is_callable($resolver)) {
            try {
                $resolved = $resolver();
                if (!empty($resolved)) {
                    return str_starts_with($resolved, 'http') || str_starts_with($resolved, '/')
                        ? $resolved
                        : asset($resolved);
                }
            } catch (\Throwable) {
                // Fall back to default logo
            }
        }

        // Check host helper getSiteSettings() if no custom resolver set
        if (function_exists('getSiteSettings')) {
            try {
                $settings = getSiteSettings();
                if (!empty($settings?->site_logo)) {
                    return asset($settings->site_logo);
                }
            } catch (\Throwable) {
                // Fall back to default logo
            }
        }

        $defaultLogo = config('attestation.default_logo', 'vendor/attestation/default-logo.jpg');
        return asset($defaultLogo);
    }
}
