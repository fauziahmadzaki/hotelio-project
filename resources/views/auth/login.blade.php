<x-auth-layout>
    <x-slot:title>Hotelio | Login</x-slot:title>
    <x-slot:pageName>Login</x-slot:pageName>
    <form action="" method="POST" class="space-y-3">
        @csrf
        <x-input-group id="email" label="Email" value="" type="text" placeholder="someone@example.com"
            error="{{ $errors->first('email') }}"></x-input-group>
        <x-input-group id="password" label="Password" value="" type="password" placeholder="********"
            error="{{ $errors-> first('password') }}"></x-input-group>

        <x-button type="submit" class="w-full text-white bg-violet-500">Login</x-button>
    </form>
    <p class="text-center text-sm">Belum punya akun? <a href="{{ route('register') }}"
            class="font-semibold text-violet-500">Register</a></p>
</x-auth-layout>