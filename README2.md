# Desafio CNPJ/CPF API

API REST desenvolvida em Laravel 11 para gerenciamento de fornecedores com validação de CNPJ/CPF.

## Requisitos

- Docker
- Docker Compose

## Configuração e Instalação

1. Clone o repositório:
```bash
git clone <repository-url>
cd desafio-cnpj-cpf
```

2. Copie o arquivo de ambiente:
```bash
cp .env.example .env
```

3. Inicie os containers Docker:
```bash
docker-compose up -d --build
```

4. Instale as dependências do projeto:
```bash
docker-compose exec app composer install
```

5. Gere a chave da aplicação:
```bash
docker-compose exec app php artisan key:generate
```

6. Execute as migrações:
```bash
docker-compose exec app php artisan migrate
```

A aplicação estará disponível em: http://localhost:8000

## Estrutura do Ambiente Docker

O ambiente é composto por três containers:
- **app**: PHP 8.2 FPM com a aplicação Laravel
- **nginx**: Servidor web Nginx
- **db**: MySQL 8.0

### Portas expostas:
- 8000: Aplicação web (Nginx)
- 3306: MySQL

## Endpoints da API

### Fornecedores (Suppliers)

- **GET** `/api/suppliers`: Lista todos os fornecedores (com paginação)
- **POST** `/api/suppliers`: Cria um novo fornecedor
- **GET** `/api/suppliers/{id}`: Obtém um fornecedor específico
- **PUT** `/api/suppliers/{id}`: Atualiza um fornecedor
- **DELETE** `/api/suppliers/{id}`: Remove um fornecedor
- **GET** `/api/suppliers/document/{document}`: Busca fornecedor por CNPJ/CPF

### Exemplo de Payload (POST/PUT)

```json
{
    "name": "Empresa Exemplo LTDA",
    "document": "12345678000199",
    "email": "contato@empresa.com",
    "phone": "(11) 99999-9999",
    "address": "Rua Exemplo, 123",
    "city": "São Paulo",
    "state": "SP",
    "zip_code": "01234567",
    "contact_name": "João Silva"
}
```

## Comandos Úteis

### Containers Docker

```bash
# Iniciar os containers
docker-compose up -d

# Parar os containers
docker-compose down

# Visualizar logs
docker-compose logs -f

# Acessar o container da aplicação
docker-compose exec app bash
```

### Artisan (Laravel)

```bash
# Executar migrations
docker-compose exec app php artisan migrate

# Limpar cache
docker-compose exec app php artisan cache:clear

# Listar rotas
docker-compose exec app php artisan route:list
```

## Validações

- CNPJ/CPF são validados através da API BrasilAPI
- Todos os campos são obrigatórios
- E-mail deve ser válido
- Documento (CNPJ/CPF) deve ser único no sistema
- Estado deve ter 2 caracteres
- CEP deve ter no máximo 9 caracteres

## Cache

- As consultas à API BrasilAPI são cacheadas por 1 hora para melhor performance

## Contribuindo

1. Faça o fork do projeto
2. Crie sua feature branch (`git checkout -b feature/nova-feature`)
3. Commit suas mudanças (`git commit -am 'Adicionando nova feature'`)
4. Push para a branch (`git push origin feature/nova-feature`)
5. Crie um Pull Request
