<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Erro de Configuração PIX</title>
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
     <div class="container p-4 text-center mt-5">
    </div>
    
      <div class="container  text-center">
          <svg width="200" height="200" viewBox="0 0 223 223" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<rect x="0.863281" y="0.546387" width="221.695" height="221.695" fill="url(#pattern0_1228_201)"/>
<defs>
<pattern id="pattern0_1228_201" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0_1228_201" transform="scale(0.0105263)"/>
</pattern>
<image id="image0_1228_201" width="95" height="95" xlink:href="data:image/png;base64,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"/>
</defs>
</svg>

        

    </div>
      

    <div class="container text-center mt-2">
     <h4 class="text-center  text-alerta ">Pagamento realizado com sucesso!</h4>
    </div>
       <div class="container  text-center"> 
       <h4 class="text-center  text-roboto-medium mt-4 ">Estamos preparando seu pedido...</h4>
        </div>
        
    <div class="container  text-center mt-4"> 
        <div class="d-grid gap-2">
       <a  class="btn btn-danger btn-lg text-roboto">Voltar</a>
        </div>
    </div>
   
   
    </div>
    
    <!-- Bootstrap JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
