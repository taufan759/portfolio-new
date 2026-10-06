@extends('admin.layout')
@section('title', 'Login')
@section('content')
<div class="card" style="max-width:24rem;margin:4rem auto">
  <h1>Admin login</h1>
  <form method="post" action="{{ url('admin/login') }}">
    @csrf
    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @error('email')<div class="err">{{ $message }}</div>@enderror
    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    <label style="font-weight:400"><input type="checkbox" name="remember" value="1"> Remember me</label>
    <button class="btn" style="margin-top:1rem;width:100%">Sign in</button>
  </form>
</div>
@endsection
