<x-layout>
    <x-slot:title>Hotelio App</x-slot:title>
    <x-navbar></x-navbar>
    <section class="section min-h-svh w-full bg-no-repeat bg-cover
    " style="background-image: url('{{ asset('images/hero.jpg') }}')">
        <div class="w-full h-screen bg-black/40 flex flex-col items-center justify-center gap-5">
            <p class="text-white text-lg font-semibold">
                Hotel nyaman, kebersihan, dan fasilitas terbaik
            </p>
            <h1 class="text-7xl font-extrabold text-white">Hotelio</h1>
            <p class="text-base font-extralight block max-w-md text-center text-white">Lorem ipsum dolor sit amet
                consectetur
                adipisicing elit. Tempore reprehenderit cumque eius voluptatum fugiat recusandae.</p>
            <x-button class="text-white"><a href="#about">Mulai Sekarang</a></x-button>
        </div>
    </section>
    <section class="max-w-5xl mx-auto min-h-svh p-40 space-y-5">
        <h1 id="about" class="text-3xl font-bold text-center">Available Rooms</h1>



    </section>

</x-layout>