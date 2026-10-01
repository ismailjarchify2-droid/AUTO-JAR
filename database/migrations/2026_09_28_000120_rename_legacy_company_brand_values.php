<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $legacyNames = [
            'AUTO-JAR',
            'AUTO-JAR',
            'AUTO-JAR',
            'AUTO-JAR',
            'AUTO-JAR',
        ];

        DB::table('settings')
            ->where('key', 'company_name')
            ->whereIn('value', $legacyNames)
            ->update(['value' => 'AUTO-JAR']);

        DB::table('products')
            ->whereNotNull('meta_title')
            ->orderBy('id')
            ->chunkById(100, function ($products) use ($legacyNames): void {
                foreach ($products as $product) {
                    $metaTitle = str_ireplace($legacyNames, 'AUTO-JAR', $product->meta_title);

                    if ($metaTitle !== $product->meta_title) {
                        DB::table('products')
                            ->where('id', $product->id)
                            ->update(['meta_title' => $metaTitle]);
                    }
                }
            });
    }

    public function down(): void
    {
    }
};