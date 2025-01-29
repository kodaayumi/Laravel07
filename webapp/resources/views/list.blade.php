<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
@include('layouts.header')
    <section class="max-w-5xl mx-auto">
    <div class="mb-8 flex items-center">
        <img class="w-1/6 rounded-full" src="{{ asset('images/default.jpg') }}" alt="ユーザー画像">
        <div class="text-center">
            <p>ユーザー名</p>
            <p>{{ auth()->user()->name }}</p>
        </div>
    </div>
<table class="w-full">
    <thead>
        <tr class="h-10">
            <th>id</th>
            <th>タスク名</th>
            <th>担当者</th>
            <th>ステータス</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
            <tr class="h-10">
                <td class="text-center">{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td class="text-center">{{ $task->user->name ?? '未設定' }}</td>
                <td class="text-center">{{ $task->getStatusLabel() }}</td>
                <td>
                    <button class="bg-[#47883C] text-white rounded-lg px-3" onclick="location.href='{{ route('show.edit', ['id' => $task->id]) }}'">
                        編集
                    </button>
                </td>
                <td>
                    <form class="inline-block bg-[#B22222] text-white rounded-lg px-3" action="{{ route('delete', ['id' => $task->id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit">削除</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</section>
@include('layouts.footer')
</body>
</html>