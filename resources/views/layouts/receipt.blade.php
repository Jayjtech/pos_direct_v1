<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ companyInfo()->company_name }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('ui/css/bootstrap.css') }}">
    <style>
        body {
            margin: 5px;
            text-align: center;
            font-weight: bold;
        }

        #logo {
            max-width: 200px;
            max-height: 200px;
            margin: 5px auto;
            /* Center-align the logo */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            font-size: 9px;
        }

        th {
            background-color: #f2f2f2;
        }

        .table th {
            font-weight: bold;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
            /* Add subtle striping */
        }

        .table tbody tr {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>

    {{-- @if (companyInfo()->company_logo)
        @if (companyInfo()->logo_status == 1)
            <img src="{{ asset('ui/' . companyInfo()->company_logo) }}" alt="Company Logo" id="logo" width="200"
                height="100">
        @endif
    @endif --}}
    <h4 style="font-weight:bold;">{{ companyInfo()->company_name }}</h4>
    @php
        $phones = json_decode(companyInfo()->company_phones);
    @endphp
    <div class="row" style="margin-top:-10px">
        <div class="col-12" style="text-align: center; font-weight:bold;">
            <h6 style="font-size:12px;font-weight:bold;">
                @if (companyInfo()->company_email)
                    {{-- <span>{{ companyInfo()->company_name }}</span><br> --}}
                    <span>{{ companyInfo()->company_email }}</span><br>
                @endif
                @if (companyInfo()->company_address)
                    <span>{{ companyInfo()->company_address }}</span><br>
                @endif

                @if (companyInfo()->company_phones)
                    @foreach ($phones as $phone)
                        <span>{{ $phone }}</span><br>
                    @endforeach
                @endif
            </h6>
        </div>

        <div class="col-12 d-flex justify-content-md-end"
            style="text-align: left;font-size:12px;margin-top:-10px;font-weight:bold;">
            <p>
                @if ($combined_order->user)
                    <span>Seller: {{ $combined_order->user->name }}</span><br>
                    <span>Date: {{ $combined_order->created_at }}</span><br>
                    <span>Trx-ID: {{ strtoupper($combined_order->trx_id) }}</span><br>
                @endif

                @if ($buyer_details->buyer)
                    <span>Buyer: {{ $buyer_details->buyer }}</span><br>
                @endif
                @if ($buyer_details->phone)
                    <span>Phone: {{ $buyer_details->phone }}</span><br>
                @endif
                @if ($buyer_details->address)
                    <span>Address: {{ $buyer_details->address }}</span><br>
                @endif
            </p>
        </div>
    </div>
    @yield('content')
    @if (companyInfo()->company_signature)
        @if (companyInfo()->signature_status == 1)
            <div class="row" style="margin-top:-20px;">
                <div class="col-6" align="left">
                    {{-- Active --}}
                    <img src="{{ asset('ui/' . companyInfo()->company_signature) }}" alt="Company signature"
                        id="signature" width="150" height="50"><br>
                    <span style="font-size:12px; margin-top:-50px;">{{ __("Seller's Signature") }}</span>
                </div>
                <div class="col-6" align="right">
                    {{-- Active --}}
                    <br>
                    {{ __('___________________________') }}<br>
                    <span style="font-size:12px; margin-top:-50px;">{{ __("Customer's Signature") }}</span>
                </div>
            </div>
        @endif
    @endif
    <em style="font-size:10px; margin-top:-50px;">Thanks for your patronage!</em>

    <script src="{{ asset('ui/vendors/js/vendor.bundle.base.js') }}"></script>

    @stack('script')
</body>

</html>
