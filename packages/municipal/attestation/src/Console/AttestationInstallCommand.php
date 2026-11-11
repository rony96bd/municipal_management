<?php

namespace Municipal\Attestation\Console;

use Illuminate\Console\Command;

class AttestationInstallCommand extends Command
{
    protected $signature = 'attestation:install';

    protected $description = 'প্রত্যয়ন প্যাকেজ ইনস্টল করুন (কনফিগ, অ্যাসেট, মাইগ্রেশন, সিডার)';

    public function handle(): int
    {
        $this->info('⚙️  প্রত্যয়ন প্যাকেজ ইনস্টলেশন শুরু হচ্ছে...');

        // 1. Publish config
        $this->info('📄 কনফিগ ফাইল প্রকাশ করা হচ্ছে...');
        $this->call('vendor:publish', [
            '--tag'   => 'attestation-config',
            '--force' => false,
        ]);
        $this->line('   ✅ কনফিগ ফাইল প্রকাশিত হয়েছে।');

        // 2. Publish assets
        $this->info('🖼️  অ্যাসেট ফাইল প্রকাশ করা হচ্ছে...');
        $this->call('vendor:publish', [
            '--tag'   => 'attestation-assets',
            '--force' => true,
        ]);
        $this->line('   ✅ অ্যাসেট ফাইল প্রকাশিত হয়েছে।');

        // 3. Run migrations
        $this->info('🗄️  ডেটাবেজ মাইগ্রেশন চালানো হচ্ছে...');
        $this->call('migrate', ['--force' => true]);
        $this->line('   ✅ মাইগ্রেশন সম্পন্ন হয়েছে।');

        // 4. Run seeders
        $this->info('🌱 সিডার চালানো হচ্ছে...');

        try {
            $this->call('db:seed', [
                '--class' => \Municipal\Attestation\Database\Seeders\AttestationSignatorySeeder::class,
                '--force' => true,
            ]);
            $this->line('   ✅ AttestationSignatorySeeder সম্পন্ন।');
        } catch (\Throwable $e) {
            $this->warn('   ⚠️  AttestationSignatorySeeder ব্যর্থ: ' . $e->getMessage());
        }

        try {
            $this->call('db:seed', [
                '--class' => \Municipal\Attestation\Database\Seeders\AttestationTypeSeeder::class,
                '--force' => true,
            ]);
            $this->line('   ✅ AttestationTypeSeeder সম্পন্ন।');
        } catch (\Throwable $e) {
            $this->warn('   ⚠️  AttestationTypeSeeder ব্যর্থ: ' . $e->getMessage());
        }

        $this->newLine();
        $this->info('🎉 প্রত্যয়ন প্যাকেজ সফলভাবে ইনস্টল হয়েছে!');
        $this->line('   আপনি এখন <comment>php artisan route:list --path=attestation</comment> চালিয়ে রুটসমূহ দেখতে পারবেন।');

        return self::SUCCESS;
    }
}
