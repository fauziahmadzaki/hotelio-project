@props(['class' => ''])
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <x-button class="{{ $class }}">Logout</x-button>
</form>