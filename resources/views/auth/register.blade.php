@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <table align="center">
                <thaed>
                    <tr>
                        <th class="text-center">
                            {{ __('ユーザー新規登録画面') }}
                        </th>
                    </tr>
                    <tr><td></td></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group row">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="パスワード">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>  
                            
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="mx-auto">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="アドレス">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <div style="margin-top:20px">
                                <button type="submit" class="btn btn-warning">
                                    {{ __('新規登録') }}
                                </button>
                            </div>
                            </form>
                        </td>
                        <td>
                            <div style="margin-top:20px">
                                <button type="submit" class="btn btn-info">
                                    <a href="{{ route('login') }}">戻る</a>
                                </button>  
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection