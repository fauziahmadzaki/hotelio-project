<x-auth-layout>
    <x-slot:title>Hotelio | Login</x-slot:title>
    <x-slot:pageName>Login</x-slot:pageName>
    <form action="" method="POST" class="space-y-3">
        @csrf
        <x-input-group id="email" label="Email" value="" type="email" placeholder="someone@example.com"
            error="{{ $errors->first('email') }}"></x-input-group>
        <x-input-group id="password" label="Password" value="" type="password" placeholder="********"
            error="{{ $errors-> first('password') }}"></x-input-group>

        <x-button type="submit" class="w-full text-white">Login</x-button>
    </form>
    <div class="flex gap-2">
        <input type="checkbox">
        <x-label>Ingat saya</x-label>
    </div>
    <p class="text-center text-sm">Belum punya akun? <a href="{{ route('register') }}"
            class="font-semibold text-violet-500">Register</a></p>
</x-auth-layout>