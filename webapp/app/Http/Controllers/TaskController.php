<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use DB;
use Log;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    // タスク一覧
    public function index()
    {
        $model = new Task();
        $tasks = $model->getTasks();
        return view('list', ['tasks' => $tasks]);
    }

    // タスク新規登録
    public function showCreate()
    {
        $users = User::all();
        return view('create', ['users' => $users]);
    }

    // タスク登録
    public function storeTask(TaskRequest $request)
    {
        try {
            DB::beginTransaction();
    
            $user = User::find($request->input('user_id'));
            if (!$user) {
                throw new \Exception("ユーザーが存在しません");
            }
    
            Task::create([
                'title' => $request->input('title'),
                'user_id' => $user->id,
                'task_status' => $request->input('task_status'),
                'comment' => $request->input('comment')
            ]);
    
            DB::commit();
            return redirect()->route('index')->with('success', 'タスクが作成されました。');
        } catch (\Exception $e) {
            Log::error('タスク作成エラー: ' . $e->getMessage());
            DB::rollBack();
            return redirect()->route('index')->with('error', 'タスクの作成に失敗しました。');
        }
    }

    // タスク編集
    public function showEdit($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return redirect()->route('index')->with('error', 'タスクが見つかりません。');
        }
        $users = User::all();
        return view('edit', ['task' => $task, 'users' => $users]);
    }

    // タスク更新
    public function registEdit(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return redirect()->route('index')->with('error', 'タスクが見つかりません。');
        }

        try {
            DB::beginTransaction();
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'comment' => 'nullable|string',
                'user_id' => 'required|exists:users,id', // ユーザー名の存在確認
                'task_status' => 'required|integer', // タスクステータスが整数であること
            ]);
            $task->update([
                'title' => $validated['title'],
                'user_id' => $validated['user_id'],
                'task_status' => $validated['task_status'],
                'comment' => $validated['comment'],
            ]);
            DB::commit();
            
            return redirect()->route('index')->with('success', 'タスクを更新しました。');
        } catch (\Exception $e) {
            Log::error('タスク更新エラー: ' . $e->getMessage());
            DB::rollBack();
            return redirect()->route('index')->with('error', 'タスクの更新に失敗しました。');
        }
    }

    // タスク削除
    public function deleteTask($id)
    {
        $model = new Task();
        try {
            DB::beginTransaction();
            $model->deleteTask($id);
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->route('index')->with('error', 'タスクの削除に失敗しました。');
        }
        return redirect()->route('index');
    }
}
?>