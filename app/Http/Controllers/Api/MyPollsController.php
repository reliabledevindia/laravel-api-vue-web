<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\User;
use App\Polls;
use App\UserPollVotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class MyPollsController extends Controller
{

     function __construct(Polls $Polls,UserPollVotes $UserPollVotes) {
       $this->Polls = $Polls;
       $this->UserPollVotes = $UserPollVotes;
    }

     /**
     * Get Polls list fir authenticated user by token.
     * Return already voted polls status true|false
     * @return Response @user Data json
     */
    public function getPolls()
    {
      $polls = $this->Polls->with('options')->where('status',1)->get();
      $response = array();
      //$response['selectedIds'] = [null,null,null,null,2,8,null,null,null,null,null,32];
      $response['selectedIds'] = $this->getSelectedOptionsIds($polls);
      foreach ($polls as $key => $poll) {
        $response[$key]['id'] = $poll->id;
        $response[$key]['question'] = $poll->question;
        foreach ($poll->options as $optKey => $option) {
           $response[$key]['option'][$optKey]['selected'] = $option->checkOptionisChecked($option->id);
           $response[$key]['option'][$optKey]['id'] = $option->id;
           $response[$key]['option'][$optKey]['name'] = $option->name;
        }
      }
        return response()->json(
        [
            'status' => 'success',
            'data' => $response
        ], 200);
    }

    public function getSelectedOptionsIds($polls)
    {
      $selectedIds[0] = NULL;
      foreach($polls as $key => $poll){
         $checkSelected = $this->UserPollVotes->where('user_id',auth()->user()->id)->where('poll_id',$poll->id)->first();
         
         $selectedIds[$poll->id] = NULL;
         if($checkSelected){
          $selectedIds[$poll->id] = $checkSelected->polls_option_id;
        }
      }
      return $selectedIds;
    }

    /**
     * Update Authenticated User Poll votes.
     * Return already voted polls status true|false
     * @return response
     */
    public function updateUserVote(Request $request)
    {
      Validator::extend('check_array', function ($attribute, $value, $parameters, $validator) {
          return count(array_filter($value, function($var) use ($parameters) { return ( $var && $var >= $parameters[0]); }));
      });
      $v = Validator::make($request->all(), [
          'answer' => 'check_array:1',
      ]);
      if ($v->fails())
      {
          return response()->json([
              'status' => 'error',
              'errors' => $v->errors()
          ], 422);
      }
      auth()->user()->pollVotes()->delete();
      foreach ($request->get('answer') as $pId => $opId) {
        if($opId != NULL && $opId != ''){
          $this->UserPollVotes->create([
            'user_id' => Auth::user()->id,
            'poll_id' => $pId,
            'polls_option_id' => $opId
          ]);
        }
      }
      $response['status_code'] = 200;
      $response['status'] = 'success';
      $response['message'] = 'Sucessfully updated';
      return response()->json($response, 200);
    }
}