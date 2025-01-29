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
    <div class="flex">
        <img src="" alt="">
        <div class="text-center">
            <p>ユーザー名</p>
            <p>{{ auth()->user()->name }}</p>
        </div>
    </div>
<table>
    <thead>
        <tr>
            <th>id</th>
            <th>タイトル</th>
            <th>投稿者</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->author_name }}</td>
                <td><button onclick="location.href='{{ route('show.edit', ['id' => $task->id]) }}'">編集</button></td>
                <td>
                    <form action="{{ route('delete', ['id' => $task->id]) }}" method="post">
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