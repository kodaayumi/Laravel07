<form action="{{ route('update.edit', ['id' => $task->id]) }}" method="POST">
    @csrf
    
    <div>
        <label for="title">タイトル</label>
        <input type="text" name="title" value="{{ $task->title }}" required>
    </div>

    <div>
        <label for="user_name">投稿者</label>
        <select name="user_name" required>
            @foreach ($users as $user)
                <option value="{{ $user->name }}" @if($user->name == $task->user->name) selected @endif>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="task_status">ステータス</label>
        <select name="task_status" required>
            <option value="1" @if($task->task_status == 1) selected @endif>未着手</option>
            <option value="2" @if($task->task_status == 2) selected @endif>着手中</option>
            <option value="3" @if($task->task_status == 3) selected @endif>保留</option>
            <option value="4" @if($task->task_status == 4) selected @endif>完了</option>
        </select>
    </div>

    <div>
        <label for="comment">コメント</label>
        <textarea name="comment">{{ $task->comment }}</textarea>
    </div>

    <button type="submit">更新</button>
</form>
