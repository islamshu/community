<!DOCTYPE html>
<html lang="en">

<head>

</head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Document</title>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Tajawal:wght@300;500;700;800;900&display=swap");
</style>
<style>
    .logo {
        display: flex;
        margin: 30px auto 0;
        align-items: center;
        justify-content: center;

        a {
            display: block;
            width: 30px;
            height: 30px;
            // overflow: hidden;
        }

        img {
            width: 180px;
        }

        .c-name {
            display: inline-block;
            font-weight: 600;
        }
    }

    section {
        width: auto;
        margin: auto;
        border: 1px solid black;
        padding-block: 18px;
        padding-inline: 40px;
        font-family: "Tajawal", sans-serif;
        text-align: right;
        direction: rtl !important
    }

    table {
        width: 100%;
        text-align: left;
        border-collapse: collapse;
    }

    .flex {
        display: flex;
        justify-content: space-between;
    }

    .col {
        width: 50%;
    }
</style>
</head>

<body>
    <div class="logo" style="text-align: center">
        <img src="https://communitydash.arabicreators.com/community2.png" width="250" height="200" alt="cc-logo">
    </div>
    <section id="printd">
        <div style="margin-bottom: 18px">
            <table>
                <thead>
                    <tr>
                        @php
                            $sub = App\Models\Subscription::find($claim_id);
                        @endphp
                        {{-- {{ dd($sub) }} --}}

                    </tr>
                </thead>
                <tbody style="direction: rtl">
                    <tr>
                        <td>   
                             تاريخ المطالبة  {{ $sub->created_at }}</td>
                            <td style="width: 50%"></td>


                        <td> </td>
                        {{-- <td>Row 1, Cell 3</td> --}}
                    </tr>
                    <tr>

                    </tr>


                </tbody>
            </table>
        </div>
        <div style="margin-bottom: 18px">
            <div class="flex">
                <div class="col">
                    <p style="margin: 0; color: gray">المطالبة من </p>
                    <h2 style="font-size: 26px; margin: 0; font-weight: 600">
                        {{ $sub->user->name }}
                    </h2>
                    <h4 style="margin: 0; font-weight: normal"> {{ $sub->user->email }}</h4>
                </div>
                <div class="col">
                    <div style="width: 100%; border: 1px solid black">
                        <div class="flex" style="border-bottom: 1px solid black">
                            <div
                                style="
                    background-color: red;
                    padding: 15px 60px;
                    color: #fff;
                    font-size: 24px;
                    font-weight: 700;
                    text-align: center;
                  ">
                                غير مدفوع
                            </div>
                            <div class="flex"
                                style="
                    text-align: center;
                    width: 100%;
                    align-items: center;
                    background-color: gray;
                  ">
                                <p style="padding-inline-start: 18px; font-size: 18px">
                                    {{ $sub->start_at }}
                                </p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-bottom: 18px">
            <table style="border: 1px solid black; border-collapse: collapse">
                <tr style="background-color: gray">
                    
                   
                 
                    <th style="padding: 8px; font-size: 16px"> اسم الباقة
                    </th>
                    <th style="padding: 8px; font-size: 16px"> سعر الباقة
                    </th>
                    <th style="padding: 8px; font-size: 16px">تبدأ من </th>
                    <th style="padding: 8px; font-size: 16px">تنتهي في </th>

                </tr>
                <tr>
                    
                    <td style="padding: 15px 8px; font-size: 16px">
                        @if ($sub->peroud == 1)
                            اشتراك شهري
                        @else
                            اشتراك سنوي
                        @endif
                    </td>
                    <td style="padding: 15px 8px; font-size: 16px">{{ $sub->amount }}$</td>
                    <td style="padding: 15px 8px; font-size: 16px">{{ $sub->start_at }}</td>
                    <td style="padding: 15px 8px; font-size: 16px">{{ $sub->end_at }}</td>


                </tr>
            </table>
        </div>
        <div style="width: 25%; margin-left: auto">
            <table style="border-collapse: collapse">
                <tr style="border-top: 2px solid gray">
                    <th style="padding: 8px; font-size: 24px; font-weight: 800">
                        السعر الكلي
                    </th>
                    <td
                        style="
                padding: 8px;
                text-align: right;
                font-size: 16px;
                font-weight: 800;
              ">
                        {{ $sub->amount }}$
                    </td>
                    
                    
                </tr>
            </table>
        </div>
        <div style="text-align: center">
            <a href="{{ $link }}" style="background: #82d97a;padding: 0.9rem 2rem;font-size: 0.875rem;color:#000000;border-radius: .2rem;" target="_blank">ادفع الان</a>

        </div>
    </section>
    <style>
        @media print {
            @page {
                size: A4;
            }
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="{{ asset('front/js/bootstrap.min.js?version=' . config('app.app_version')) }})}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>


    <script src="{{ asset('front/js/html2pdf.bundle.min.js?version=' . config('app.app_version')) }})}}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            generatePDF();
            // window.print()
        });

        function generatePDF() {
            // Choose the element that our invoice is rendered in.
            const element = document.getElementById('printd');

            // Define the PDF options, including the page size.
            const options = {
                filename: 'invoice.pdf', // Specify the desired filename.
                jsPDF: {
                    format: 'a4'
                }, // Set the page size to A2.
            };

            // Generate the PDF with the specified options and save it for the user.
            html2pdf().set(options).from(element).save();
        }
    </script>
</body>

</html>
