    <style>
        @import url('https://fonts.googleapis.com/css?family=Sen&display=swap');
        body {
            background: white;
            font-family: 'Sen', sans-serif;
            font-size: 13px;
          }
          table{
            font-family: 'Sen', sans-serif;
            font-size: 11px;
          } 
          .header{
              width:100%;
              background-color: #2e3c54;
              color:white;
              text-align: center;
              position: fixed;
              top:0;
              -webkit-print-color-adjust: exact;
          }
          .footer{
              width:100%;
              background-color: white;
              color:white;
              text-align: center;
              position: fixed;
              bottom:0;
              font-size: 8px;
              -webkit-print-color-adjust: exact;
          }
          .m-t-60{
              margin-top:60px;
          }
          .titulo{
              font-weight: bold;
              text-transform: uppercase;
          }
          @media print {
            body, page {
              margin: 0;
              box-shadow: 0;
              -webkit-print-color-adjust: exact;
            }
            .header{}
            .footer{}
            .m-t-60{}
              
          }

    </style>
    
     <?php echo $this->fetch('content'); ?>
    



