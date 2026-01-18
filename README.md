# Sistema de Gestão de Estoque e Precificação

Sistema web para controle de produção, focado na composição de preços (BOM - Bill of Materials) e fluxo de caixa.
## Stack Tecnológica

- Backend: PHP 8.2 e Laravel.
- Frontend: Livewire, TailwindCSS e Alpine.js.
- Database: MySQL.
- Infra: Docker, Docker Compose, Nginx, Ubuntu Server.
##  Funcionalidades Chave
- CRUD Avançado: Gestão de Materiais, Produtos e Vendas
- Cálculos Financeiros
- Busca Real-Time
- Snapshots de Venda: Ao finalizar uma venda, o sistema grava os dados históricos (nome e preço) para garantir integridade de dados futuros, mesmo que o produto mude.
