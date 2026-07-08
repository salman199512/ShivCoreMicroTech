<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Support\MailConfig;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MailConfigFromSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_mail_config_loader_decodes_stored_smtp_password(): void
    {
        Setting::create([
            'key' => 'mail_mailer',
            'value' => 'smtp',
        ]);
        Setting::create([
            'key' => 'mail_host',
            'value' => 'smtp.office365.com',
        ]);
        Setting::create([
            'key' => 'mail_port',
            'value' => '587',
        ]);
        Setting::create([
            'key' => 'mail_username',
            'value' => 'info@shivcoremicrotech.in',
        ]);
        Setting::create([
            'key' => 'mail_password',
            'value' => base64_encode('secret-password'),
        ]);
        Setting::create([
            'key' => 'mail_encryption',
            'value' => 'tls',
        ]);
        Setting::create([
            'key' => 'mail_from_address',
            'value' => 'info@shivcoremicrotech.in',
        ]);
        Setting::create([
            'key' => 'mail_from_name',
            'value' => 'ShivCore Micro Tech',
        ]);

        config(['mail.default' => 'log']);

        MailConfig::applyFromSettings();

        $this->assertSame('smtp', config('mail.default'));
        $this->assertSame('smtp.office365.com', config('mail.mailers.smtp.host'));
        $this->assertSame('587', config('mail.mailers.smtp.port'));
        $this->assertSame('info@shivcoremicrotech.in', config('mail.mailers.smtp.username'));
        $this->assertSame('secret-password', config('mail.mailers.smtp.password'));
        $this->assertSame('tls', config('mail.mailers.smtp.encryption'));
        $this->assertSame('info@shivcoremicrotech.in', config('mail.from.address'));
        $this->assertSame('ShivCore Micro Tech', config('mail.from.name'));
    }

    public function test_invalid_database_host_falls_back_to_safe_mail_host(): void
    {
        Setting::create([
            'key' => 'mail_host',
            'value' => 'xgpxscjqcsxglhnr',
        ]);

        config([
            'mail.mailers.smtp.host' => 'smtp.office365.com',
            'mail.mailers.smtp.port' => 587,
            'mail.mailers.smtp.username' => 'info@shivcoremicrotech.in',
            'mail.mailers.smtp.password' => 'secret-password',
            'mail.mailers.smtp.encryption' => 'tls',
        ]);

        MailConfig::applyFromSettings();

        $this->assertSame('smtp.office365.com', config('mail.mailers.smtp.host'));
    }

    public function test_settings_update_encodes_sensitive_mail_password(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('settings.update'), [
                'mail_password' => 'secret-password',
            ])
            ->assertRedirect(route('settings.edit'));

        $this->assertSame(base64_encode('secret-password'), Setting::where('key', 'mail_password')->value('value'));
    }
}
