<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $category = Categories::get();

        if($category->isEmpty()) {
          return $this->errorResponse($category, "don't found data");
        }

        return $this->successResponse($category, "تم الاستعلام على الفئات بنجاح");
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|min:10|max:250',
            'note' => 'required|string|min:10|max:250',
        ], [
            'category_name.required' => 'اسم الفئة مطلوب',
            'category_name.string' => 'يجب أن يكون اسم الفئة مكونًا من حروف',
            'category_name.min' => 'يجب ألا يقل اسم الفئة عن 10 أحرف',
            'category_name.max' => 'يجب ألا يزيد اسم الفئة عن 250 حرفًا',

            'note.required' => 'الوصف مطلوب',
            'note.string' => 'يجب أن يكون الوصف نصًا فقط',
            'note.min' => 'يجب ألا يقل الوصف عن 10 أحرف',
            'note.max' => 'يجب ألا يزيد الوصف عن 250 حرفًا',
        ]);
        try{
          $data = Categories::create([
            'category_name' => $request->input('category_name'),
            'note' => $request->input('note'),
          ]);
          $message = "تم حفظ بيانات الفئة بنجاح";
          return $this->successResponse($data, $message);
        }catch(\Exception $e){
          return $this->errorResponse(null, 'حدث خطأ أثناء حفظ البيانات: ' . $e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|min:10|max:250',
            'note' => 'required|string|min:10|max:250',
        ], [
            'category_name.required' => 'اسم الفئة مطلوب',
            'category_name.string' => 'يجب أن يكون اسم الفئة مكونًا من حروف',
            'category_name.min' => 'يجب ألا يقل اسم الفئة عن 10 أحرف',
            'category_name.max' => 'يجب ألا يزيد اسم الفئة عن 250 حرفًا',

            'note.required' => 'الوصف مطلوب',
            'note.string' => 'يجب أن يكون الوصف نصًا فقط',
            'note.min' => 'يجب ألا يقل الوصف عن 10 أحرف',
            'note.max' => 'يجب ألا يزيد الوصف عن 250 حرفًا',
        ]);
        try{
          $category = Categories::find($id);

          if (!$category) {
            return $this->errorResponse(null, 'الفئة غير موجودة', 404);
          }

          $category->update([
            'category_name' => $request->input('category_name'),
            'note' => $request->input('note'),
          ]);
          return $this->successResponse($category, 'تم تحديث الفئة بنجاح', 200);
        }catch(\Exception $e){
          return $this->errorResponse($e->getMessage(), 'حدث خطأ أثناء التحديث', 500);
        }
    }

    public function destory($id)
    {
      $category = Categories::find($id);

      if(!$category) {
        return $this->errorResponse(null, 'الفئة غير موجودة', 404);
      }
      
      $category->delete($id);
      return $this->successResponse(null, 'تم حذف الفئة بنجاح', 200);
    }
}
