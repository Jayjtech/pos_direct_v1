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
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    @if (companyInfo()->company_logo)
        @if (companyInfo()->logo_status == 1)
            {{-- Active --}}
            <img src="{{ asset('ui/' . companyInfo()->company_logo) }}" alt="Company Logo" id="logo" width="200"
                height="100">
        @endif
    @endif

    @php
        $phones = json_decode(companyInfo()->company_phones);
    @endphp
    <div class="row">
        <div class="col-6" style="text-align: left;">
            <h6>
                @if (companyInfo()->company_name)
                    <span>{{ companyInfo()->company_name }}</span><br>
                    <span>Email: {{ companyInfo()->company_email }}</span><br>
                @endif
                @if (companyInfo()->company_address)
                    <span>Address: {{ companyInfo()->company_address }}</span><br>
                @endif

                @if (companyInfo()->company_phones)
                    @foreach ($phones as $phone)
                        <span>Telephone: {{ $phone }}</span><br>
                    @endforeach
                @endif
            </h6>
        </div>

        <div class="col-6 d-flex justify-content-md-end" style="text-align: left;">
            <h6>
                @if ($buyer_details->buyer)
                    <span>Buyer: {{ $buyer_details->buyer }}</span><br>
                @endif
                @if ($buyer_details->phone)
                    <span>Phone: {{ $buyer_details->phone }}</span><br>
                @endif
                @if ($buyer_details->address)
                    <span>Address: {{ $buyer_details->address }}</span><br>
                @endif
            </h6>
        </div>
    </div>
    @yield('content')
    @if (companyInfo()->company_signature)
        @if (companyInfo()->signature_status == 1)
            <div class="row">
                <div class="col-6" align="left">
                    {{-- Active --}}
                    <img src="{{ asset('ui/' . companyInfo()->company_signature) }}" alt="Company signature"
                        id="signature" width="150" height="50"><br>
                    <span>{{ __("Seller's Signature") }}</span>
                </div>
                <div class="col-6" align="right">
                    {{-- Active --}}
                    <br>
                    {{ __('___________________________') }}<br>
                    <span>{{ __("Customer's Signature") }}</span>
                </div>
            </div>
        @endif
    @endif
    <em>Thanks for your patronage! We look forward to seeing you again.</em>

    <script src="{{ asset('ui/vendors/js/vendor.bundle.base.js') }}"></script>

    @stack('script')
</body>

</html>
