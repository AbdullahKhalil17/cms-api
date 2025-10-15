<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommetsRequest;
use App\Models\Comments;
use App\Traits\ApiResponseTrait;

class CommetsController extends Controller
{
    use ApiResponseTrait;

    public function store(CommetsRequest $request)
    {

        try {
            $comment = Comments::create([
                'news_id' => $request->input('news_id'),
                'user_id' => auth()->id(),
                'comment' => $request->input('comment'),
                'status' => 1,
            ]);

            return $this->successResponse($comment, 'تم حفظ التعليق بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'حدث خطأ أثناء حفظ التعليق: ' . $e->getMessage(), 500);
        }
    }

    public function update(CommetsRequest $request, $id)
    {
        $comment = Comments::find($id);

        if (!$comment) {
            return $this->errorResponse(null, 'التعليق غير موجود', 404);
        }

        if ($comment->user_id !== auth()->id() ) {
            return $this->errorResponse(null, 'غير مسموح لك بتعديل التعليق', 403);
        }

        try {
            $comment->update([
                'comment' => $request->input('comment'),
            ]);

            return $this->successResponse($comment, 'تم تعديل التعليق بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'حدث خطأ أثناء تعديل التعليق: ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        $comment = Comments::find($id);

        if (!$comment) {
            return $this->errorResponse(null, 'التعليق غير موجود', 404);
        }

        if ($comment->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return $this->errorResponse(null, 'غير مسموح لك بحذف التعليق', 403);
        }

        try {
            $comment->delete();
            return $this->successResponse(null, 'تم حذف التعليق بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'حدث خطأ أثناء حذف التعليق: ' . $e->getMessage(), 500);
        }
    }
}
