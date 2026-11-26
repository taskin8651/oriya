<footer class="form-actions">
    <a class="btn form-cancel" href="{{ $adminForm['listUrl'] ?? route('admin.home') }}">{{ trans('global.cancel') }}</a>
    <button class="btn form-save" type="submit">
        <i class="fas fa-check" aria-hidden="true"></i>
        {{ trans('global.save') }}
    </button>
</footer>
