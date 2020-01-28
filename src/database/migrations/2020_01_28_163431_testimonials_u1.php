<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestimonialsU1 extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('testimonials', function (Blueprint $table) {
			$table->string('first_name', 64)->nullable()->after('company_id');
			$table->string('last_name', 64)->nullable()->after('first_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//
		Schema::table('testimonials', function (Blueprint $table) {
			$table->dropColumn('first_name');
			$table->dropColumn('last_name');
		});
	}
}
