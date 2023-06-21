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
              <th style="width: 50%; font-size: 24px">
                SoundCloud Global Limited & Co. KG
              </th>
              <th style="font-size: 24px">Invoice</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="width: 50%">Row 1, Cell 1</td>
              <td>Row 1, Cell 2</td>
              <td>Row 1, Cell 3</td>
            </tr>
            <tr>
              <td style="width: 50%">Row 2, Cell 1</td>
              <td>Row 2, Cell 2</td>
              <td>Row 2, Cell 3</td>
            </tr>
            <tr>
              <td style="width: 50%">Row 3, Cell 1</td>
              <td>Row 3, Cell 2</td>
              <td>Row 3, Cell 3</td>
            </tr>
            <tr>
              <td style="width: 50%">Row 4, Cell 1</td>
              <td>Row 4, Cell 2</td>
              <td>Row 4, Cell 3</td>
            </tr>
            <tr>
              <td style="width: 50%">Row 5, Cell 1</td>
              <td>Row 5, Cell 2</td>
              <td>Row 5, Cell 3</td>
            </tr>
            <tr>
              <td style="width: 50%">Row 6, Cell 1</td>
              <td>Row 6, Cell 2</td>
              <td>Row 6, Cell 3</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div style="margin-bottom: 20px">
        <div class="flex">
          <div class="col">
            <p style="margin: 0; color: gray">Bill To</p>
            <h2 style="font-size: 26px; margin: 0; font-weight: 600">
              mohammed ghandour
            </h2>
            <h4 style="margin: 0; font-weight: normal">Saudi Arabia</h4>
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
                  PAID
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
                    on Jun 11, 2023
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
                  $99.00 <span style="font-size: 20px; color: gray">USD</span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div style="margin-bottom: 20px">
        <table style="border: 1px solid black; border-collapse: collapse">
          <tr style="background-color: gray">
            <th style="padding: 8px; font-size: 20px">Header 1</th>
            <th style="padding: 8px; font-size: 20px">Header 2</th>
            <th style="padding: 8px; font-size: 20px">Header 3</th>
            <th style="padding: 8px; font-size: 20px">Header 4</th>
            <th style="padding: 8px; font-size: 20px">Header 5</th>
            <th style="padding: 8px; font-size: 20px">Header 6</th>
          </tr>
          <tr>
            <td style="padding: 15px 8px; font-size: 20px">Data 1</td>
            <td style="padding: 15px 8px; font-size: 20px">Data 2</td>
            <td style="padding: 15px 8px; font-size: 20px">Data 3</td>
            <td style="padding: 15px 8px; font-size: 20px">Data 4</td>
            <td style="padding: 15px 8px; font-size: 20px">Data 5</td>
            <td style="padding: 15px 8px; font-size: 20px">Data 6</td>
          </tr>
        </table>
      </div>
      <div style="width: 25%; margin-left: auto">
        <table style="border-collapse: collapse">
          <tr>
            <th style="padding: 8px">Column 1</th>
            <td style="padding: 8px; text-align: right">0.00$</td>
          </tr>
          <tr>
            <th style="padding: 8px">Column 2</th>
            <td style="padding: 8px; text-align: right">0.00$</td>
          </tr>
          <tr>
            <th style="padding: 8px; padding-bottom: 20px">Column 3</th>
            <td style="padding: 8px; text-align: right; padding-bottom: 20px">
              (0.00$)
            </td>
          </tr>
          <tr style="border-top: 2px solid gray">
            <th style="padding: 8px; font-size: 24px; font-weight: 800">
              Amount Due
            </th>
            <td
              style="
                padding: 8px;
                text-align: right;
                font-size: 20px;
                font-weight: 800;
              "
            >
              0.00$
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
