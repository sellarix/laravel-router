<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->string('name')->nullable()->after('url');
            $table->string('method_type')->default('GET')->index()->after('name');
            $table->json('parameters')->nullable()->after('method');
            $table->json('middleware')->nullable()->after('parameters');
            $table->integer('model_id')->nullable()->after('middleware')->change();
            $table->string('model_type')->nullable()->after('model_id');
            $table->integer('priority')->default(0)->after('model_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('method_type');
            $table->dropColumn('parameters');
            $table->dropColumn('middleware');
            $table->dropColumn('model_id');
            $table->dropColumn('model_type');
            $table->dropColumn('priority');
        });
    }
};
