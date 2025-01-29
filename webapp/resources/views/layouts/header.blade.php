@vite(['resources/css/app.css'])
<div class="bg-[#9BC893] mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center mb-8">
    <div class="flex justify-between max-w-5xl mx-auto items-center">
        <h1 class="font-bold text-white">{{ config('app.name', 'Laravel') }}</h1>
        <nav class="bg-white rounded-xl px-8 py-2">
            <ul class="flex space-x-8">
                <li class="text-[#47883C] bg-[#E3E387] px-3 py-2 rounded rounded-full"><a href="{{ route('index') }}">タスク一覧</a></li>
                <li class="text-[#47883C] bg-[#E3E387] px-3 py-2 rounded rounded-full"><a href="{{ route('show.create') }}">タスク新規登録</a></li>
                <li class="text-[#47883C] bg-[#E3E387] px-3 py-2 rounded rounded-full"><a href="">ユーザー情報変更</a></li>
            </ul>
        </nav>
        <h2 class="text-[#47883C] bg-[#E3E387] px-3 py-2 rounded rounded-full"><a href="{{ route('logout') }}">ログアウト</a></h2>
    </div>
</div>