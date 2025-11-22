
# Projeto Hotel (Marketplace de Quartos)

> Site em PHP para listar e gerenciar quartos, com autenticação, notificações e fluxo básico de reservas.

## Tecnologias utilizadas
- PHP
- MySQL
- HTML/CSS
- XAMPP - Servidor Local

## Recursos principais
- Cadastro e login de usuários (comprador, vendedor, admin)
- Listagem de quartos com thumbnails padronizadas
- Página de detalhe do quarto (`quarto.php`)
- Adição de quartos por vendedores (`add_quartos.php`)
- Notificações básicas e aceitação/rejeição de solicitações

## Estrutura do projeto

```
hotel/
├─ assets/
│  └─ css/style.css
├─ templates/
│  ├─ header.php
├─ src/
│  ├─ controllers/
│  │  └─ AuthController.php
│  ├─ models/
│  │  ├─ Room.php
│  │  ├─ User.php
│  │  └─ Notification.php
│  ├─ db.php
│  └─ start.php
├─ admin/
│  └─ listar.php
├─ quarto.php
├─ quartos.php
├─ login.php
├─ add_quartos.php
└─ README.md
```

## Configuração

1. Instale o [XAMPP](https://www.apachefriends.org/pt_br/index.html)
2. Coloque a pasta em `C:\xampp\htdocs\`.
3. Inicie Apache e MySQL pelo painel do XAMPP.
4. Abra o navegador em `http://localhost/Projeto/`.

## Banco de dados
- Arquivos do projeto criam tabelas `users`, `rooms` e `notifications` automaticamente ao conectar (via `src/db.php`).
O arquivo `src/db.php` tenta criar o banco e tabelas básicas automaticamente se o banco ainda não existir.

## Como usar

- Registrar um usuário em `login.php` (aba de cadastrar). Escolha `vendedor` para poder adicionar quartos.
- Vendedores: `add_quartos.php` para criar anúncios.
- Todos: `quartos.php` para ver listagem; `quarto.php?id=` para detalhe.
- Vendedores recebem notificações em `notifications.php` (aceitar/rejeitar solicitações).
