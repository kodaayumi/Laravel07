<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use DB;
use Log;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // タスク一覧、ソート機能
    public function index(Request $request)
    {
        $sortColum = $request->get('sort', 'id');
        $sortDirection = $request->get('direction', 'asc');
        $sorttableColumns = ['id', 'title', 'user_id', 'task_status'];

        if (!in_array($sortColum, $sorttableColumns)) {
            $sortColum = 'id';
        }

        $tasks = Task::with('user')
        ->orderBy($sortColum, $sortDirection)
        ->get();

        $newDirection = ($sortDirection == 'asc') ? 'desc' : 'asc';
        
        $users = User::all();
        $task_statuses = [
            1 => '未着手',
            2 => '進行中',
            3 => '保留',
            4 => '完了'
        ];
        return view('list', ['tasks' => $tasks, 'users' => $users, 'task_statuses' => $task_statuses, 'sortColumn' => $sortColum, 'sortDirection' => $sortDirection, 'newDirection' => $newDirection]);
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
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $task = Task::findOrFail($id);
            $task->delete();
            DB::commit();
            
            return redirect()->route('index')->with('success', 'タスクを削除しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->route('index')->with('error', 'タスクの削除に失敗しました。');
        }
}

    // タスク検索
    public function search(Request $request)
    {
        $query = $request->input('query');
        $user_id = $request->input('user_id');
        $status = $request->input('status');
    
        $tasks = Task::query();
    
        // タスク名またはIDで検索
        if ($query) {
            $tasks->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%"); // タスク名で検索
                if (is_numeric($query)) {
                    $q->orWhere('id', $query); // 数字ならID検索
                }
            });
        }
    
        // 担当者でフィルタリング
        if ($user_id === 'self') {
            $tasks->where('user_id', Auth::id()); // ログイン中のユーザーのIDでフィルタリング
        } elseif ($user_id && $user_id !== 'all') {
            $tasks->where('user_id', $user_id); // 指定されたユーザーIDでフィルタリング
        }

        // ステータスでフィルタリング
        if (!empty($status)) {
            $tasks->where('task_status', $status);
        }

        $tasks = $tasks->get();

        // ユーザーリストとステータスリストを取得
        $users = User::all();
        $task_statuses = [
            1 => '未処理',
            2 => '進行中',
            3 => '保留',
            4 => '完了'
        ];

        return view('list', compact('tasks', 'users', 'task_statuses'));
    }

    }
?>