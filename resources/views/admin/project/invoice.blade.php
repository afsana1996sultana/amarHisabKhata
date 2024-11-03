<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>

        * {
            margin: 0;
            padding: 0;
            outline: none;
            box-sizing: border-box;
            font-family: 'Roboto Slab', serif;
        }

        body {
            font-family: 'Roboto Slab', serif;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            margin: auto;
        }

        .theme__heading p {
            font-size: 30px;
            margin-bottom: 0;
            line-height: 1.5;
        }

        .header__section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
        }

        .header__content {
            text-align: center;
            margin-left: -130px;
        }

        .header__content h2 {
            font-weight: 400;
            line-height: 1;
        }

        .header__content p {
            line-height: 1;
            font-size: 14px;
        }

        .header__content span {
            font-size: 12px;
        }

        .main_content h6 {
            text-align: center;
            margin-bottom: 0;
        }

        .person__info {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
        }

        .product__info__table table {
            border: 1px solid #000;
            width: 100%;
            margin-bottom: 0;
        }

        .product__info__table th, .product__info__table td {
            padding: 5px;
            text-align: center;
        }

        .signature {
            display: flex;
            margin-top: 70px;
            justify-content: space-between;
        }

        .signature h6 {
            border-top: 1px solid #000;
            padding-top: 10px;
        }

        section.footer__section {
            border-top: 1px solid #000;
            margin-top: 30px;
            padding-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
<div class="container">
    <header>
        <section class="header__section">
            <div class="header__logo">
                @if ($setting->header_logo != null)
                    <img style="height: 20px; display: block; margin: 0 auto;"
                         src="{{ asset($setting->header_logo) }}" alt="{{ env('APP_NAME') }}">
                @else
                    <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}">
                @endif
            </div>
            <div class="header__content">
                <h2>{{ $setting->site_name ?? 'Company Name' }}</h2>
                <p>{{ $setting->address ?? 'Address not available' }}<br>
                    {{ $setting->contact_number ?? 'Phone not available' }}</p>
            </div>
            <div></div>
        </section>
    </header>

    <div class="main_content">
        <h6>Invoice</h6>
        <div class="person__info">
            <ul>
                <li>Customer Name: {{$project->customer_name ?? 'N/A'}}</li>
                <li>Customer Address: {{$project->address ?? 'N/A'}}</li>
                <li>Customer Phone No: {{$project->customer_phone ?? 'N/A'}}</li>
                <li>Invoice No: {{$invoiceNumber ?? 'N/A'}}</li>
                <li>Date: {{$project->date ?? 'N/A'}}</li>
            </ul>
        </div>

        <div class="product__info__table">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Project Value</th>
                    <th>Project Duration</th>
                    <th>Advance</th>
                    <th>Due</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$project->project_name ?? 'N/A'}}</td>
                    <td>{{$project->project_value ?? 'N/A'}}</td>
                    <td>{{$project->project_duration ?? 'N/A'}}</td>
                    <td>{{$project->advance ?? 'N/A'}}</td>
                    <td>{{($project->project_value ?? 0) - ($project->advance ?? 0) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="signature">
        <h6>Customer Signature</h6>
        <h6>Authorized Signature</h6>
    </div>

    <section class="footer__section">
        <h6>Thank you for your business!</h6>
    </section>
</div>
</body>

</html>
