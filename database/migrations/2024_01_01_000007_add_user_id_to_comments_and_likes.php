<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('comments', 'user_id')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('post_id')->constrained()->cascadeOnDelete();
            });
        }

        if (! Schema::hasColumn('likes', 'user_id')) {
            Schema::table('likes', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('post_id')->constrained()->cascadeOnDelete();
            });
        }

        $likesIndexes = collect(Schema::getIndexes('likes'))->pluck('name');

        if ($likesIndexes->contains('likes_post_id_email_unique')) {
            Schema::table('likes', function (Blueprint $table) {
                $table->dropForeign(['post_id']);
                $table->dropUnique(['post_id', 'email']);
                $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            });
        }

        if (! $likesIndexes->contains('likes_post_id_user_id_unique')) {
            Schema::table('likes', function (Blueprint $table) {
                $table->unique(['post_id', 'user_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            if (Schema::hasColumn('likes', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropUnique(['post_id', 'user_id']);
                $table->dropColumn('user_id');
            }

            $table->dropForeign(['post_id']);
            $table->unique(['post_id', 'email']);
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
        });

        Schema::table('comments', function (Blueprint $table) {
            if (Schema::hasColumn('comments', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};
