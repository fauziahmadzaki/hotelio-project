@php
$user = auth()->user();
$link = '';
if($user->role == 'admin'){
$link = route('admin.dashboard');
}else if($user->role == 'receptionist'){
$link = route('receptionist.dashboard');
}else{
$link = route('guest.dashboard');
}
@endphp
<a href="{{ $link }}">
    <x-button>
        Dashboard
    </x-button>
</a>