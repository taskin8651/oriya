@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.seo.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.seos.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="meta_tags">{{ trans('cruds.seo.fields.meta_tags') }}</label>
                <input class="form-control {{ $errors->has('meta_tags') ? 'is-invalid' : '' }}" type="text" name="meta_tags" id="meta_tags" value="{{ old('meta_tags', '') }}">
                @if($errors->has('meta_tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seo.fields.meta_tags_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="keywords">{{ trans('cruds.seo.fields.keywords') }}</label>
                <input class="form-control {{ $errors->has('keywords') ? 'is-invalid' : '' }}" type="text" name="keywords" id="keywords" value="{{ old('keywords', '') }}">
                @if($errors->has('keywords'))
                    <div class="invalid-feedback">
                        {{ $errors->first('keywords') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seo.fields.keywords_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="social_share_image">{{ trans('cruds.seo.fields.social_share_image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('social_share_image') ? 'is-invalid' : '' }}" id="social_share_image-dropzone">
                </div>
                @if($errors->has('social_share_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('social_share_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seo.fields.social_share_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.seo.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}">
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seo.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="seo_title">{{ trans('cruds.seo.fields.seo_title') }}</label>
                <input class="form-control {{ $errors->has('seo_title') ? 'is-invalid' : '' }}" type="text" name="seo_title" id="seo_title" value="{{ old('seo_title', '') }}">
                @if($errors->has('seo_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('seo_title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seo.fields.seo_title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="og_type">{{ trans('cruds.seo.fields.og_type') }}</label>
                <input class="form-control {{ $errors->has('og_type') ? 'is-invalid' : '' }}" type="text" name="og_type" id="og_type" value="{{ old('og_type', '') }}">
                @if($errors->has('og_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('og_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seo.fields.og_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="canonical_url">{{ trans('cruds.seo.fields.canonical_url') }}</label>
                <input class="form-control {{ $errors->has('canonical_url') ? 'is-invalid' : '' }}" type="text" name="canonical_url" id="canonical_url" value="{{ old('canonical_url', '') }}">
                @if($errors->has('canonical_url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('canonical_url') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seo.fields.canonical_url_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    Dropzone.options.socialShareImageDropzone = {
    url: '{{ route('admin.seos.storeMedia') }}',
    maxFilesize: 20, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 20,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="social_share_image"]').remove()
      $('form').append('<input type="hidden" name="social_share_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="social_share_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($seo) && $seo->social_share_image)
      var file = {!! json_encode($seo->social_share_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="social_share_image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection