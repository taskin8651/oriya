@extends('layouts.admin-show', ['resource' => 'post', 'listRoute' => 'admin.posts.index', 'record' => $post, 'recordTitle' => $post->title])

@section('content')
    <x-admin.detail-field :label="trans('cruds.post.fields.id')">
        {{ $post->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.post.fields.title')">
        {{ $post->title }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.post.fields.slug')">
        {{ $post->slug }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.post.fields.short_description')" wide>
        {{ $post->short_description }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.post.fields.content')" wide prose>
        {!! $post->content !!}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.post.fields.image')" wide>
        <x-admin.detail-image :media="$post->image" :label="trans('cruds.post.fields.image')" />
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.post.fields.category')">
        {{ $post->category->name ?? '' }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.post.fields.author')">
        {{ $post->author->name ?? '' }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.post.fields.tag')">
        @foreach($post->tags as $key => $tag)
            <span class="detail-chip">{{ $tag->name }}</span>
        @endforeach
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.post.fields.status')">
        @if(isset(App\Models\Post::STATUS_SELECT[$post->status]))
            <span class="detail-status" data-status="{{ $post->status }}">{{ App\Models\Post::STATUS_SELECT[$post->status] }}</span>
        @endif
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.post.fields.view')">
        {{ $post->view }}
    </x-admin.detail-field>
@endsection
