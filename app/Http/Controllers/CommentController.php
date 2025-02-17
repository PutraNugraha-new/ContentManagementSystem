<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return view('admin.comments.index', compact('comments'));
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,pending,approved',
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id'
        ]);

        $comments = Comment::whereIn('id', $request->comment_ids);

        switch ($request->action) {
            case 'delete':
                $comments->delete();
                $message = 'Comment berhasil dihapus';
                break;
            case 'pending':
                $comments->update(['status' => 'pending']);
                $message = 'Status Comment berhasil diubah menjadi pending';
                break;
            case 'approved':
                $comments->update(['status' => 'approved']);
                $message = 'Comment berhasil diapproved';
                break;
        }

        return response()->json([
            'message' => $message
        ]);
    }
}
