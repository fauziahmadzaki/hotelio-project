@if (session('success') || session('error'))
<div role="alert" id="alert"
    class="fixed top-20 right-5 z-99 rounded-md border {{ session('success')? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50' }} p-4 shadow-sm">
    <div class="flex items-start gap-4"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="-mt-0.5 size-6 text-green-700">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="flex-1"> <strong
                class="block leading-tight font-medium  {{ session('success')? 'text-green-800 ' : 'text-red-800' }} ">
                {{ session('success') ? 'Success' : 'Error' }} </strong>
            <p class="mt-0.5 text-sm {{ session('success') ? 'text-green-700' : 'text-red-700' }}">
                {{ session('success') ?? session('error') }}
            </p>
        </div>
    </div>
</div>


<script>
    setTimeout(() => {
            const toast = document.getElementById('alert');
            if (toast) {
                toast.style.transition = 'opacity 0.5s ease';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);
</script>
@endif