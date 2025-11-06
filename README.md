🧾 Gerador de Currículo

Este projeto é uma aplicação simples em HTML, PHP e Bootstrap que permite ao usuário preencher um formulário com suas informações pessoais, profissionais e acadêmicas, e gerar um currículo automaticamente.

📁 Estrutura do Projeto
/
├── Iindex.html        # Página principal com o formulário
├── formulario.php     # Script PHP que processa os dados enviados
├── style.css          # (Opcional) Estilos personalizados
├── script.js          # (Opcional) Scripts adicionais (para adicionar experiência/formação)
└── icone.png          # Ícone exibido no cabeçalho

🌐 Iindex.html

O arquivo Iindex.html contém o formulário principal onde o usuário insere suas informações:

Campos do formulário:

Nome completo

Data de nascimento

Idade

E-mail

Telefone

Endereço

Resumo profissional

Experiência (botão para adicionar)

Formação (botão para adicionar)

Resumo das habilidades

Ao final, há um botão “Gerar Currículo” que envia os dados para o arquivo formulario.php via método POST.

O layout utiliza o Bootstrap 5.3.8 para uma aparência moderna e responsiva.

🧠 formulario.php

O arquivo formulario.php é responsável por receber os dados enviados pelo formulário e gerar a página de currículo dinamicamente.
Normalmente, ele faz:

Leitura das variáveis $_POST

Exibição formatada das informações do usuário

Possível geração de um arquivo (por exemplo, um PDF ou HTML do currículo)

(O conteúdo exato desse arquivo pode variar; este resumo se baseia no padrão de uso com o HTML enviado.)

⚙️ Tecnologias Utilizadas

HTML5

PHP

Bootstrap 5.3.8

CSS3 (para estilização adicional)

JavaScript (para interatividade opcional)

🚀 Como Executar o Projeto

Baixe ou clone o repositório.

Coloque os arquivos em um servidor local com suporte a PHP, como:

XAMPP

WAMP

Laragon

Coloque a pasta do projeto dentro do diretório htdocs (ou equivalente).

Acesse no navegador:

http://localhost/gerador-curriculo/Iindex.html


Preencha o formulário e clique em “Gerar Currículo”.

🧩 Funcionalidades Futuras (sugestões)

Adicionar múltiplas experiências e formações dinamicamente.

Exportar currículo em PDF.

Permitir upload de foto de perfil.

Adicionar temas e modelos diferentes de currículo.

📄 Licença

Criado por Eduardo Weirich Godinho
