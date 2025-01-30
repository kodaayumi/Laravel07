@vite(['resources/css/app.css', 'resources/js/app.js'])
@section('title', 'ユーザー編集')

<body class="flex h-screen flex-col">
@include('layouts.header')
<div class="flex-1 mx-auto flex items-center justify-center">
<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
<a href="{{ url()->previous() }}" class="text-center mb-8 block mx-auto w-[100px] px-2 py-1 bg-gray-500 text-white rounded-lg">戻る</a>
    @csrf
    @method('patch')
    <div>
        <label class="block text-center" for="profile_img">プロフィール画像</label>
        <img class="w-[100px] rounded-full mx-auto" 
        src="{{ asset('storage/' . (auth()->user()->profile_img ? auth()->user()->profile_img : 'images/default.jpg')) }}" 
        alt="ユーザー画像">
    </div>
    <input class="cursor-pointer block mx-auto" type="file" name="profile_img" id="profile_img" accept="image/*" onchange="previewImage(event)">
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
        <button class="cursor-pointer block mx-auto w-[100px] py-2 rounded-lg bg-[#47883C] text-white" type="submit" class="btn btn-success">送信する</button>
</form>
</div>
@include('layouts.footer')

</body>
</html>