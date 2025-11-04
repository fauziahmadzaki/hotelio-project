<x-auth-layout>
    <x-slot:title>Hotelio | Register</x-slot:title>
    <x-slot:pageName>Register</x-slot:pageName>
    <x-slot:description>Silahkan Register untuk mengakses sistem kami</x-slot:description>
    <form action="" method="POST" class="space-y-2">
        @csrf
        <x-input-group id="name" label="Name" value="{{ old('name') }}" type="text" placeholder="John Doe"
            error="{{ $errors->first('name') }}">
        </x-input-group>
        <x-input-group id="email" label="Email" value="{{ old('email') }}" type="email"
            placeholder="someone@example.com" error="{{ $errors->first('email') }}">
        </x-input-group>
        <x-input-group id="password" label="Password" placeholder="********" type="password"
            error="{{ $errors->first('password') }}"></x-input-group>
        <x-input-group id="confirmPassword" label="Konfirmasi Password" placeholder="********" type="password"
            error="{{ $errors->first('confirmPassword') }}"></x-input-group>
        <x-button type="submit" class="w-full text-white">Login</x-button>
    </form>
    <p class="text-center text-sm">Sudah punya akun? <a href="{{ route('login') }}"
            class="font-semibold text-violet-500">Login</a></p>
</x-auth-layout>