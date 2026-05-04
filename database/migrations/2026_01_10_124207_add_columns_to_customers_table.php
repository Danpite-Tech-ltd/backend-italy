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
        Schema::table('customers', function (Blueprint $table) {
             $table->string('piva')->nullable()->after('address');
            $table->string('codice_fiscal')->nullable()->after('piva');
            $table->string('cap')->nullable()->after('codice_fiscal');
            $table->string('pec')->nullable()->after('cap');
            $table->string('catasto_destinatario')->nullable()->after('pec');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
             $table->dropColumn([
                'piva',
                'codice_fiscal',
                'cap',
                'pec',
                'catasto_destinatario'
            ]);
        });
    }
};
