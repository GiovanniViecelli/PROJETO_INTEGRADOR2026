
# 🍔 Gisburguer – Sistema para Hamburgueria

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

## 🚀 Passo a passo para instalar (para quem adquiriu o sistema)

### 1. O que você precisa ter

| Item | Para que serve |
|------|----------------|
| Um servidor **Linux** (Ubuntu/Debian recomendado) com acesso SSH | Onde o site vai ficar |
| **MobaXterm** instalado no seu computador Windows ([download](https://mobaxterm.mobatek.net/download.html)) | Conectar no servidor e enviar os arquivos |
| IP, usuário e senha do servidor | Para a conexão SSH |
| Servidor web **Nginx** | Entregar as páginas |
| **PHP 7.4+ (PHP-FPM)** com as extensões `pgsql` e `pdo_pgsql` | Executar o sistema |
| **PostgreSQL** | Banco de dados |

### 2. Conectar ao servidor pelo MobaXterm

1. Abra o MobaXterm e clique em **Session → SSH**.
2. Em **Remote host**, digite o IP do servidor. Marque **Specify username** e informe o usuário (ex.: `root` ou `ubuntu`). A porta padrão é `22`.
3. Clique em **OK** e digite a senha. Pronto: você está no terminal do servidor.
4. Ao conectar, o MobaXterm abre à esquerda um **navegador de arquivos SFTP**. Você vai usá-lo para enviar o projeto.

### 3. Instalar Nginx, PHP e PostgreSQL

No terminal do MobaXterm (Ubuntu/Debian):

```bash
sudo apt update
sudo apt install -y nginx php-fpm php-pgsql postgresql postgresql-contrib unzip
```

Confira se o PHP enxerga o driver do PostgreSQL (deve aparecer `pdo_pgsql`):

```bash
php -m | grep pgsql
```

### 4. Criar o banco de dados

```bash
sudo -u postgres psql
```

Dentro do `psql`, execute (troque a senha por uma sua):

```sql
CREATE USER hamburgueria WITH PASSWORD 'hamburgueria';
CREATE DATABASE hamburgueria OWNER hamburgueria;
\q
```

### 5. Enviar o projeto para o servidor

**Pelo MobaXterm (arrastar e soltar):**
1. No painel SFTP da esquerda, navegue até `/var/www/`.
2. Arraste a pasta `hamburgueria-gisburguer` (ou o `.zip`) do seu computador para lá.
3. Se enviou o `.zip`, extraia no terminal:
   ```bash
   cd /var/www
   sudo unzip hamburgueria-gisburguer.zip
   ```

**Ou pelo GitHub (direto no servidor):**
```bash
cd /var/www
sudo apt install -y git
sudo git clone https://github.com/SEU-USUARIO/hamburgueria-gisburguer.git
```

### 6. Criar as tabelas

```bash
cd /var/www/hamburgueria-gisburguer
PGPASSWORD=hamburgueria psql -h localhost -U hamburgueria -d hamburgueria -f database/schema.sql
```

### 7. Configurar a conexão com o banco

Edite o arquivo `database/connect.php` (pelo terminal com `nano`, ou clicando duas vezes no arquivo no painel SFTP do MobaXterm):

```bash
sudo nano /var/www/hamburgueria-gisburguer/database/connect.php
```

Ajuste as quatro variáveis no topo:

```php
$host   = "localhost";        // IP do PostgreSQL (localhost se estiver no mesmo servidor)
$dbname = "hamburgueria";
$user   = "hamburgueria";
$pass   = "hamburgueria";     // a senha que você definiu no passo 4
```

Salve no nano com `Ctrl+O`, `Enter` e saia com `Ctrl+X`.

### 8. Dar permissão para salvar fotos

O usuário do PHP-FPM (`www-data`) precisa poder gravar na pasta de imagens:

```bash
cd /var/www/hamburgueria-gisburguer
sudo mkdir -p uploads/lanches
sudo chown -R www-data:www-data uploads
sudo chmod -R 775 uploads
```

### 9. Configurar o Nginx e abrir o site

Descubra a versão do PHP instalada (ex.: `8.1`, `8.3`), pois ela aparece no nome do socket do PHP-FPM:

```bash
php -v
ls /run/php/
```

Crie o arquivo de configuração do site:

```bash
sudo nano /etc/nginx/sites-available/gisburguer
```

Cole o conteúdo abaixo (troque `8.3` pela sua versão do PHP):

```nginx
server {
    listen 80;
    server_name _;

    root /var/www/hamburgueria-gisburguer;
    index index.php;

    # Limite de upload das fotos (padrão do Nginx é 1 MB)
    client_max_body_size 10M;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
    }

    # Bloqueia arquivos ocultos (ex.: .git)
    location ~ /\. {
        deny all;
    }
}
```

Ative o site, aumente o limite de upload do PHP e reinicie os serviços:

```bash
sudo ln -s /etc/nginx/sites-available/gisburguer /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default
sudo sed -i 's/^upload_max_filesize.*/upload_max_filesize = 10M/; s/^post_max_size.*/post_max_size = 12M/' /etc/php/8.3/fpm/php.ini
sudo nginx -t
sudo systemctl restart php8.3-fpm
sudo systemctl restart nginx
```

(Troque `8.3` pela sua versão do PHP nos comandos acima.) O comando `sudo nginx -t` deve mostrar `syntax is ok`.

| Página | Endereço |
|--------|----------|
| Entrada / login | `http://IP-DO-SERVIDOR/` |
| Cardápio do cliente | `http://IP-DO-SERVIDOR/cardapio-publico.php` |

> 💡 O sistema também funciona dentro de uma subpasta, pois os links são ajustados automaticamente pelo `config.php`.

### 10. Primeiro acesso

1. Abra a página de login e clique em **Cadastre-se**.
2. Crie a conta do administrador (e-mail e senha) e volte para o login.
3. Entre e cadastre seus lanches em **+ Novo lanche** (com foto).
4. Divulgue o link `.../cardapio-publico.php` para os clientes.
5. Registre e acompanhe os pedidos em **Pedidos**.

---

## 🧪 Testar no seu computador

Com PHP e PostgreSQL instalados, dentro da pasta do projeto:

```bash
php -S localhost:8000
```

Acesse `http://localhost:8000`.

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
