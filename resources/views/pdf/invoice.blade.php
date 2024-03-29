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
      section {
        width: auto;
        margin: auto;
        border: 1px solid black;
        padding-block: 20px;
        padding-inline: 40px;
        font-family: "Tajawal", sans-serif;
        direction: rtl
        /* text-align: right; */
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
  <body  >
    <section id="printd">
      <div style="margin-bottom: 20px">
        <table>
          <thead>
            <tr>
              <th style="width: 55%; font-size: 24px">
                <img src="{{ asset('community2.png') }}" width="220" height="180" alt="">
              </th>
            </tr>
          </thead>
          <tbody style="direction: rtl" >
            <tr>
              <td style="text-align: right">   فاتورة #{{ $sub->code }}     <br>
                ارسلت في  {{ $sub->created_at->format('Y-m-d') }}   </td>

              <td style="width: 50%"></td>

              <td> </td>
              {{-- <td>Row 1, Cell 3</td> --}}
            </tr>
            <tr>
             
            </tr>
          
         
          </tbody>
        </table>
      </div>
      <div style="margin-bottom: 20px">
        <div class="flex">
          <div class="col">
            <p style="margin: 0; color: gray">فاتورة الى</p>
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
                    background-color: green;
                    padding: 15px 60px;
                    color: #fff;
                    font-size: 24px;
                    font-weight: 700;
                  "
                >
                  مدفوع
                </div>
                <div
                  class="flex"
                  style="
                    text-align: center;
                    width: 100%;
                    align-items: center;
                    background-color: gray;
                  "
                >
                  <p style="padding-inline-start: 20px; font-size: 20px">
                    {{ $sub->start_at }}
                  </p>
                </div>
              </div>
              <div>
                <p
                  style="
                    font-size: 50px;
                    text-align: center;
                    padding-block: 30px;
                    margin: 0;
                  "
                >
                {{ $sub->price_with_currency }} <span style="font-size: 18px; color: gray">{{ $sub->currency_symble }}</span>
              </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div style="margin-bottom: 20px">
        <table style="border: 1px solid black; border-collapse: collapse">
          <tr style="background-color: gray">
            <th style="padding: 8px; font-size: 20px"> اسم الباقة
            </th>
            <th style="padding: 8px; font-size: 20px"> سعر الباقة
            </th>
            <th style="padding: 8px; font-size: 20px">يبدأ من </th>
            <th style="padding: 8px; font-size: 20px">ينتهي في</th>
          </tr>
          <tr>
            <td style="padding: 15px 8px; font-size: 20px">                     {{ $sub->package->title }}
            </td>
            <td style="padding: 15px 8px; font-size: 20px">{{ $sub->main_price  * $sub->currency_amount}} {{ $sub->currency_symble }}</td>
            <td style="padding: 15px 8px; font-size: 20px">{{ $sub->start_at }}</td>
            <td style="padding: 15px 8px; font-size: 20px">{{ $sub->end_at }}</td>
          </tr>
        </table>
      </div>
      <div style="width: 25%; margin-left: auto">
        <table style="border-collapse: collapse">
          <tr>
            <th style="padding: 8px">السعر</th>
            <td style="padding: 8px; text-align: right">{{ $sub->main_price  * $sub->currency_amount}} {{ $sub->currency_symble }}</td>
          </tr>
          <tr>
            <th style="padding: 8px">الخصم</th>
            
            <td style="padding: 8px; text-align: right">
              {{ ($sub->main_price - $sub->price_after_all_discount) * $sub->currency_amount }}{{ $sub->currency_symble }}</td>
            </tr>
          
          </tr>
          <tr style="border-top: 2px solid gray">
            <th style="padding: 8px; font-size: 24px; font-weight: 800">
             السعر النهائي
            </th>
            <td
              style="
                padding: 8px;
                text-align: right;
                font-size: 20px;
                font-weight: 800;
              "
            >
            {{ $sub->price_with_currency }}{{ $sub->currency_symble }}
          </td>
          </tr>
        </table>
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
