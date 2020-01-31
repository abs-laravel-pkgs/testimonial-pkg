<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestimonialsU2 extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('testimonials', function (Blueprint $table) {
			$table->unsignedMediumInteger('display_order')->default(999)->after('entity_type_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('testimonials', function (Blueprint $table) {
			$table->dropColumn('display_order');
		});
	}
}
