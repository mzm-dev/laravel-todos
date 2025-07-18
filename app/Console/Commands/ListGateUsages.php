<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;

class ListGateUsages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:sync-gates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Senaraikan semua Gate::authorize yang digunakan dalam projek';

    public function handle()
    {
        $patterns = [
            "/Gate::authorize\(\s*['\"]([^'\"]+)['\"]/",
            "/->can\(\s*['\"]([^'\"]+)['\"]/",
            "/@can\(\s*['\"]([^'\"]+)['\"]/",
            "/middleware\(\s*['\"]can:([^'\"]+)['\"]/",
        ];

        $directories = [
            base_path('app'),
            resource_path('views'),
            base_path('routes'),
        ];

        $permissions = [];

        foreach ($directories as $dir) {
            $files = File::allFiles($dir);

            foreach ($files as $file) {
                $content = file_get_contents($file->getRealPath());

                foreach ($patterns as $pattern) {
                    if (preg_match_all($pattern, $content, $matches)) {
                        foreach ($matches[1] as $name) {
                            $permissions[] = trim($name);
                        }
                    }
                }
            }
        }

        $permissions = collect($permissions)->unique()->sort()->values();

        if ($permissions->isEmpty()) {
            $this->warn('Tiada permission ditemui.');
            return;
        }
        $this->newLine();
        $this->info("Menyemak dan menambah permission ke dalam table jika belum wujud...");

        $created = 0;

        foreach ($permissions as $perm) {
            if (!Permission::where('name', $perm)->exists()) {
                Permission::create(['name' => $perm]);
                $created++;
                $this->line("✔️  Permission '{$perm}' ditambah.");
            } else {
                $this->line("ℹ️  Permission '{$perm}' telah wujud.");
            }
        }

        $this->newLine();
        $this->info("Selesai. $created permission baru ditambah.");
    }
}
