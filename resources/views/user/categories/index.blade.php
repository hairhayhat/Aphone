<x-app-layout>
    <div
        class="simple-banner bg-black text-white h-40 md:h-48 flex items-center justify-center overflow-hidden relative">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="animate-pulse opacity-5">
                <div class="grid grid-cols-5 gap-8">
                    @for ($i = 0; $i < 10; $i++)
                        <div class="w-8 h-8 border border-white rounded-full"></div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="relative text-center px-4">
            <h2 class="text-2xl md:text-4xl font-bold mb-2 tracking-wider">Danh mục của chúng tôi</h2>
            <p class="text-sm md:text-base opacity-80">Công nghệ mới nhất - Giá cả tốt nhất</p>
        </div>

        <div
            class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white to-transparent animate-marquee">
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-8">
        @foreach ($categories as $category)
            <a href="">
                <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center relative">
                    <img src="{{ Storage::url($category->thumbnail) }}" alt=""
                        class="absolute inset-0 w-full h-full object-cover rounded-lg opacity-20">
                    <h3 class="text-lg font-semibold mb-2 relative z-10">{{ $category->name }}</h3>
                </div>
            </a>
        @endforeach
    </div>

    <style>
        .animate-marquee {
            animation: marquee 3s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }
    </style>
</x-app-layout>
