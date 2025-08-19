@extends('layouts.admin')
@section('content')
@can('email_setup_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.email-setups.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.emailSetup.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'EmailSetup', 'route' => 'admin.email-setups.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.emailSetup.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-EmailSetup">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.emailSetup.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.emailSetup.fields.provider_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.emailSetup.fields.from_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.emailSetup.fields.from_email') }}
                    </th>
                    <th>
                        {{ trans('cruds.emailSetup.fields.host') }}
                    </th>
                    <th>
                        {{ trans('cruds.emailSetup.fields.port') }}
                    </th>
                    <th>
                        {{ trans('cruds.emailSetup.fields.username') }}
                    </th>
                    <th>
                        {{ trans('cruds.emailSetup.fields.password') }}
                    </th>
                    <th>
                        {{ trans('cruds.emailSetup.fields.encryption') }}
                    </th>
                    <th>
                        {{ trans('cruds.emailSetup.fields.ip_address') }}
                    </th>
                    <th>
                        {{ trans('cruds.emailSetup.fields.status') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('email_setup_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.email-setups.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.email-setups.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'provider_name', name: 'provider_name' },
{ data: 'from_name', name: 'from_name' },
{ data: 'from_email', name: 'from_email' },
{ data: 'host', name: 'host' },
{ data: 'port', name: 'port' },
{ data: 'username', name: 'username' },
{ data: 'password', name: 'password' },
{ data: 'encryption', name: 'encryption' },
{ data: 'ip_address', name: 'ip_address' },
{ data: 'status', name: 'status' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-EmailSetup').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection