<form action="{{route('profile.update', $user)}}">
    @csrf
    @method('put')
    <div class="form-group">
        <label for="name">名前</label>
        <input type="text" name="name" class="form-controller" id="name" value="{{old('name', $user->name)}}">
    </div>
    <div class="form-group">
        <label for="email">メールアドレス</label>
        <input type="text" name="email" class="form-controller" id="email" value="{{old('email', $user->email)}}">
    </div>
    <div class="form-group">
        <label for="password">パスワード</label>
        <input type="password" name="password" class="form-controller" id="password" value="{{old('password', $user->password)}}">
    </div>
    <div class="form-group">
        <label for="password">パスワード再入力</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="パスワードを再入力してください" required autocomplete="new-password">
    </div>
    <button type="submit" class="btn btn-success">送信する</button>
</form>
