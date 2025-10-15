<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Traits\ApiResponseTrait;

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

    public function store(NewsRequest $request)
    {
        try {
          $news = News::create([
            'user_id' => auth()->id(),
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


    public function update(NewsRequest $request, $id)
    {
        $news = News::find($id);

        if (!$news) {
            return $this->errorResponse(null, 'الخبر غير موجود', 404);
        }

        if ($news->user_id !== auth()->id() ) {
            return $this->errorResponse(null, 'غير مسموح لك بتعديل الخبر', 403);
        }

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
      $news = News::find($id);

      if(!$news) {
        return $this->errorResponse(null, 'الخبر غير موجود', 404);
      }

      if ($news->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return $this->errorResponse(null, 'غير مسموح لك بحذف الخبر', 403);
      }

      $news->delete();
      return $this->successResponse(null, 'تم حذف الخبر بنجاح', 200);
    }

    public function news()
    {
      $news = News::with('comments')->get();
      $this->successResponse($news, 'تم حذف الخبر بنجاح', 200);
    }

}
