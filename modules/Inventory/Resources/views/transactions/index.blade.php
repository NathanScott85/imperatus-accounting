@extends('layouts.admin')
@section('title', trans_choice('inventory::general.transactions', 2))
@section('content')
    <!-- Default box -->
    <div class="card">
        <div class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
            {!! Form::open([
                'method' => 'GET',
                'route' => 'histories.index',
                'role' => 'form',
                'class' => 'mb-0'
            ]) !!}
            <div class="align-items-center" v-if="!bulk_action.show">
                <akaunting-search
                        :placeholder="'{{ trans('general.search_placeholder') }}'"
                        :options="{{ json_encode([]) }}"
                ></akaunting-search>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box-header -->
        <div class="table-responsive">
            <table class="table table-flush table-hover" >
                <thead class="thead-light">
                <tr class="row table-head-line">
                    <th class="col-sm-2 col-md-1 col-lg-1 col-xl-1 hidden-sm">{{ Form::bulkActionAllGroup() }}</th>
                    <th class="col-md-1 border-0">Doc#</th>
                    <th class="col-md-2 border-0">{{ trans_choice('general.items', 1) }} </th>
                    <th class="col-md-2 border-0">{{ trans_choice('general.vendors', 1) }}</th>
                    <th class="col-md-2 border-0">{{ trans('invoices.quantity') }}</th>
                    <th class="col-md-1 border-0">Cost</th>
                    <th class="col-md-3 border-0">Stock Movement</th>
                </tr>
                </thead>

                <tbody>
                @foreach($histories as $item)
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 hidden-sm border-0">{{ Form::bulkActionGroup($item->stock_link, $item->name) }}</td>
                        <td class="col-md-1 border-0">
                          <a href="{{ url('purchases/bills/' . $item->tx_id) }}">{{ $item->doc_no }}</a>
                        </td>
                        <td class="col-md-2 border-0">
                            <a href="{{ url('common/items/' . $item->stock_link) }}">{{ $item->item->name }}</a>
                        </td>
                        <td class="col-md-2 border-0">
                            <a href="{{ route('warehouses.show', [$item->warehouse_id]) }}">{{ $item->warehouse->name }}</a>
                        </td>
                        <td class="col-md-2 border-0">
                            {{ $item->stk_qty }}
                        </td>
                        <td class="col-md-1 border-0">
                            {{ $item->stock_cost }}
                        </td>
                        <td class="col-md-3 border-0">
                            {{ $item->stk_movement }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- /.box-body -->
        <div class="card-footer table-action">
            <div class="row align-items-center">
                @include('partials.admin.pagination', ['items' => $histories, 'type' => 'histories'])
            </div>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
@endsection

@push('scripts_start')
    <script src="{{ asset('modules/Inventory/Resources/assets/js/histories.min.js?v=' . version('short')) }}"></script>
@endpush
