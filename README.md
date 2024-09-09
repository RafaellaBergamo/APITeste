---

# Configuração do Projeto

### Passos para Configuração

1. **Clone o projeto**

   ```bash
   git clone https://github.com/RafaellaBergamo/APITeste.git
   ```

2. **Abra o terminal na pasta do projeto e execute os seguintes comandos:**

   ```bash
   cp .env.example .env
   composer update
   php artisan key:generate
   php artisan serve
   ```

### Endpoints da API

#### Buscar todos os usuários

- **Método:** `GET`
- **URL:** `http://127.0.0.1:8000/api/usuarios`

#### Buscar por ID

- **Método:** `GET`
- **URL:** `http://127.0.0.1:8000/api/usuarios/{id}`
- **Exemplo de URL:** `http://127.0.0.1:8000/api/usuarios/1`

#### Cadastrar

- **Método:** `POST`
- **URL:** `http://127.0.0.1:8000/api/usuarios`
- **Exemplo de Requisição:**

  ```json
  {
    "nome": "Maria",
    "cpf": "42322605018",
    "dataNascimento": "14/01/2024",
    "telefone": "14982088891",
    "cep": "60831290",
    "numero": "",
    "email": "maria@email.com"
  }
  ```

#### Atualizar

- **Método:** `PUT`
- **URL:** `http://127.0.0.1:8000/api/usuarios/{id}`
- **Exemplo de Requisição:**

  ```json
  {
    "nome": "Manoela",
    "cpf": "42322605018",
    "dataNascimento": "14/01/2024",
    "telefone": "14982088891",
    "cep": "60831290",
    "numero": "",
    "email": "manoela@email.com"
  }
  ```

#### Desativar

- **Método:** `PUT`
- **URL:** `http://127.0.0.1:8000/api/usuarios/{id}/desativar`
- **Descrição:** Desativa um usuário.

#### Exportar

- **Método:** `GET`
- **URL:** `http://127.0.0.1:8000/api/usuarios/exportar/pdf`
- **Descrição:** Exporta todos os usuários para PDF.

---
