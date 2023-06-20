<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>            مجتمع صناع المحتوى #{{ $code }}
    </title>
   
    <!-- Favicon -->
    <link rel="icon" href="./images/favicon.png" type="image/x-icon" />

    <!-- Invoice styling -->
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body id="printd" style="text-align: center">
  <h1> نشكر لك انضمامك الى مجتمع صناعة المحتوى</h1>
    <div class="invoice-box">
        <table>
            

            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                # {{ $code }}<br />
                               التاريخ: {{ $start_at }}<br />
                           </td>
                            <td class="title">
                                <img src="{{ asset('community.png') }}" alt="Company logo" style="width: 100%; max-width: 300px" />
                            </td>

                            
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                               

                            </td>
                            <td>
                                {{ $name }}<br />
                                {{ $email}}<br />
                            </td>
                            <td>
                              
                            </td>


                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="item">
                <td>نوع الباقة</td>

                <td>@if($peroid == 1) شهرية @else سنوية @endif</td>

  
            </tr>
            
            
            <tr class="item">
                <td>يبدأ الاشتراك في </td>

              <td>{{ $start_at }}</td>

          </tr>
          <tr class="item">
            <td>ينتهي الاشتراك في </td>

            <td> {{ $end_at }}</td>

        </tr>

            
        </table>
        <a target="_blank" href="{{ route('viewPdf',$code) }}" class="btn btn-info">انقر لتحميل الفاتورة</a>

        
    </div>
    <style>
        @media print {
            @page {
                size: A2;
            }
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="{{ asset('front/js/bootstrap.min.js?version=' . config('app.app_version')) }})}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>


    <script src="{{ asset('front/js/html2pdf.bundle.min.js?version=' . config('app.app_version')) }})}}"></script>

   
</body>
</div>

</html>
