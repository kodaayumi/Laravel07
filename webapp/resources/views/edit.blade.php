
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel07編集</title>
    @include('layouts.header')
</head>
<body>
    <div class="max-w-5xl mx-auto flex items-center justify-center">
<form action="{{ route('regist.edit', ['id' => $task->id]) }}" method="POST">
    @csrf
    
    <div class="pb-4">
        <label for="title"><p class="text-center">タスク名</p></label>
        <input class="rounded-lg w-full" type="text" name="title" value="{{ $task->title }}" required>
    </div>

    <div class="pb-4">
        <label for="user_id"><p class="text-center">担当者</p></label>
        <select class="rounded-lg w-full" name="user_id" required>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @if($user->id == $task->user_id) selected @endif>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="pb-4">
        <label for="task_status"><p class="text-center">ステータス</p></label>
        <select class="rounded-lg w-full" name="task_status" required>
            <option value="1" @if($task->task_status == 1) selected @endif>未着手</option>
            <option value="2" @if($task->task_status == 2) selected @endif>着手中</option>
            <option value="3" @if($task->task_status == 3) selected @endif>保留</option>
            <option value="4" @if($task->task_status == 4) selected @endif>完了</option>
        </select>
    </div>

    <div class="pb-4">
        <label for="comment"><p class="text-center">備考</p></label>   
        <textarea class="rounded-lg w-full" name="comment" cols="30" rows="10">{{ $task->comment }}</textarea>
    </div>

    <button class="cursor-pointer block mx-auto w-[100px] py-2 rounded-lg bg-[#47883C] text-white" type="submit"><p class="text-center">更新</p></button>
</form>
</div>
@include('layouts.footer')

</body>
</html>
