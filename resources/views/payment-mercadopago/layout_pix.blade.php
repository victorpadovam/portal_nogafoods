<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Gera QRCode</title>
    <style>
    @font-face {
        font-family: 'GoldPlay';
        src: url('/assets/mercado_pogo/fonts/GoldPlay-Bold.woff2') format('woff2'),
            url('/assets/mercado_pogo/fonts/GoldPlay-Bold.woff') format('woff');
        font-weight: bold;
        font-style: normal;
    }
    .text-alerta {
        font-family: 'GoldPlay', sans-serif;
        font-weight: bold;
        color: black;
    }

    @font-face {
        font-family: 'Helvetica';
        src: url('/assets/mercado_pogo/fonts/Helvetica-Bold.ttf') format('truetype');
        font-weight: bold;
        font-style: normal;
    }
    .text-pix {
        font-family: 'Helvetica', sans-serif;
        font-weight: bold;
    }

    @font-face {
        font-family: 'Helvetica-Regular';
        src: url('/assets/mercado_pogo/fonts/Helvetica.ttf') format('truetype');
        font-weight: bold;
        font-style: normal;
    }
    .text-regular {
        font-family: 'Helvetica-Regular', sans-serif;
    }

    @font-face {
        font-family: 'Roboto-Bold';
        src: url('/assets/mercado_pogo/fonts/Roboto-Bold.ttf') format('truetype');
        font-weight: bold;
        font-style: normal;
    }
    .text-roboto {
        font-family: 'Roboto-Bold', sans-serif;
    }
    
        @font-face {
        font-family: 'Roboto-Medium';
        src: url('/assets/mercado_pogo/fonts/Roboto-Medium.ttf') format('truetype');
        font-style: normal;
    }
    .text-roboto-medium {
        font-family: 'Roboto-Medium', sans-serif;
         font-size: 18px;
         color: #6F6F6F;
    }


.container {
    width: 100%;
    padding: 0 15px; 
    box-sizing: border-box; 
}

