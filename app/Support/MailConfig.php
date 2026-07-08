<?php

namespace App\Support;

use App\Models\Setting;

class MailConfig
{
    /**
     * Apply database mail settings to runtime Laravel config.
     */
    public static function applyFromSettings(): void
    {
        $settings = Setting::query()
            ->pluck('value', 'key')
            ->mapWithKeys(function ($value, $key) {
                return [$key => static::decodeValue($key, $value)];
            })
            ->toArray();

        $mailMailer = static::resolveSettingValue($settings, 'mail_mailer', config('mail.default'));
        $mailHost = static::resolveSettingValue($settings, 'mail_host', config('mail.mailers.smtp.host'));
        $mailPort = static::resolveSettingValue($settings, 'mail_port', config('mail.mailers.smtp.port'));
        $mailUsername = static::resolveSettingValue($settings, 'mail_username', config('mail.mailers.smtp.username'));
        $mailPassword = static::resolveSettingValue($settings, 'mail_password', config('mail.mailers.smtp.password'));
        $mailEncryption = static::resolveSettingValue($settings, 'mail_encryption', config('mail.mailers.smtp.encryption'));
        $mailFromAddress = static::resolveSettingValue($settings, 'mail_from_address', config('mail.from.address'));
        $mailFromName = static::resolveSettingValue($settings, 'mail_from_name', config('mail.from.name'));

        config([
            'mail.default' => $mailMailer,
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => $mailHost,
            'mail.mailers.smtp.port' => $mailPort,
            'mail.mailers.smtp.username' => $mailUsername,
            'mail.mailers.smtp.password' => $mailPassword,
            'mail.mailers.smtp.encryption' => $mailEncryption,
            'mail.from.address' => $mailFromAddress,
            'mail.from.name' => $mailFromName,
        ]);
    }

    public static function resolveSettingValue(array $settings, string $key, mixed $fallback): mixed
    {
        $value = $settings[$key] ?? null;

        if ($value === null || $value === '') {
            return $fallback;
        }

        if ($key === 'mail_host' && ! static::looksLikeHost($value)) {
            return $fallback;
        }

        if ($key === 'mail_port' && ! is_numeric($value)) {
            return $fallback;
        }

        if ($key === 'mail_username' && ! str_contains((string) $value, '@')) {
            return $fallback;
        }

        return $value;
    }

    public static function looksLikeHost(string $value): bool
    {
        $value = trim($value);

        if ($value === 'localhost' || filter_var($value, FILTER_VALIDATE_IP) !== false) {
            return true;
        }

        return str_contains($value, '.')
            && filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) !== false;
    }

    public static function encodeValue(string $value): string
    {
        return base64_encode($value);
    }

    public static function decodeValue(string $key, mixed $value): mixed
    {
        if ($key !== 'mail_password' || ! is_string($value) || $value === '') {
            return $value;
        }

        $decoded = base64_decode($value, true);

        return $decoded !== false && base64_encode($decoded) === $value
            ? $decoded
            : $value;
    }
}
