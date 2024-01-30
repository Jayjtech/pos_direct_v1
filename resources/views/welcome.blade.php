<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ companyInfo()->company_name }}</title>
    <link rel="stylesheet" href="{{ asset('ui/vendors/typicons.font/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/css/vertical-layout-light/style.css') }}">
    <link rel="apple-touch-icon" href="{{ asset('ui/' . companyInfo()->company_logo) }}">
    <link rel="shortcut icon" href="{{ asset('ui/' . companyInfo()->company_logo) }}" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('{{ asset('ui/' . companyInfo()->company_logo) }}');
            /* Replace with your background image path */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: 'Open Sans', sans-serif;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            /* Transparent black background */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1,
        p {
            color: #fff;
            font-family:
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            text-decoration: none;
            color: #fff;
            background-color: #4CAF50;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #45a049;
        }

        .logo {
            max-width: 100px;
            /* Adjust the size of your logo */
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="overlay">
        <div class="container">
            <img src="{{ asset('ui/' . companyInfo()->company_logo) }}" alt="Company Logo" class="logo">
            <h1>{{ companyInfo()->company_name }}</h1>
            <p>Transform your business with our user-friendly POS app. Streamline transactions and enhance efficiency.
            </p>
            <a href="{{ route('login') }}" class="btn btn-sm btn-primary">LOGIN</a>
        </div>
    </div>
</body>

</html>