.dashed-card {
    border: 5px dashed #ccc; /* Borda tracejada */
    border-radius: 5px; /* Cantos arredondados */
    padding: 10px; /* Espaçamento interno ajustado */
    position: relative; /* Posicionamento relativo para o ícone */
    margin: 10px; /* Margem externa */
    background-color: white; /* Cor de fundo */
    box-sizing: border-box; /* Inclui padding e border no tamanho total */
    width: 100%; /* Faz o card ocupar 100% da largura disponível */
    max-width: 600px; /* Define uma largura máxima para o card */
    overflow: hidden; /* Garante que o conteúdo não saia do card */
}
.dashed-card p {
    margin: 0 0 0 0; /* Margem inferior para espaçamento entre parágrafos */
    padding: 5px; /* Espaçamento interno ao redor do texto */
    font-size: 14px; /* Ajusta o tamanho da fonte conforme necessário */
    line-height: 1; /* Melhora a legibilidade com espaçamento entre linhas */
    color: #333; /* Define a cor do texto */
}
/* Alinha o card no centro da tela */
.d-flex {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Responsividade para telas menores */
@media (max-width: 768px) {
    .dashed-card {
        margin: 10px; /* Reduz a margem para telas menores */
        padding: 15px; /* Reduz o padding para telas menores */
    }
}

@media (max-width: 576px) {
    .dashed-card {
        margin: 5px; /* Reduz ainda mais a margem para telas muito pequenas */
        padding: 10px; /* Reduz ainda mais o padding */
    }
}
        
     
    


    .btn-custom {
      background-color: #FF3000; /* Cor do botão alterada */
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 18px;
      cursor: pointer;
      border-radius: 5px;
    }

    .btn-custom:hover {
      background-color: #e02600; /* Cor mais escura no hover */
    }

    </style>
</head>
<body>
     <div class="container p-4 text-center">
     <h4 class="text-center  text-alerta mt-4 ">Aguardando Pagamento</h4>
    </div>
    
    <div class="container  text-center">
             

            <svg width="146" height="40" viewBox="0 0 146 70" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <path d="M106.062 37.7584H100.35V34.4681H106.062C106.996 34.4681 107.753 34.3157 108.332 34.0111C108.921 33.6962 109.352 33.2697 109.627 32.7315C109.901 32.1831 110.038 31.5585 110.038 30.8578C110.038 30.1774 109.901 29.5427 109.627 28.9537C109.352 28.3647 108.921 27.8874 108.332 27.5218C107.753 27.1562 106.996 26.9734 106.062 26.9734H101.721V45.8472H97.5315V23.6678H106.062C107.788 23.6678 109.261 23.9775 110.48 24.597C111.708 25.2063 112.643 26.0543 113.282 27.1409C113.932 28.2174 114.257 29.4462 114.257 30.8273C114.257 32.2593 113.932 33.4931 113.282 34.529C112.643 35.5648 111.708 36.362 110.48 36.9206C109.261 37.4791 107.788 37.7584 106.062 37.7584ZM122.011 23.6678V45.8472H117.822V23.6678H122.011ZM130.146 23.6678L134.578 31.5738L139.026 23.6678H143.84L137.259 34.6661L144.008 45.8472H139.148L134.578 37.7889L130.024 45.8472H125.149L131.897 34.6661L125.317 23.6678H130.146Z" fill="#1F1F1F"/>
            <rect x="0.835938" y="0.90332" width="71.1588" height="68.8878" fill="url(#pattern0_1414_28)"/>
            <defs>
            <pattern id="pattern0_1414_28" patternContentUnits="objectBoundingBox" width="1" height="1">
            <use xlink:href="#image0_1414_28" transform="scale(0.00265957 0.00274725)"/>
            </pattern>
            <image id="image0_1414_28" width="376" height="364" xlink:href="data:image/png;base64,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"/>
            </defs>
            </svg>
            
        </div>
         <div class="container  text-center"> 
          <img src="{{ $qrcodepix }}"  width="200" class="img-fluid">
         </div>
         
         <div class="container  text-center"> 
           <h4 class="text-center  text-alerta mt-4 ">Copie ou escaneie o QR CODE</h4>
         </div>
        
    <div class="container">
        <div class="d-flex justify-content-center align-items-center" >
            <div class="dashed-card">
                <!-- Conteúdo do card -->
               <p>
                {{ strlen($qrcodepixCopyPaste) > 57 ? substr($qrcodepixCopyPaste, 0, 57) . '...' : $qrcodepixCopyPaste }}
            </p>
            </div>
        </div>
    </div>
    <div class="container  text-center"> 
       <h4 class="text-center  text-roboto-medium mt-4 ">Ao copiar o código, abra o aplicativo do seu banco. cadastrado no PIX e realize o pagamento.</h4>
    </div>
       <div class="container  text-center mt-4"> 
            <div class="d-grid gap-2">
                  <!-- Campo invisível que contém o código a ser copiado -->
               <input type="text" value="{{ $paymentId }}" id="paymentId" style="position: absolute; left: -9999px;">

                <input type="text" value="{{ $qrcodepixCopyPaste }}" id="codigoTexto" style="position: absolute; left: -9999px;">
                <a onclick="copiarCodigo()" class="btn btn-danger btn-lg text-roboto">Copiar código</a>
            </div>
    </div>
    <div class="container  text-center"> 
           <h4 id="shareButton" class="text-center text-alerta mt-4" style="font-size: 16px;">Compartilhar código</h4>
    </div>
                
    <div class="container  text-center mt-5"> 
          
    </div>
   
    </div>
     <script>
     
    var paymentId = document.getElementById("paymentId").value;

    function verificarPagamento() {
        console.log('verificando');
        if (!paymentId) {
            console.error('paymentId não está definido.');
            return;
        }
    
        fetch('https://portal.nogafoods.com.br/api/v1/buscaDadosDePagamento/' + paymentId)
            .then(response => {
                // Verifica se a resposta é JSON válida
                if (response.headers.get('content-type').includes('application/json')) {
                    return response.json();
                } else {
                    throw new Error('Resposta não é JSON');
                }
            })
            .then(data => {
                if (data.status == 'approved') {
                    window.location.href = "https://portal.nogafoods.com.br/api/v1/sucesso-pagamento";
                }
            })
            .catch(error => {
                console.error('Erro ao verificar o pagamento:', error);
            });
    }
    
    // Defina o intervalo para verificar o pagamento a cada 5 segundos (5000 milissegundos)
    setInterval(verificarPagamento, 5000);

        
        
        
        document.getElementById('shareButton').addEventListener('click', function() {
    if (navigator.share) {
        navigator.share({
            title: 'Compartilhar Código',
           text: document.getElementById("codigoTexto").value,
        }).then(() => {
            console.log('Obrigado por compartilhar!');
        }).catch((error) => {
            console.error('Erro ao compartilhar:', error);
        });
    } else {
        // Fallback para copiar o link para a área de transferência
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link copiado para a área de transferência!');
        }).catch((error) => {
            console.error('Erro ao copiar:', error);
        });
    }
});


        function copiarCodigo() {
          var codigo = document.getElementById("codigoTexto");
          
          codigo.select();
          codigo.setSelectionRange(0, 99999); 
          
          document.execCommand("copy");
          
          alert("Código copiado");
        }
  </script>

    <!-- Bootstrap JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
