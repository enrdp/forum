<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use \App\Models\Thread;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (DB::table('threads')->oldest('id')->cursor() as $thread)

        {
            DB::table('rich_texts')->insert([
                'field' => 'content',
                'body' => '<div>' . $thread->body . '</div>',
                'record_type' => (new Thread)->getMorphClass(),
                'record_id' => $thread->id,
                'created_at' => $thread->created_at,
                'updated_at' => $thread->updated_at,
            ]);
        }

        Schema::table('threads', function (Blueprint $table) {
            $table->dropColumn('body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('the_rich_text', function (Blueprint $table) {
            //
        });
    }
};
