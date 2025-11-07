<x-auth-layout>

    <x-slot:pageName>Reset Password</x-slot:pageName>
    <x-slot:description>Masukkan password baru</x-slot:description>
    <form action="" method="POST" class="space-y-3">
        @csrf
        <x-input-group id="password" label="Password" value="" type="password" placeholder="********"
            error="{{ $errors-> first('password') }}"></x-input-group>
        <x-input-group id="confirm_password" label="Konfirmasi Password" value="" type="password" placeholder="********"
            error="{{ $errors-> first('confirm_password') }}"></x-input-group>

        <x-button type="submit" class="w-full text-white bg-violet-500">Reset</x-button>
    </form>

</x-auth-layout>