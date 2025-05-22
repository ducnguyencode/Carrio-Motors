<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_media_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform_name');
            $table->string('url');
            $table->string('icon_class');
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

        // Insert default social media links
        $socialMediaLinks = [
            [
                'platform_name' => 'Facebook',
                'url' => 'https://facebook.com',
                'icon_class' => 'fab fa-facebook-f',
                'is_active' => true,
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Twitter',
                'url' => 'https://twitter.com',
                'icon_class' => 'fab fa-twitter',
                'is_active' => true,
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Instagram',
                'url' => 'https://instagram.com',
                'icon_class' => 'fab fa-instagram',
                'is_active' => true,
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'LinkedIn',
                'url' => 'https://linkedin.com',
                'icon_class' => 'fab fa-linkedin-in',
                'is_active' => true,
                'display_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('social_media_links')->insert($socialMediaLinks);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_links');
    }
};
