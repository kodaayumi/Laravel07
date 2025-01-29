<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Exception;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'user_id', 'task_status', 'comment'];

    //全てのタスクを取得する
    public function getTasks(){
        $tasks = $this->join('users', 'tasks.user_id', '=', 'users.id')
            ->select('tasks.*', 'users.name')
            ->get();

        return $tasks;
    }

    //タスクの担当者を取得する
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //タスクの状態を文字列に変換する
    public function getStatusLabel()
    {
        $statuses = [
        1 => '未処理',
        2 => '進行中',
        3 => '保留',
        4 => '完了',
        ];

    return $statuses[$this->task_status] ?? '不明';
    }



    //新規登録したタスクの内容をDBに保存する
    public function storeTask($request){
        $userName = $request->input('user_name');
        Log::debug('Received user_name: ' . $userName); // ログにユーザー名を出力
    
        $user = User::where('name', $userName)->first();
        if (!$user) {
            throw new \Exception("ユーザーが存在しません");
        }

            Task::create([
                'title' => $request->input('title'),
                'user_id' => $user->id,
                'task_status' => $request->input('task_status'),
                'comment' => $request->input('comment')
            ]);

    }

    //タスクの内容を更新する
    public function updateTask($request, $id){
            $user = User::where('name', $request->input('user_name'))->first();
            if (!$user) {
                throw new Exception("ユーザーが見つかりません");
            }
            $task = Task::find($id);
            if (!$task) {
                throw new Exception("タスクが見つかりません");
            }
            $task->update([
                'title' => $request->input('title'),
                'user_id' => $user->id,
                'task_status' => $request->input('task_status'),
                'comment' => $request->input('comment')
            ]);
    }


    //ポストの削除
    public function deleteTask($id){
            $task = Task::find($id);
            if (!$task) {
                throw new Exception("タスクが見つかりません");
            }

            $task->delete();
    }
}
