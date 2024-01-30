<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
    @page {
        size: landscape;
    }

    /* Add this styling to your existing CSS file or style tag in the head of your HTML document */

    body {
        font-family: 'Arial', sans-serif;
        margin: none;
    }

    .table-responsive {
        margin-top: 5px;
    }

    .table-bordered {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table th,
    .table td {
        font-size: 9px;
    }

    .table th {
        background-color: #f5f5f5;
    }

    .alert-danger {
        margin-top: 10px;
    }

    .btn-pdf {
        background-color: #d9534f;
        color: #fff;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
    }

    .btn-pdf:hover {
        background-color: #c9302c;
    }
</style>

<body>
    @php
        $phones = json_decode(companyInfo()->company_phones);
    @endphp

    <div style="text-align: center;">
        <h5>
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
        </h5>
    </div>
    @yield('content')
</body>

</html>
