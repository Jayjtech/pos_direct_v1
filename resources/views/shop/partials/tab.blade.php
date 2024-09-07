<div class="row">
    <div class="col-lg-8">
        <p class="font-weight-bold">{{ __('Tabs:') }} ({{ $tabs->count() + 1 }})</p>
        <div class="d-flex">
            @php
                $n = 1;
            @endphp
            @foreach ($tabs as $tab)
                <div class="mb-3 mb-xl-0 pr-1">
                    <div class="dropdown">
                        <button class="btn bg-white btn-sm dropdown-toggle btn-icon-text border mr-2" type="button"
                            id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="typcn typcn-calendar-outline"></i>
                            {{ $tab->buyer ? $tab->buyer . ' | ' . ' I-ID: ' . strtoupper($tab->invoice_code) : 'I-ID: ' . strtoupper($tab->invoice_code) }}
                        </button>
                        <div class="dropdown-menu tab-nav" aria-labelledby="dropdownMenuSizeButton3"
                            data-x-placement="top-start">
                            <a class="dropdown-item" href="#view_{{ $tab->id }}">{{ __('View') }}</a>
                            <a class="dropdown-item" href="#delete_{{ $tab->id }}">{{ __('Delete') }}</a>
                        </div>
                    </div>
                </div>
                @php
                    $n++;
                @endphp
            @endforeach
        </div>
    </div>
    @if ($active_cart_id != 0)
        <div class="col-lg-4">
            <div class="d-flex">
                <div class="mb-3 mb-xl-0 pr-1">
                    <div class="dropdown buyer-details">
                        <a href="#{{ $active_cart_id }}" data-bs-toggle="modal" data-bs-target="#addBuyerInfo"
                            class="btn btn-light btn-sm btn-icon-text border mr-2">
                            <i class="typcn typcn-clipboard"></i> Buyer's Info
                        </a>
                    </div>
                </div>

                @can('generate-receipt')
                    <div class="mb-3 mb-xl-0 pr-1">
                        <div class="dropdown">
                            <a href="#{{ $active_cart_id }}"
                                class="print-receipt btn btn-danger btn-sm btn-icon-text border mr-2">
                                <i class="mdi mdi-printer"></i>
                            </a>
                        </div>
                    </div>
                @endcan

                {{-- <div class="mb-3 mb-xl-0 pr-1">
                    <div class="dropdown">
                        <a href="#{{ $active_cart_id }}"
                            class="save-invoice btn btn-success btn-sm btn-icon-text border mr-2">
                            <i class="mdi mdi-content-save"></i>
                        </a>
                    </div>
                </div> --}}

                <script>
                    var generateReceiptRoute = "{{ route('generate.receipt', ['id' => ':id']) }}";
                </script>

            </div>
        </div>
    @endif
</div>
