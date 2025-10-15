<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Models\Categories;
use App\Traits\ApiResponseTrait;

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

    public function store(CategoriesRequest $request)
    {
        if (auth()->user()->role !== 'admin') {
            return $this->errorResponse(null, 'غير مسموح لك بإضافة فئة', 403);
        }

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

    public function update(CategoriesRequest $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return $this->errorResponse(null, 'غير مسموح لك بتعديل فئة', 403);
        }

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
        if (auth()->user()->role !== 'admin') {
            return $this->errorResponse(null, 'غير مسموح لك بحذف فئة', 403);
        }

      $category = Categories::find($id);

      if(!$category) {
        return $this->errorResponse(null, 'الفئة غير موجودة', 404);
      }

      $category->delete($id);
      return $this->successResponse(null, 'تم حذف الفئة بنجاح', 200);
    }
}
