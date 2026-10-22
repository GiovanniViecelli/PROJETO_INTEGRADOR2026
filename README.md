
# 🍔 Giseleburguer – Sistema para Hamburgueria

Sistema web em **PHP + PostgreSQL** para uma hamburgueria. Ele tem duas partes:

| Quem usa | O que vê | Precisa de login? |
|----------|----------|-------------------|
| **Cliente** | Cardápio público com foto, descrição e preço dos lanches | Não |
| **Administrador (dono da loja)** | Painel para gerenciar o cardápio e os pedidos | Sim |

---

## 📌 O que o site faz

### Cardápio público (o que o cliente vê)
- Endereço: `cardapio-publico.php`
- Mostra a logo da Gisburguer e todos os lanches em cards, com **foto, nome, descrição e preço**.
- Não exige login. Tudo que o administrador altera no painel aparece aqui na hora.
- Tem um botão **"Já sou cliente / Fazer pedido"** que leva à tela de login.

### Painel do administrador (área com login)
- **Login / Cadastro / Logout:** o administrador cria uma conta (e-mail e senha), entra e sai do sistema. As páginas internas ficam bloqueadas para quem não está logado.
- **Gerenciar lanches (cardápio):** listar, cadastrar (com foto), editar (inclusive trocar a foto) e excluir lanches.
- **Gerenciar pedidos:** listar, cadastrar, editar e excluir pedidos. Cada pedido tem cliente, lanche, quantidade, data e **status** (`pendente`, `em preparo`, `pronto`, `entregue`). O administrador atualiza o status editando o pedido.

### Fluxo de páginas

```
index.php ──► logado?  ── sim ──► app/lanches/select.php (cardápio admin)
                       └─ não ──► login/login.php

cardapio-publico.php  (aberto para qualquer cliente)
```

---

## ✅ Requisitos Funcionais

| RF | Descrição |
|----|-----------|
| RF01 | Cadastrar usuários (e-mail e senha) |
| RF02 | Realizar login |
| RF03 | Realizar logout |
| RF04 | Bloquear o acesso às páginas internas para usuários não logados |
| RF05 | Cadastrar lanche (nome, descrição, preço e foto) |
| RF06 | Listar lanches |
| RF07 | Editar lanche, inclusive trocar a foto |
| RF08 | Excluir lanche |
| RF09 | Cadastrar pedido (cliente, lanche, quantidade e status) |
| RF10 | Listar pedidos |
| RF11 | Editar pedido (ex.: atualizar o status) |
| RF12 | Excluir pedido |
| RF13 | Exibir o cardápio público com fotos, sem exigir login |
| RF14 | Exibir a logo da Gisburguer nas telas de login, cadastro e cardápios |

## ⚙️ Requisitos Não Funcionais

| RNF | Descrição |
|-----|-----------|
| RNF01 | Linguagem PHP 7.4 ou superior, com banco **PostgreSQL** acessado via **PDO** |
| RNF02 | Consultas com *prepared statements*, evitando SQL Injection |
| RNF03 | Controle de sessão de usuário com `$_SESSION` |
| RNF04 | Código organizado por pastas (`app`, `login`, `includes`, `database`, `style`, `img`, `uploads`) |
| RNF05 | Layout simples, com um CSS único (`style/style.css`) |
| RNF06 | Interface simples, para uso sem conhecimento técnico |
| RNF07 | **Portável:** os links e redirecionamentos se ajustam sozinhos (`includes/config.php`), funcionando na raiz do domínio ou em subpasta |
| RNF08 | Compatível com servidor Linux, com servidor web Nginx e PHP-FPM |
| RNF09 | Upload de imagens JPG, PNG, GIF e WEBP, salvas em `uploads/lanches/` |

> ⚠️ **Segurança:** a senha dos usuários é salva **em texto puro** (simplificação do projeto acadêmico). Para uso comercial real, o ideal é migrar para `password_hash()` / `password_verify()`.

---

## 📁 Estrutura do projeto

```
hamburgueria-gisburguer/
├── index.php                # Porta de entrada (redireciona para login ou painel)
├── cardapio-publico.php     # Cardápio que o cliente vê
├── app/
│   ├── lanches/             # CRUD de lanches (select, create, update, delete)
│   └── pedidos/             # CRUD de pedidos
├── login/                   # login, cadastrar, logout, verifica-login
├── includes/                # config.php (URL base), functions.php, header, footer
├── database/
│   ├── connect.php          # Conexão com o PostgreSQL
│   └── schema.sql           # Script que cria as tabelas
├── style/style.css
├── img/                     # Logos
├── uploads/lanches/         # Fotos dos lanches
└── documentacoes/
```

---

## 🚀 Como fazer o deploy no servidor

Este passo a passo explica como baixar o projeto do GitHub e colocá-lo no servidor Linux do professor.

### 1. Pegar o projeto no GitHub

