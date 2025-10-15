<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        // $news = News::get();
        $news = News::with('comments')->get();
        
        if($news->isEmpty()) {
          return $this->errorResponse($news, "لا يوجد منشورات لعرضها");
        }
        
        return $this->successResponse($news, 'تم الاستعلام على الاخبار بنجاح');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|min:5|max:255',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
        ], [
            'user_id.required' => 'الكاتب مطلوب',
            'category_id.required' => 'القسم مطلوب',
            'title.required' => 'العنوان مطلوب',
            'content.required' => 'المحتوى مطلوب',
        ]);
        try {
          $news = News::create([
            'user_id' => $request->input('user_id'),
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'summary' => $request->input('summary'),
            'content' => $request->input('content'),
          ]);
          return $this->successResponse($news, 'تم حفظ الخبر بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'حدث خطأ أثناء حفظ البيانات: ' . $e->getMessage(), 500);
        }
    }


    public function update(Request $request, $id)
    {
        $news = News::find($id);

        if (!$news) {
            return $this->errorResponse(null, 'الخبر غير موجود', 404);
        }

        $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'title' => 'sometimes|string|min:5|max:255',
            'summary' => 'nullable|string|max:500',
            'content' => 'sometimes|string',
        ], [
            'category_id.exists' => 'القسم غير موجود',
            'title.min' => 'يجب ألا يقل العنوان عن 5 أحرف',
            'title.max' => 'يجب ألا يزيد العنوان عن 255 حرفًا',
            'content.string' => 'يجب أن يكون المحتوى نصًا',
        ]);
        try {
          $news->update([
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'summary' => $request->input('summary'),
            'content' => $request->input('content'),
          ]);

            return $this->successResponse($news, 'تم تعديل الخبر بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage(), 500);
        }
    }


    public function destroy($id)
    {
      $category = News::find($id);

      if(!$category) {
        return $this->errorResponse(null, 'الخبر غير موجود', 404);
      }
      
      $category->delete($id);
      return $this->successResponse(null, 'تم حذف الخبر بنجاح', 200);
    }

    public function news()
    {
      $news = News::with('comments')->get();
      $this->successResponse($news, 'تم حذف الخبر بنجاح', 200);
    }

}
