<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comments;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CommetsController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request)
    {
        $request->validate([
            'news_id' => 'required|exists:news,id',
            'user_id' => 'required|exists:users,id',
            'comment' => 'required|string|min:1|max:1000',
        ], [
            'news_id.required' => 'الخبر مطلوب',
            'news_id.exists' => 'الخبر غير موجود',
            'user_id.required' => 'المستخدم مطلوب',
            'user_id.exists' => 'المستخدم غير موجود',
            'comment.required' => 'التعليق مطلوب',
            'comment.min' => 'يجب ألا يقل التعليق عن حرف واحد',
            'comment.max' => 'يجب ألا يزيد التعليق عن 1000 حرف',
        ]);

        try {
            $comment = Comments::create([
                'news_id' => $request->input('news_id'),
                'user_id' => $request->input('user_id'),
                'comment' => $request->input('comment'),
                'status' => 1,
            ]);

            return $this->successResponse($comment, 'تم حفظ التعليق بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'حدث خطأ أثناء حفظ التعليق: ' . $e->getMessage(), 500);
        }
    }
}
