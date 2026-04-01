@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-16 min-h-screen">
    <div class="container mx-auto px-4">
        <!-- Page Title -->
        <div class="text-center mb-16">
            <h1 class="font-heading text-5xl font-bold uppercase tracking-widest text-white mb-4">Our <span class="text-brand-500">Brands</span></h1>
            <div class="w-16 h-1 bg-brand-500 mx-auto"></div>
            <p class="text-gray-400 mt-6 max-w-2xl mx-auto">We partner with the world's leading manufacturers to bring you only the highest quality, professional-grade fitness equipment.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
            @forelse($brands as $brand)
                <a href="{{ route('brand.show', $brand->id) }}" class="bg-dark-800 p-8 flex flex-col items-center justify-center border border-dark-700 hover:border-brand-500 transition-colors group relative" style="min-height: 200px;">
                    @if($brand->logo_path)
                        <img src="{{ Storage::url($brand->logo_path) }}" alt="{{ $brand->name }}" class="max-w-full h-auto object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300 mb-4 opacity-70 group-hover:opacity-100">
                    @endif
                    
                    <h3 class="font-heading text-lg font-bold uppercase tracking-wider text-white group-hover:text-brand-500 transition-colors text-center w-full truncate">{{ $brand->name }}</h3>
                    <span class="text-xs text-gray-500 font-heading uppercase tracking-widest mt-2">{{ $brand->products_count ?? 0 }} Items</span>
                    
                    <!-- Hover overlay accent -->
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-brand-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></div>
                </a>
            @empty
                <div class="col-span-2 md:col-span-4 lg:col-span-5 text-center py-20">
                    <h3 class="text-xl font-heading text-white uppercase tracking-widest">No brands available</h3>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
