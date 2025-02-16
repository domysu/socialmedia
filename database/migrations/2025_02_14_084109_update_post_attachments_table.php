<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('post_reactions', 'reactions');
       Schema::table('reactions', function (Blueprint $table){
        $table->dropForeign(['post_id']);  
        $table->dropColumn('post_id');

      

        $table->unsignedBigInteger('object_id');
        $table->string('object_type');

        

       });
       DB::table('reactions')->update(['object_type' => 'App\Models\Post']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reactions', function(Blueprint $table){
            $table->dropColumn(['object_id','object_type']);
            $table->foreignId('post_id')->nullable()->constrained('posts')->onDelete('cascade');


        });
        Schema::rename('reactions', 'post_reactions');
    }
};
