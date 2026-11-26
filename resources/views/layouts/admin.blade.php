@php
    $adminRecord = $adminDetail ?? $adminForm ?? null;
    $adminPageTitle = $adminRecord['title'] ?? $adminIndexTitle ?? $adminUtilityTitle ?? trans('panel.site_title');
    $adminPageStyle = match (true) {
        isset($adminDetail) => 'admin-detail',
        isset($adminForm) => 'admin-form',
        isset($adminIndexTitle) => 'admin-index',
        default => 'admin-utility',
    };
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $adminPageTitle }} · NewsPortal</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@3.2/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/admin-dashboard.css') }}" rel="stylesheet" />
    @if($adminPageStyle !== 'admin-utility')
        <link href="{{ asset('css/' . $adminPageStyle . '.css') }}" rel="stylesheet" />
    @endif
    <script src="{{ asset('js/dashboard-navigation.js') }}" defer></script>
    @yield('styles')
</head>

<body class="news-admin {{ $adminPageStyle }}">
    @include('partials.menu')
    <button type="button" class="dashboard-backdrop" data-sidebar-close aria-label="Close navigation" hidden></button>
    <div class="dashboard-shell">
        @include('partials.dashboard-header')
        <main class="dashboard-main">
            @include('partials.admin-alerts')
            @if(isset($adminDetail))
                <div class="admin-page-heading detail-heading">
                    <h1 id="admin-detail-title">{{ $adminDetail['title'] }}</h1>
                    @if($adminDetail['listUrl'] || $adminDetail['editUrl'])
                        <div class="detail-actions">
                            @if($adminDetail['listUrl'])
                                <a class="btn detail-back" href="{{ $adminDetail['listUrl'] }}">
                                    <i class="fas fa-chevron-left" aria-hidden="true"></i> {{ trans('global.back_to_list') }}
                                </a>
                            @endif
                            @if($adminDetail['editUrl'])
                                <a class="btn detail-edit" href="{{ $adminDetail['editUrl'] }}">
                                    <i class="fas fa-pen" aria-hidden="true"></i> {{ trans('global.edit') }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
                <section class="dashboard-card detail-card" aria-labelledby="admin-detail-title">
                    <dl class="detail-grid">
                        @yield('content')
                    </dl>
                </section>
            @elseif(isset($adminForm))
                <div class="admin-page-heading form-heading">
                    <span class="form-heading-icon" aria-hidden="true"><i class="fas {{ request()->routeIs('admin.*.edit') ? 'fa-pen' : 'fa-plus' }}"></i></span>
                    <h1 id="admin-form-title">{{ $adminForm['title'] }}</h1>
                </div>
                <section class="dashboard-card form-card" aria-labelledby="admin-form-title">
                    @yield('content')
                </section>
            @elseif(isset($adminIndexTitle))
                <div class="admin-page-heading">
                    <div class="admin-page-heading-copy">
                        <h1>{{ $adminIndexTitle }}</h1>
                        <p>{{ number_format($adminIndexCount) }} {{ Str::plural('record', $adminIndexCount) }}</p>
                    </div>
                    <div class="index-actions">@yield('indexActions')</div>
                </div>
                <section class="dashboard-card index-card" aria-label="{{ $adminIndexTitle }}">
                    <div class="index-table-wrap">
                        @yield('content')
                    </div>
                </section>
            @else
                @yield('content')
            @endif
        </main>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
    <script src="https://unpkg.com/@coreui/coreui@3.2/dist/js/coreui.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(function() {
  let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
  let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
  let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
  let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
  let printButtonTrans = '{{ trans('global.datatables.print') }}'
  let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
  let selectAllButtonTrans = '{{ trans('global.select_all') }}'
  let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

  let languages = {
    'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
  };

  $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
  $.extend(true, $.fn.dataTable.defaults, {
    language: {
      url: languages['{{ app()->getLocale() }}']
    },
    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets: 0
    }, {
        orderable: false,
        searchable: false,
        targets: -1
    }],
    select: {
      style:    'multi+shift',
      selector: 'td:first-child'
    },
    order: [],
    scrollX: true,
    pageLength: 100,
    @isset($adminIndexTitle)
    dom: '<"index-table-toolbar"fl><"index-table-buttons"B>rt<"index-table-footer"ip><"actions">',
    @else
    dom: 'lBfrtip<"actions">',
    @endisset
    buttons: [
      {
        extend: 'selectAll',
        className: 'btn-primary',
        text: selectAllButtonTrans,
        exportOptions: {
          columns: ':visible'
        },
        action: function(e, dt) {
          e.preventDefault()
          dt.rows().deselect();
          dt.rows({ search: 'applied' }).select();
        }
      },
      {
        extend: 'selectNone',
        className: 'btn-primary',
        text: selectNoneButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'copy',
        className: 'btn-default',
        text: copyButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'csv',
        className: 'btn-default',
        text: csvButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excel',
        className: 'btn-default',
        text: excelButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'pdf',
        className: 'btn-default',
        text: pdfButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'print',
        className: 'btn-default',
        text: printButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'colvis',
        className: 'btn-default',
        text: colvisButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      }
    ]
  });

  $.fn.dataTable.ext.classes.sPageButton = '';

  @isset($adminIndexTitle)
    const shell = document.querySelector('.dashboard-shell');
    shell.addEventListener('transitionend', function (event) {
      if (event.target === shell && event.propertyName === 'margin-left') {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
      }
    });
    document.querySelector('[data-sidebar-toggle]').addEventListener('click', function () {
      requestAnimationFrame(() => $($.fn.dataTable.tables(true)).DataTable().columns.adjust());
    });
  @endisset
});

    </script>
    @yield('scripts')
</body>

</html>
