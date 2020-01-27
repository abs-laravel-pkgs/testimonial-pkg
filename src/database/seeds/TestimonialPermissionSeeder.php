<?php
namespace Abs\TestimonialPkg\Database\Seeds;

use App\Permission;
use Illuminate\Database\Seeder;

class TestimonialPermissionSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$permissions = [
			//TESTIMONIALS
			[
				'display_order' => 99,
				'parent' => null,
				'name' => 'testimonials',
				'display_name' => 'Testimonials',
			],
			[
				'display_order' => 1,
				'parent' => 'testimonials',
				'name' => 'add-testimonial',
				'display_name' => 'Add',
			],
			[
				'display_order' => 2,
				'parent' => 'testimonials',
				'name' => 'delete-testimonial',
				'display_name' => 'Edit',
			],
			[
				'display_order' => 3,
				'parent' => 'testimonials',
				'name' => 'delete-testimonial',
				'display_name' => 'Delete',
			],

		];
		Permission::createFromArrays($permissions);
	}
}