1. Abra o repositório do projeto no GitHub.
2. Clique em **Code** e copie a URL da opção **HTTPS**.
3. Abra o MobaXterm e conecte ao servidor em **Session → SSH**, usando o IP e o usuário fornecidos pelo professor/administrador.

### 2. Instalar os programas necessários

No terminal do servidor (Ubuntu/Debian), execute:

```bash
sudo apt update
sudo apt install -y git nginx postgresql php-fpm php-pgsql
```

### 3. Baixar o projeto

URL copiada no GitHub:

```bash
cd /var/www
sudo git clone https://github.com/GiovanniViecelli/hamburgueria-gisburguer gisburguer
sudo chown -R www-data:www-data /var/www/gisburguer
```

### 4. Criar e preencher o banco de dados

Crie o usuário e o banco. Troque `SUA_SENHA` por uma senha escolhida para o servidor:

```bash
sudo -u postgres psql
```

No prompt do PostgreSQL, execute:

```sql
CREATE USER hamburgueria WITH PASSWORD 'SUA_SENHA';
CREATE DATABASE hamburgueria OWNER hamburgueria;
\q
```

Importe as tabelas e os dados que acompanham o projeto:

```bash
sudo -u postgres psql -d hamburgueria -f /var/www/gisburguer/database/backup_hamburgueria.sql
```

### 5. Configurar a conexão do site

Abra o arquivo de conexão:

```bash
sudo nano /var/www/gisburguer/database/connect.php
```

Confira se as configurações estão de acordo com o banco criado:

```php
$host = "localhost";
$dbname = "hamburgueria";
$user = "hamburgueria";
$pass = "SUA_SENHA";
```

A senha deve ser a mesma usada no passo anterior. Salve com `Ctrl+O`, `Enter` e saia com `Ctrl+X`.

### 6. Permitir o envio de fotos

```bash
sudo mkdir -p /var/www/gisburguer/uploads/lanches
sudo chown -R www-data:www-data /var/www/gisburguer/uploads
sudo chmod -R 775 /var/www/gisburguer/uploads
```

### 7. Configurar o Nginx

Veja qual socket do PHP está instalado:

```bash
ls /run/php/
```

Crie a configuração do site:

```bash
sudo nano /etc/nginx/sites-available/gisburguer
```

Cole o conteúdo abaixo. Se o arquivo em `/run/php/` tiver outro nome, ajuste `php8.3-fpm.sock` para o nome correto.

```nginx
server {
    listen 80;
    server_name _;
    root /var/www/gisburguer;
    index index.php;
    client_max_body_size 10M;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
    }

    location ~ /\. {
        deny all;
    }
}
```

Ative o site e reinicie os serviços (ajuste `php8.3-fpm` para a versão instalada):

```bash
sudo ln -s /etc/nginx/sites-available/gisburguer /etc/nginx/sites-enabled/gisburguer
sudo nginx -t
sudo systemctl enable --now postgresql nginx
sudo systemctl restart php8.3-fpm
sudo systemctl reload nginx
```

### 8. Abrir o site

No navegador, acesse `http://IP-DO-SERVIDOR/`, substituindo pelo IP do servidor. O cardápio público fica em `http://IP-DO-SERVIDOR/cardapio-publico.php`.

Na primeira visita, use **Cadastre-se** na tela de login para criar a conta de administrador.


---

## 🛠️ Problemas comuns

| Sintoma | Causa provável | Solução |
|---------|----------------|---------|
| `Erro na conexão: could not find driver` | Falta a extensão do PostgreSQL | `sudo apt install php-pgsql` e `sudo systemctl restart php8.3-fpm` (use a sua versão) |
| `Erro na conexão` | Dados errados em `database/connect.php` ou PostgreSQL parado | Conferir as credenciais e `sudo systemctl status postgresql` |
| Erro `relation "usuarios" does not exist` | Tabelas não criadas | Executar o passo 6 |
| Foto não é salva ("Erro ao salvar a imagem") | Sem permissão na pasta `uploads` | Executar o passo 8 |
| "A imagem é muito grande" | Limite do PHP | Aumentar `client_max_body_size` no Nginx e `upload_max_filesize`/`post_max_size` no `php.ini` (passo 9) |
| Erro 404 em `login/login.php` | Pasta com nome diferente (Linux diferencia maiúsculas) | Garantir que a pasta se chama `login` em minúsculas |
| Página em branco ou `502 Bad Gateway` | Socket do PHP-FPM errado ou serviço parado | Conferir a versão no `fastcgi_pass` (`ls /run/php/`) e `sudo systemctl status php8.3-fpm` |
| Baixa o arquivo `.php` em vez de abrir | Bloco `location ~ \.php$` ausente | Revisar o passo 9 e rodar `sudo nginx -t` |
| Banco em outra máquina não conecta | Firewall / `pg_hba.conf` | Liberar a porta 5432 e o IP do site no PostgreSQL |

---

## 📄 Documentação completa

Veja `documentacoes/documentacao.md`.

Projeto Integrador © Gisburguer---
