<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::all();
        return response()->json(['msg'=>'All Feedback Received','feedbacks'=>$feedbacks],200);
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $deleted =  $feedback->delete();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'deleted_successfully']);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'fail_while_delete']);
        }
    }
}
