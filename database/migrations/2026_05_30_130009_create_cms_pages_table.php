<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('content');
            $table->text('excerpt')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('type', ['about', 'testimonial', 'faq', 'banner', 'contact', 'other'])->default('other');
            $table->boolean('is_published')->default(true);
            $table->integer('order')->default(0);
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->uuid('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->index('type');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_pages');
    }
};
