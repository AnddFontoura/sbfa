## Sistema Brasileiro de Futebol Amador

Desenvolvido para uma equipe em especial mas sendo feito pensando em receber qualquer equipe a qualquer momento. A ideia do sistema
é ser um facilitador para encontrar jogadores, times, confrontos e campeonatos e está em desenvolvimento constante. 

Iniciado em 2022 idealizado pelo dono desse GIT e um time de São José dos Pinhais esperamos facilitar o cenário amador com um sistema 
robusto e responsivo.

Favor não monetizar em cima desse sistema. Ele só deve ser adquirido diretamente comigo. Caso queira tornar esse projeto comerciavel
só será permitido através do meu aval.

Desenvolvido em Laravel e hospedado na Hostinger, em breve libero o link para apreciação

Contato: 41 9 9251 6138 / contato@fontouradesenvolvimento.com.br

## Design System
ADMINLTE 3.5.0 (https://adminlte.io/themes/v3/index3.html)

Todo botão de criar -> success
Todo botão de listar -> info
Todo botão de deletar -> danger

## Instalação simples:
- Windows:

- Baixe o Laragon (https://laragon.org/) e instale
- Com ele instalado, abra o terminal do programa, clone o projeto, entre no projeto
- composer install
- php artisan key:generate
- php artisan storage:link
- Copie, cole e renomeie o arquivo .env.example para .env
- Abra o arquivo .env no editor de sua preferencia (sugiro o visual studio code com a extensão phpintelephense instalado)
- Modifque as conexões do banco, se usou laragon padrão talvez só precise mudar a senha do banco para vazio ao inves de root
- php artisan migrate
- php artisan serve

Teoricamente seu sistema está pronto pra rodar se você apertar o start all (iniciar tudo) do Laragon

No linux, não instale o laragon, todo o resto é necessário. (necessário instalar o php 7.4 e mysql)