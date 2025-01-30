@vite(['resources/css/app.css', 'resources/js/app.js'])
@section('title', 'タスク一覧')

<body class="flex h-screen flex-col">
@include('layouts.header')
    <section class="flex-1 max-w-5xl w-full mx-auto">
    <div class="mb-8 flex items-center">
    <img class="w-1/6 rounded-full" 
     src="{{ asset(auth()->user()->profile_img == 'default.jpg' ? 'images/default.jpg' : 'storage/' . auth()->user()->profile_img) }}" 
     alt="ユーザー画像">
        <div class="text-center">
            <p>ユーザー名</p>
            <p>{{ auth()->user()->name }}</p>
        </div>
    </div>

    <form action="{{ route('tasks.search') }}" method="GET">
    <input class="rounded-lg mb-4 w-[300px]" type="text" name="query" placeholder="タスク名またはIDを入力">

    <select name="user_id" class="rounded-lg mb-4">
    <option value="all">担当者を選択</option>
    @foreach ($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach
    </select>

    <select name="status" class="rounded-lg mb-4">
    <option value="">ステータスを選択</option>
    @foreach ($task_statuses as $id => $name)
        <option value="{{ $id }}" {{ request('status') == $id ? 'selected' : '' }}>
            {{ $name }}
        </option>
    @endforeach
    </select>



    <button class="rounded-lg w-[100px] bg-[#47883C] px-3 py-2 text-white" type="submit">検索</button>
    @if($tasks->isEmpty())
    <p class="text-red-500">結果が見つかりませんでした。</p>
    @endif
</form>

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
                    <form class="my-auto inline-block bg-[#B22222] text-white rounded-lg px-3" action="{{ route('delete', ['id' => $task->id]) }}" method="post">
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