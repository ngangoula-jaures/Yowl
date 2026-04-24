<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comment_likes', function (Blueprint $table) {
            // Supprimer la clé étrangère et la colonne post_id (erreur dans la migration initiale)
            $table->dropForeign(['post_id']);
            $table->dropColumn('post_id');
            // Ajouter la bonne colonne : comment_id
            $table->foreignId('comment_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comment_likes', function (Blueprint $table) {
            $table->dropForeign(['comment_id']);
            $table->dropColumn('comment_id');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
        });
    }
};
