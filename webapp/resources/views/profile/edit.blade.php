@vite(['resources/css/app.css', 'resources/js/app.js'])
@section('title', 'ユーザー編集')

<body class="flex h-screen flex-col">
@include('layouts.header')
<div class="flex-1 mx-auto flex items-center justify-center">
<form action="{{route('profile.update', $user)}}">
<a href="{{ url()->previous() }}" class="text-center mb-8 block mx-auto w-[100px] px-2 py-1 bg-gray-500 text-white rounded-lg">戻る</a>
    @csrf
    @method('put')
        <div class="pb-4">
            <div class="form-group">
                <label class="block text-center" for="name">名前</label>
                <input class="rounded-lg w-full" type="text" name="name" class="form-controller" id="name" value="{{old('name', $user->name)}}">
            </div>
        </div>
        <div class="pb-4">
            <label class="block text-center" for="email">メールアドレス</label>
            <input class="rounded-lg w-full" type="text" name="email" class="form-controller" id="email" value="{{old('email', $user->email)}}">
        </div>
        <div class="pb-4">
            <label class="block text-center" for="password">パスワード</label>
            <input class="rounded-lg w-full" type="password" name="password" class="form-controller" id="password" value="{{old('password', $user->password)}}">
        </div>
        <div class="pb-4">
            <label class="block text-center" for="password">パスワード再入力</label>
            <input class="rounded-lg w-full" type="password" name="password_confirmation" class="form-controller" id="password-confirm" placeholder="パスワードを再入力してください" required autocomplete="new-password">
        </div>
        <button class="cursor-pointer block mx-auto w-[100px] py-2 rounded-lg bg-[#47883C] text-white" type="submit" class="btn btn-success">送信する</button>
</form>
</div>
@include('layouts.footer')

</body>
</html>