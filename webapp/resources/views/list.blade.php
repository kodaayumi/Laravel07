<h1>一覧画面</h1>
<button onclick="location.href='{{ route('show.create') }}'">新規登録画面へ</button>
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