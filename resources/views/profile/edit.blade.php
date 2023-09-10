@extends('dashboard')

@section('content')

    <section class="is-hero-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
            <h1 class="title">
                Profile
            </h1>
        </div>
    </section>

    <section class="section main-section">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                @include('notification-red')
            @endforeach
        @endif

        @if ($request->session()->has('status'))
            @include('notification-green')
        @endif
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        <span class="icon"><i class="mdi mdi-account-circle"></i></span>
                        Edit Profile
                    </p>
                </header>
                <div class="card-content">
                    <form action="{{ route('profile.update') }}" method="post">
                        @csrf
                        @method('patch')
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input type="text" autocomplete="on" name="name"
                                            value="{{ Auth::user()->name }}" class="input" required="">
                                    </div>
                                    <p class="help">Required. Your name</p>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">E-mail</label>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input type="email" autocomplete="on" name="email"
                                            value="{{ Auth::user()->email }}" class="input" required="">
                                    </div>
                                    <p class="help">Required. Your e-mail</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button green">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        <span class="icon"><i class="mdi mdi-lock"></i></span>
                        Change Password
                    </p>
                </header>
                <div class="card-content">
                    <form action="{{ route('password.update') }}" method="post">
                        @csrf
                        @method('put')
                        <div class="field">
                            <label class="label">Current password</label>
                            <div class="control">
                                <input type="password" name="current_password" autocomplete="current-password"
                                    class="input" required="">
                            </div>
                            <p class="help">Required. Your current password</p>
                        </div>
                        <hr>
                        <div class="field">
                            <label class="label">New password</label>
                            <div class="control">
                                <input type="password" autocomplete="new-password" name="password" class="input"
                                    required="">
                            </div>
                            <p class="help">Required. New password</p>
                        </div>
                        <div class="field">
                            <label class="label">Confirm password</label>
                            <div class="control">
                                <input type="password" autocomplete="new-password" name="password_confirmation"
                                    class="input" required="">
                            </div>
                            <p class="help">Required. New password one more time</p>
                        </div>
                        <hr>
                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button green">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
