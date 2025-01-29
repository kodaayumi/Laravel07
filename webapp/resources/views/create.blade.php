<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel07新規作成</title>
    @include('layouts.header')
</head>

<body>
    <div class="max-w-5xl mx-auto flex items-center justify-center">
<form action="{{ route('store.task') }}" method="post">
    @csrf
    <div class="pb-4">
        <p class="text-center">タスク名</p>
        <input class="rounded-lg w-full" type="text" name="title">
    </div>


    <div class="pb-4">
        <p class="text-center">担当者</p>
        <select class="rounded-lg w-full" name="user_id" required>
            <option value="">選択してください</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="pb-4">
        <p class="text-center">ステータス</p>
        <select class="rounded-lg w-full" name="task_status" required>
        <option value="">選択してください</option>
        <option value="1">未処理</option>
        <option value="2">進行中</option>
        <option value="3">保留</option>
        <option value="4">完了</option>
    </select>
    </div>

    <div class="pb-4">
        <p class="text-center">備考</p>
        <textarea class="rounded-lg w-full" name="comment" id="" cols="30" rows="10"></textarea>
    </div>
    <input class="cursor-pointer block mx-auto w-[100px] py-2 rounded-lg bg-[#47883C] text-white" type="submit">
</form>
</div>

@include('layouts.footer')
</body>

</html>