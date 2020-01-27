<?php

namespace Abs\TestimonialPkg;
use Abs\Basic\Address;
use Abs\TestimonialPkg\Testimonial;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Validator;
use Yajra\Datatables\Datatables;

class TestimonialController extends Controller {

	public function __construct() {
		$this->data['theme'] = config('custom.admin_theme');
	}

	public function getTestimonialList(Request $request) {
		$testimonials = Testimonial::withTrashed()
			->join('users as cb', 'cb.id', 'testimonials.created_by_id')
			->select([
				'testimonials.id',
				'testimonials.content',
				'testimonials.rating',
				'cb.first_name',
				'cb.last_name',
				DB::raw('testimonials.deleted_at as status'),
			])
			->where('testimonials.company_id', Auth::user()->company_id)
			->where(function ($query) use ($request) {
				if (!empty($request->question)) {
					$query->where('testimonials.question', 'LIKE', '%' . $request->question . '%');
				}
			})
			->orderby('testimonials.id', 'desc');

		return Datatables::of($testimonials)
			->addColumn('question', function ($testimonial) {
				$status = $testimonial->status ? 'green' : 'red';
				return '<span class="status-indicator ' . $status . '"></span>' . $testimonial->question;
			})
			->addColumn('action', function ($testimonial) {
				$img1 = asset('public/themes/' . $this->data['theme'] . '/img/content/table/edit-yellow.svg');
				$img1_active = asset('public/themes/' . $this->data['theme'] . '/img/content/table/edit-yellow-active.svg');
				$img2 = asset('public/themes/' . $this->data['theme'] . '/img/content/table/eye.svg');
				$img2_active = asset('public/themes/' . $this->data['theme'] . '/img/content/table/eye-active.svg');
				$img_delete = asset('public/themes/' . $this->data['theme'] . '/img/content/table/delete-default.svg');
				$img_delete_active = asset('public/themes/' . $this->data['theme'] . '/img/content/table/delete-active.svg');
				$output = '';
				$output .= '<a href="#!/testimonial-pkg/testimonial/edit/' . $testimonial->id . '" id = "" ><img src="' . $img1 . '" alt="Edit" class="img-responsive" onmouseover=this.src="' . $img1_active . '" onmouseout=this.src="' . $img1 . '"></a>
					<a href="#!/testimonial-pkg/testimonial/view/' . $testimonial->id . '" id = "" ><img src="' . $img2 . '" alt="View" class="img-responsive" onmouseover=this.src="' . $img2_active . '" onmouseout=this.src="' . $img2 . '"></a>
					<a href="javascript:;"  data-toggle="modal" data-target="#testimonial-delete-modal" onclick="angular.element(this).scope().deleteRoleconfirm(' . $testimonial->id . ')" title="Delete"><img src="' . $img_delete . '" alt="Delete" class="img-responsive delete" onmouseover=this.src="' . $img_delete_active . '" onmouseout=this.src="' . $img_delete . '"></a>
					';
				return $output;
			})
			->make(true);
	}

	public function getTestimonialFormData(Request $r) {
		$id = $r->id;
		if (!$id) {
			$testimonial = new Testimonial;
			$action = 'Add';
		} else {
			$testimonial = Testimonial::withTrashed()->find($id);
			$action = 'Edit';
		}
		$this->data['testimonial'] = $testimonial;
		$this->data['action'] = $action;

		return response()->json($this->data);
	}

	public function saveTestimonial(Request $request) {
		// dd($request->all());
		try {
			$error_messages = [
				'code.required' => 'Testimonial Code is Required',
				'code.max' => 'Maximum 255 Characters',
				'code.min' => 'Minimum 3 Characters',
				'code.unique' => 'Testimonial Code is already taken',
				'name.required' => 'Testimonial Name is Required',
				'name.max' => 'Maximum 255 Characters',
				'name.min' => 'Minimum 3 Characters',
			];
			$validator = Validator::make($request->all(), [
				'question' => [
					'required:true',
					'max:255',
					'min:3',
					'unique:testimonials,question,' . $request->id . ',id,company_id,' . Auth::user()->company_id,
				],
				'answer' => 'required|max:255|min:3',
			], $error_messages);
			if ($validator->fails()) {
				return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
			}

			DB::beginTransaction();
			if (!$request->id) {
				$testimonial = new Testimonial;
				$testimonial->created_by_id = Auth::user()->id;
				$testimonial->created_at = Carbon::now();
				$testimonial->updated_at = NULL;
			} else {
				$testimonial = Testimonial::withTrashed()->find($request->id);
				$testimonial->updated_by_id = Auth::user()->id;
				$testimonial->updated_at = Carbon::now();
			}
			$testimonial->fill($request->all());
			$testimonial->company_id = Auth::user()->company_id;
			if ($request->status == 'Inactive') {
				$testimonial->deleted_at = Carbon::now();
				$testimonial->deleted_by_id = Auth::user()->id;
			} else {
				$testimonial->deleted_by_id = NULL;
				$testimonial->deleted_at = NULL;
			}
			$testimonial->save();

			DB::commit();
			if (!($request->id)) {
				return response()->json([
					'success' => true,
					'message' => 'FAQ Added Successfully',
				]);
			} else {
				return response()->json([
					'success' => true,
					'message' => 'FAQ Updated Successfully',
				]);
			}
		} catch (Exceprion $e) {
			DB::rollBack();
			return response()->json([
				'success' => false,
				'error' => $e->getMessage(),
			]);
		}
	}

	public function deleteTestimonial($id) {
		$delete_status = Testimonial::withTrashed()->where('id', $id)->forceDelete();
		if ($delete_status) {
			$address_delete = Address::where('address_of_id', 24)->where('entity_id', $id)->forceDelete();
			return response()->json(['success' => true]);
		}
	}
}
