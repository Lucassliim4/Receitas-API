Receitas API - RESTful Service

API RESTful para gerenciamento e cadastro de receitas culinárias, desenvolvida em PHP 8.3+ utilizando o padrão arquitetural MVC e banco de dados MySQL.

 Tecnologias Utilizadas

* **PHP 8.3+** (Arquitetura MVC sem framework)
* **MySQL / PDO** (Persistência de dados com *Prepared Statements*)
* **Laravel Herd** (Servidor web e ambiente local)
* **OpenAPI 3.0 / Swagger** (Documentação das rotas)
* **Insomnia** (Testes e validação dos endpoints)
* **Git & GitHub** (Versionamento de código)
* **Jira Software** (Gestão ágil do projeto em Kanban)


#Endpoints da API

A API conta com os seguintes endpoints para gerenciamento completo de receitas (`/receitas`):

| Método | Rota | Descrição |
| :--- | :--- | :--- |
| `GET` | `/receitas` | Retorna a lista de todas as receitas cadastradas. |
| `POST` | `/receitas` | Cria uma nova receita. |
| `GET` | `/receitas/{id}` | Busca os detalhes de uma receita específica por ID. |
| `PUT` | `/receitas/{id}` | Atualiza os dados de uma receita existente. |
| `DELETE` | `/receitas/{id}` | Remove uma receita do sistema. |

---

Documentação (Swagger)

A documentação interativa segue o padrão **OpenAPI 3.0** e está disponível no arquivo [`swagger.yaml`](./swagger.yaml) localizado na raiz do repositório.

Para visualizar graficamente:
1. Abra o arquivo no **VS Code** utilizando a extensão **Swagger Viewer** (`Shift + Alt + P`).
2. Ou cole o conteúdo em [editor.swagger.io](https://editor.swagger.io/).

---

Como Executar o Projeto Localmente

1. Certifique-se de ter o **Laravel Herd** e o **MySQL** rodando localmente.
2. Clone este repositório:
   ```bash
   git clone [https://github.com/SEU_USUARIO/receitas-api.git](https://github.com/SEU_USUARIO/receitas-api.git)