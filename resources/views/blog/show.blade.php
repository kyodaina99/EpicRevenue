@extends('shared.layout')

@section('body')
    <section class="bg-white py-9">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="blog-post-single-container">
                        <div class="border-bottom mb-2">
                            <h1 class="text-black fw-700 article-single-title">{{ $post->name }}</h1>
                            <div class="mb-2 opacity-50 article-single-category">
                                <i>
                                    Published in 
                                    @foreach($post->categories as $category_info)
                                     <a href="/blog/category/{{ $category_info->category->slug }}" >{{$category_info->category->category_name}}</a>, 
                                    @endforeach
                            
                                </i>
                            </div>
                        </div>
                        <div class="mb-4 article-single-post overflow-hidden">
                            {!! $post->post !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection