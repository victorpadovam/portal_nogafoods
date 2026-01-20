
document.addEventListener('DOMContentLoaded', function() {
    inicializaPagamentoDigitalAtivado();
    inicializaPagamentoNaEntregaAtivado();
    inicializaPagamentoNaRetiradaAtivado();
});

function trocarImagemPagamentoNoApp() {
    var img = document.getElementById('pagamento-digital-img');
    var cardBodyPagamentoDigital = document.getElementById('card-body-pagamento-digital-no-app');
    var inputValuePagamentoDigital = document.getElementById('pagamento_digital_no_app_ativado');
    var cardCartaoEPix = document.getElementById('cartaoEPix');



    if (img.src.includes('pagamento_digital_no_app_sim_ativado.svg')) {
        img.src = '/public/assets/admin/svg/metodo-de-pagamentos/pagamento_digital_no_app_nao_ativado.svg';
        cardBodyPagamentoDigital.style.display = 'none';
         cardCartaoEPix.style.display = 'none';
        inputValuePagamentoDigital.value = '0';
    } else {
        img.src = '/public/assets/admin/svg/metodo-de-pagamentos/pagamento_digital_no_app_sim_ativado.svg';
        cardBodyPagamentoDigital.style.display = 'block';
        cardCartaoEPix.style.display = 'block';
        inputValuePagamentoDigital.value = '1';
    }
}

function trocarImagemPagamentoNaEntrega() {
    var img = document.getElementById('pagamento-na-entrega');
    var cardBodyNaEntrega = document.getElementById('card-body-pagamento-na-entrega');
    var inputValuePagamentoNaEntrega = document.getElementById('pagamento_na_entrega_ativado');

    console.log(img.src);
    if (img.src.includes('pagamento_na_entrega_sim_ativado.svg')) {
        img.src = '/public/assets/admin/svg/metodo-de-pagamentos/pagamento_na_entrega_nao_ativado.svg';
        cardBodyNaEntrega.style.display = 'none';
        inputValuePagamentoNaEntrega.value = '0';

    } else {
        img.src = '/public/assets/admin/svg/metodo-de-pagamentos/pagamento_na_entrega_sim_ativado.svg';
        cardBodyNaEntrega.style.display = 'block';
        inputValuePagamentoNaEntrega.value = '1';
    }
}

function trocarImagemPagamentoNaRetirada() {
    var img = document.getElementById('pagamento-na-retirada');
    var cardBodyNaRetirada = document.getElementById('card-body-pagamento-na-retirada');
    var inputValuePagamentoNaRetirada = document.getElementById('pagamento_na_retirada_ativado');

    console.log(img.src);
    if (img.src.includes('pagamento_na_retirada_sim_ativado.svg')) {
        img.src = '/public/assets/admin/svg/metodo-de-pagamentos/pagamento_na_retirada_nao_ativado.svg';
        cardBodyNaRetirada.style.display = 'none';
        inputValuePagamentoNaRetirada.value = '0';

    } else {
        img.src = '/public/assets/admin/svg/metodo-de-pagamentos/pagamento_na_retirada_sim_ativado.svg';
        cardBodyNaRetirada.style.display = 'block';
        inputValuePagamentoNaRetirada.value = '1';
    }
}

function inicializaPagamentoDigitalAtivado () {
    var imgDigital = document.getElementById('pagamento-digital-img');
    var cardBodyPagamentoDigital = document.getElementById('card-body-pagamento-digital-no-app');
    var inputValuePagamentoDigital = document.getElementById('pagamento_digital_no_app_ativado').value;
    var cardCartaoEPix = document.getElementById('cartaoEPix');


    if (inputValuePagamentoDigital === '1') {
        imgDigital.src = '/public/assets/admin/svg/metodo-de-pagamentos/pagamento_digital_no_app_sim_ativado.svg';
        cardBodyPagamentoDigital.style.display = 'block';
        cardCartaoEPix.style.display = 'block';
    } else {
        imgDigital.src = '/public/assets/admin/svg/metodo-de-pagamentos/pagamento_digital_no_app_nao_ativado.svg';
        cardBodyPagamentoDigital.style.display = 'none';
        cardCartaoEPix.style.display = 'none';
    }
}

function inicializaPagamentoNaEntregaAtivado () {
    var imgpgEntregaAt = document.getElementById('pagamento-na-entrega');
    var cardBodyNaEntrega = document.getElementById('card-body-pagamento-na-entrega');
    var inputValuePagamentoNaEntrega = document.getElementById('pagamento_na_entrega_ativado').value

    if (inputValuePagamentoNaEntrega === '1') {
        imgpgEntregaAt.src = '/public/assets/admin/svg/metodo-de-pagamentos/pagamento_na_entrega_sim_ativado.svg';
        cardBodyNaEntrega.style.display = 'block';
    } else {
        imgpgEntregaAt.src = '/public/assets/admin/svg/metodo-de-pagamentos/pagamento_na_entrega_nao_ativado.svg';
        cardBodyNaEntrega.style.display = 'none';
    }
}

function inicializaPagamentoNaRetiradaAtivado () {
    var imgpgRetiradaAt = document.getElementById('pagamento-na-retirada');
    var cardBodyNaRetirada = document.getElementById('card-body-pagamento-na-retirada');
    var inputValuePagamentoNaRetirada = document.getElementById('pagamento_na_retirada_ativado').value

    console.log(inputValuePagamentoNaRetirada);
    if (inputValuePagamentoNaRetirada === '1') {
        imgpgRetiradaAt.src = '/public/assets/admin/svg/metodo-de-pagamentos/pagamento_na_retirada_sim_ativado.svg';
        cardBodyNaRetirada.style.display = 'block';
    } else {
        imgpgRetiradaAt.src = '/public/assets/admin/svg/metodo-de-pagamentos/pagamento_na_retirada_nao_ativado.svg';
        cardBodyNaRetirada.style.display = 'none';
    }
}

function vincularContasMercadopago(idUsuario) {
    var idDoAppRecebimentoNogaFoodsMP = 3303584281305432;
    var urlDeRedirecionamento = "https://portal.nogafoods.com.br/api/v1/mercadopago-autoriza-contas";
    var url = "https://auth.mercadopago.com.br/authorization?client_id=" + idDoAppRecebimentoNogaFoodsMP + "&response_type=code&state=" + idUsuario +  "&platform_id=mp&redirect_uri=" + urlDeRedirecionamento
    window.open(url, '_blank');
}



// Card for Pix
    function togglePixImage() {
        const pixImage = document.querySelector('#pixImage');
        const pixValue = document.querySelector('#toggleValuePix');
        // Verifica o valor atual (1 = habilitado, 0 = desabilitado)
        if (pixImage.src.includes('responsivo')) {
            if (pixValue.value === '1') {
                pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_desabilitado_responsivo.png';
                pixValue.value = '0';
            } else {
                pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_habilitado_responsivo.png';
                pixValue.value = '1';
            }

        } else {
            if (pixValue.value === '1') {
                pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_desabilitado_botao.png';
                pixValue.value = '0';
            } else {
                pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_habilitado_botao.png';
                pixValue.value = '1';
            }
        }
    }

// Card for Credit Card
    function toggleCartaoImage() {
        const cartaoImage = document.querySelector('#cartaoImage');
        const cartaoValue = document.querySelector('#toggleValueCartao');
        // Verifica o valor atual (1 = habilitado, 0 = desabilitado)
        if (cartaoImage.src.includes('responsivo')) {
            if (cartaoValue.value === '1') {
                cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_desabilitado_responsivo.png';
                cartaoValue.value = '0';
            } else {
                cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_habilitado_responsivo.png';
                cartaoValue.value = '1';
            }

        } else {
            if (cartaoValue.value === '1') {
                cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_desabilitado_botao.png';
                cartaoValue.value = '0';
            } else {
                cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_habilitado_botao.png';
                cartaoValue.value = '1';
            }
        }
    }
    
    //INICALIZA VALORES PARA AS IMG - PIX
    document.addEventListener('DOMContentLoaded', function() {
        // Configuração inicial para Pix
        const pixValue = document.querySelector('#toggleValuePix');
        const pixImage = document.querySelector('#pixImage');
        if (pixValue && pixImage) {
            const observerPix = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'src') {
                        const pixSrc = pixImage.getAttribute('src'); // Verifica o src atualizado
                        console.log('SRC atualizado (Pix):', pixSrc);

                        if (pixSrc.includes('responsivo')) {
                            if (pixValue.value === '1' && pixSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/pix_habilitado_responsivo.png') {
                                pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_habilitado_responsivo.png';
                            } else if (pixValue.value !== '1' && pixSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/pix_desabilitado_responsivo.png') {
                                pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_desabilitado_responsivo.png';
                            }
                        } else {
                            if (pixValue.value === '1' && pixSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/pix_habilitado_botao.png') {
                                pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_habilitado_botao.png';
                            } else if (pixValue.value !== '1' && pixSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/pix_desabilitado_botao.png') {
                                pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_desabilitado_botao.png';
                            }
                        }
                    }
                });
            });

            observerPix.observe(pixImage, {
                attributes: true
            });

            // Código inicial para verificar o src quando a página carrega
            const initialPixSrc = pixImage.getAttribute('src');
            if (initialPixSrc && initialPixSrc.includes('responsivo')) {
                if (pixValue.value === '1' && initialPixSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/pix_habilitado_responsivo.png') {
                    pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_habilitado_responsivo.png';
                } else if (pixValue.value !== '1' && initialPixSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/pix_desabilitado_responsivo.png') {
                    pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_desabilitado_responsivo.png';
                }
            } else {
                if (pixValue.value === '1' && initialPixSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/pix_habilitado_botao.png') {
                    pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_habilitado_botao.png';
                } else if (pixValue.value !== '1' && initialPixSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/pix_desabilitado_botao.png') {
                    pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_desabilitado_botao.png';
                }
            }
        } else {
            console.error('Elemento #pixImage ou #toggleValuePix não encontrado.');
        }
    });
    
    
    //INICALIZA VALORES PARA AS IMG - Cartão de Crédito
    document.addEventListener('DOMContentLoaded', function() {
        // Configuração inicial para Cartão de Crédito
        const cartaoValue = document.querySelector('#toggleValueCartao');
        const cartaoImage = document.querySelector('#cartaoImage');

        if (cartaoValue && cartaoImage) {
            // Criar um observador para detectar mudanças no 'src'
            const observerCartao = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'src') {
                        const cartaoSrc = cartaoImage.getAttribute('src'); // Verifica o src atualizado
                        console.log('SRC atualizado (Cartão):', cartaoSrc);

                        // Verifica se a atualização é necessária antes de alterar o src
                        if (cartaoSrc.includes('responsivo')) {
                            if (cartaoValue.value === '1' && cartaoSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/cartao_habilitado_responsivo.png') {
                                cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_habilitado_responsivo.png';
                            } else if (cartaoValue.value !== '1' && cartaoSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_desabilitado_responsivo.png') {
                                cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_desabilitado_responsivo.png';
                            }
                        } else {
                            if (cartaoValue.value === '1' && cartaoSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_habilitado_botao.png') {
                                cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_habilitado_botao.png';
                            } else if (cartaoValue.value !== '1' && cartaoSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_desabilitado_botao.png') {
                                cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_desabilitado_botao.png';
                            }
                        }
                    }
                });
            });

            // Iniciar o observador no cartaoImage
            observerCartao.observe(cartaoImage, {
                attributes: true // Observar apenas atributos
            });

            // Código inicial para verificar o src quando a página carrega
            const initialCartaoSrc = cartaoImage.getAttribute('src');
            if (initialCartaoSrc && initialCartaoSrc.includes('responsivo')) {
                if (cartaoValue.value === '1' && initialCartaoSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/cartao_habilitado_responsivo.png') {
                    cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_habilitado_responsivo.png';
                } else if (cartaoValue.value !== '1' && initialCartaoSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_desabilitado_responsivo.png') {
                    cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_desabilitado_responsivo.png';
                }
            } else {
                if (cartaoValue.value === '1' && initialCartaoSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_habilitado_botao.png') {
                    cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_habilitado_botao.png';
                } else if (cartaoValue.value !== '1' && initialCartaoSrc !== '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_desabilitado_botao.png') {
                    cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_desabilitado_botao.png';
                }
            }
        } else {
            console.error('Elemento #cartaoImage ou #toggleValueCartao não encontrado.');
        }
    });
    

// Função para alternar a visibilidade do campo
document.querySelectorAll('.toggle-password').forEach(item => {
    item.addEventListener('click', function() {
        const input = document.querySelector(this.getAttribute('toggle'));
        if (input.getAttribute('type') === 'password') {
            input.setAttribute('type', 'text');
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        } else {
            input.setAttribute('type', 'password');
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        }
    });
});


function toggleCard() {
    console.log('clicou');
    var card = document.getElementById("custom-card");

    if (card.style.display === "none" || card.style.display === "") {
        card.style.display = "inline";

        setTimeout(function() {
            document.addEventListener('click', function closeCard(event) {
                // Fechar o card se o utilizador clicar dentro ou fora dele
                if (!card.contains(event.target) || card.contains(event.target)) {
                    card.style.display = "none";
                    document.removeEventListener('click', closeCard);
                }
            });
        }, 0);
    } else {
        card.style.display = "none";
    }
}


const responsivoEmTamanhoTelaEmPx = 1465;

function updatePixImageSrc() {
    const pixImage = document.getElementById('pixImage');

    if (window.innerWidth <= responsivoEmTamanhoTelaEmPx) {
      pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_habilitado_botao.png';
    } else {
      pixImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/pix_habilitado_responsivo.png';
    }
  }

  window.addEventListener('load', updatePixImageSrc);
  window.addEventListener('resize', updatePixImageSrc);

  function updateCartaoImageSrc() {
    const cartaoImage = document.getElementById('cartaoImage');

    if (window.innerWidth <= responsivoEmTamanhoTelaEmPx) {
      cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_de_credito_habilitado_botao.png';
    } else {
      cartaoImage.src = '/public/assets/admin/svg/metodo-de-pagamentos/cartao_habilitado_responsivo.png';
    }
  }

  window.addEventListener('load', updateCartaoImageSrc);
  window.addEventListener('resize', updateCartaoImageSrc);

  function updateImageStyle() {
    const pixImage = document.getElementById('pixImage');
    const cartaoImage = document.getElementById('cartaoImage')
    const divVendasNoPixECartao = document.querySelector('.divVendasNoPixECartao');
    const currentPix = pixImage.src;
    const currentCartao = cartaoImage.src;


    if (currentPix.includes("pix_habilitado_responsivo.png") || currentPix.includes("pix_desabilitado_responsivo.png") || currentCartao.includes("cartao_habilitado_responsivo.png") || currentCartao.includes("cartao_de_credito_desabilitado_responsivo.png")) {
        divVendasNoPixECartao.style.marginLeft = '36px';
        divVendasNoPixECartao.style.marginRight = '36px';
        divVendasNoPixECartao.style.marginTop = '35px';
    } else {
        divVendasNoPixECartao.style.marginLeft = '0px'; // Aplica o margin-left de 20px na div
    }
  }

  window.addEventListener('load', updateImageStyle);
