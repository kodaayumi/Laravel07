<h1>新規作成画面</h1>
<form action="{{ route('store.task') }}" method="post">
    @csrf
    <div>
        タイトル
        <input type="text" name="title">
    </div>


    <div>
        投稿者
        <select name="user_id" required>
            <option value="">選択してください</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
    ステータス
    <select name="task_status" required>
        <option value="">選択してください</option>
        <option value="1">未処理</option>
        <option value="2">進行中</option>
        <option value="3">保留</option>
        <option value="4">完了</option>
    </select>
    </div>
    <div>
        本文
        <textarea name="content" id="" cols="30" rows="10"></textarea>
    </div>
    <input type="submit">
</form>