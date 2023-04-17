<head>
    <style type="text/css">
      @import url(https://fonts.googleapis.com/css?family=Roboto:400,300,500,700,700italic,900);
      body { font-family: 'Roboto', Arial, sans-serif !important; }
      a[href^="tel"]{
          color:inherit;
          text-decoration:none;
          outline:0;
      }
      a:hover, a:active, a:focus{
          outline:0;
      }
      a:visited{
          color:#FFF;
      }
      span.MsoHyperlink {
          mso-style-priority:99;
          color:inherit;
      }
      span.MsoHyperlinkFollowed {
          mso-style-priority:99;
          color:inherit;
      }
    </style>
  </head>
  
  
  <body style="margin: 0; padding: 0;background-color:#EEEEEE;">
    <div style="display:none;font-size:1px;color:#333333;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">
      {{-- Habt Ihr Fragen? Ruft uns unter 04221 97 44 77 an oder antwortet einfach auf diese Email | supplify.de --}}
    </div>
    <table cellspacing="0" style="margin:0 auto; width:100%; border-collapse:collapse; background-color:#EEEEEE; font-family:'Roboto', Arial !important">
      <tbody>
        <tr>
          <td align="center" style="padding:20px 23px 0 23px">
            <table width="600" style="background-color:#FFF; margin:0 auto; border-radius:5px; border-collapse:collapse">
              <tbody>
                <tr>
                  <td align="center">
                    <table width="500" style="margin:0 auto">
                      <tbody>
  
                        <tr>
                          <td align="center" style="padding:40px 0 35px 0">
                            <a href="https://supplify.de/" target="_blank" style="color:#128ced; text-decoration:none;outline:0;"><img alt="" src="https://www.supplify.de/images/supplify_klein.jpg" border="0"></a>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" style="font-family:'Roboto', Arial !important">
                            <h2 style="margin:0; font-weight:bold; font-size:40px; color:#444; text-align:center; font-family:'Roboto', Arial !important">
                                شكرا لاشتراكك في مجتمعنا!
                                                                  </h2>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" style="padding:15px 0 20px 0; font-family:'Roboto', Arial !important">
                            <p style="margin:0; font-size:18px; color:#000; line-height:24px; font-family:'Roboto', Arial !important">
                                هذا بريد الكتروني يحتوي على طلبك
                            </p>
                          </td>
                        </tr>
                     
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="center" cellspacing="0" style="padding:0 0 30px 0; vertical-align:middle">
                    <table width="550" style="border-collapse:collapse; background-color:#FaFaFa; margin:0 auto; border:1px solid #E5E5E5">
                      <tbody>
                        <tr>
                          <td width="276" style="vertical-align:top; border-right:1px solid #E5E5E5">
                            <table style="width:100%; border-collapse:collapse">
                              <tbody>
                                <tr>
                                  <td style="vertical-align:top; padding:18px 18px 8px 23px; font-family:'Roboto', Arial !important">
                                   
                                  </td>
                                </tr>
                                <tr style="">
                                  <td style="vertical-align:top; padding:0 18px 18px 23px">
                                    <table width="100%" style="border-collapse:collapse">
                                      <tbody>
                                        
                                          <td style="font-family:'Roboto', Arial !important">
                                            <p style="font-size:16px; color:#000; margin:0 0 5px 0; font-family:'Roboto', Arial !important">
                                             الباقة:
                                            </p>
                                          </td>
                                          <td align="left" style="font-family:'Roboto', Arial !important">
                                            <p style="font-size:16px; color:#000; margin:0 0 5px 0; font-family:'Roboto', Arial !important">
                                              {{ App\Models\Package::find($sub->package_id)->title }}
                                            </p>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="font-family:'Roboto', Arial !important">
                                            <p style="font-size:16px; color:#000; margin:0 0 5px 0; font-family:'Roboto', Arial !important">
                                                سعر الاشتراك :
                                            </p>
                                          </td>
                                          <td align="left" style="font-family:'Roboto', Arial !important">
                                            <p style="font-size:16px; color:#000; margin:0 0 5px 0; font-family:'Roboto', Arial !important">
                                                {{ $sub->amount }}
                                            </p>
                                          </td>
                                        </tr>

                                        <tr>
                                            <td style="font-family:'Roboto', Arial !important">
                                              <p style="font-size:16px; color:#000; margin:0 0 5px 0; font-family:'Roboto', Arial !important">
                                                  يبدأ الاشتراك في :
                                              </p>
                                            </td>
                                            <td align="left" style="font-family:'Roboto', Arial !important">
                                              <p style="font-size:16px; color:#000; margin:0 0 5px 0; font-family:'Roboto', Arial !important">
                                                  {{ $sub->start_at }}
                                              </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:'Roboto', Arial !important">
                                              <p style="font-size:16px; color:#000; margin:0 0 5px 0; font-family:'Roboto', Arial !important">
                                                  ينتهي الاشتراك في :
                                              </p>
                                            </td>
                                            <td align="left" style="font-family:'Roboto', Arial !important">
                                              <p style="font-size:16px; color:#000; margin:0 0 5px 0; font-family:'Roboto', Arial !important">
                                                  {{ $sub->end_at}}
                                              </p>
                                            </td>
                                        </tr>
                                   
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                
  
              </tbody>
            </table>
          </td>
        </tr>
      
      </tbody>
    </table>
  </body>