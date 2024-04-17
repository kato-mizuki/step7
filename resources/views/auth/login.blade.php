@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <table align="center">
            <thead>
                <tr>
                    <th>
                    {{ __('ユーザーログイン画面') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            
                            <div class="form-group row">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="パスワード">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </input>
                            </div>
                        
                    </td>
                    <tr></tr>
                    <tr>
                        <td>
                            <div class="form-group row">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="アドレス">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </input>
                            </div>
                        </td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td>
                            <div class="form-group row mb-0">
                                <div style="margin-top:20px">
                                    <button type="submit" class="btn btn-warning">
                                        <a href="{{ route('register') }}" >
                                            {{__('新規登録')}}
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group row mb-0">
                                <div style="margin-top:20px">
                                    <button type="submit" class="btn btn-info">
                                            {{ __('ログイン') }}
                                    </button>
                                </div>
                            </div>
                            </form>
                        </td>

                    </tr>
            </tbody>
        </table> 
    </div>
</div>
@endsection 