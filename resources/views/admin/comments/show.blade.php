@extends('layouts.admin-show', ['resource' => 'comment', 'listRoute' => 'admin.comments.index', 'record' => $comment])

@section('content')
    <x-admin.detail-field :label="trans('cruds.comment.fields.id')">
        {{ $comment->id }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.comment.fields.post')">
        {{ $comment->post->title ?? '' }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.comment.fields.user')">
        {{ $comment->user->name ?? '' }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.comment.fields.comment_text')" wide>
        {{ $comment->comment_text }}
    </x-admin.detail-field>
    <x-admin.detail-field :label="trans('cruds.comment.fields.status')">
        @if(isset(App\Models\Comment::STATUS_SELECT[$comment->status]))
            <span class="detail-status" data-status="{{ $comment->status }}">{{ App\Models\Comment::STATUS_SELECT[$comment->status] }}</span>
        @endif
    </x-admin.detail-field>
@endsection
