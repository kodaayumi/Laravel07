@vite(['resources/css/app.css', 'resources/js/app.js'])
@section('title', 'ユーザー編集')

<body class="flex h-screen flex-col">
@include('layouts.header')
<div class="flex-1 mx-auto flex items-center justify-center">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    <a href="{{ url()->previous() }}" class="text-center mb-8 block mx-auto w-[100px] px-2 py-1 bg-gray-500 text-white rounded-lg">戻る</a>
    @csrf
    @method('patch')
    <div class="pb-4">
        <label for="profile_img"><p class="text-center">プロフィール画像</p></label>
        <input type="file" name="profile_img" accept="image/*" onchange="previewImage(event)">
        @error('profile_img') 
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
        <img id="imagePreview" class="w-[100px] rounded-full mx-auto" 
        src="{{ asset('images/' . (auth()->user()->profile_img ? auth()->user()->profile_img : 'default.jpg')) }}" 
        alt="ユーザー画像" style="display: {{ auth()->user()->profile_img ? 'block' : 'none' }};">
    </div>

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

<script>
    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
        }
        
        if (file) {
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '';
            imagePreview.style.display = 'none';
        }
    }
    </script>