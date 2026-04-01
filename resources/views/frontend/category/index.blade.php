@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-16 min-h-screen">
    <div class="container mx-auto px-4">
        <!-- Page Title -->
        <div class="text-center mb-16">
            <h1 class="font-heading text-5xl font-bold uppercase tracking-widest text-white mb-4">Equipment <span class="text-brand-500">Categories</span></h1>
            <div class="w-16 h-1 bg-brand-500 mx-auto"></div>
            <p class="text-gray-400 mt-6 max-w-2xl mx-auto">Explore our diverse range of fitness categories. From heavy strength machines to agile cardio setups, find exactly what you need.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($categories as $category)
                <a href="{{ route('category.show', $category->id) }}" class="group relative overflow-hidden bg-dark-800" style="height: 400px;">
                    <div class="absolute inset-0 bg-black/60 group-hover:bg-black/30 transition-all z-10 duration-500"></div>
                    @if($category->image_path)
                        <img src="{{ Storage::url($category->image_path) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <!-- Dummy gradient if no image -->
                        <div class="w-full h-full bg-gradient-to-tr from-dark-800 to-dark-600"></div>
                    @endif
                    
                    <div class="absolute inset-0 z-20 flex flex-col items-center justify-center p-6 text-center">
                        <h3 class="font-heading text-3xl font-bold uppercase tracking-wide text-white mb-4 group-hover:text-brand-500 transition-colors drop-shadow-lg">{{ $category->name }}</h3>
                        
                        <div class="w-12 h-0.5 bg-brand-500 mb-4 transition-all group-hover:w-24"></div>
                        
                        <span class="text-sm font-heading text-gray-200 uppercase tracking-widest bg-black/50 px-4 py-2 border border-white/20 group-hover:border-brand-500 group-hover:bg-brand-500 group-hover:text-white transition-all">
                            {{ $category->products_count ?? 0 }} Products
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20">
                    <h3 class="text-xl font-heading text-white uppercase tracking-widest">No categories available at the moment.</h3>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
