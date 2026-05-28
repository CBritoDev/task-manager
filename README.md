# Task Manager - Laravel & Vue

Uma aplicação Full Stack de gestão de tarefas por projetos, desenvolvida como teste técnico para a vaga de Full Stack Developer.

## 🚀 Sobre o Projeto e Transparência

Atualmente estou em um processo de transição e atualização de stack tecnológica. Para entregar este desafio com a máxima qualidade, aderência às melhores práticas e no prazo estabelecido, utilizei Inteligência Artificial como uma ferramenta de *pair programming*. Essa abordagem funcionou como um acelerador de aprendizagem para me adaptar às convenções modernas do Laravel 12 e do ecossistema Vue 3 (Composition API + Pinia). Com tempo, o esperado é que
todas as tecnologias assistidas sejam aprendidas e o pair programming não seja mais necessário.

Sou um profissional pragmático, focado em resolver problemas, adaptar-me rapidamente a novas ferramentas e entregar valor real.

---

## 🛠️ Tecnologias Utilizadas

- **Backend:** Laravel 12, PHP, SQLite
- **Frontend:** Vue 3, Vite, Tailwind CSS 4, Pinia e Vue Router
- **Testes:** Vitest + Vue Test Utils, PHPUnit

---

# ⚙️ Instruções de Instalação

## Setup do Backend (Laravel)

O backend foi configurado para rodar com SQLite, eliminando a necessidade de Docker ou configurações externas complexas. 
É necessária a instalaçao do PHP e Composer para realização dos passos abaixo.

### 1. Navegue até a pasta do backend

```bash
cd backend
```

### 2. Instale as dependências

```bash
composer install
```

### 3. Configure o ambiente

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Rode as migrações e seeders

```bash
php artisan migrate:fresh --seed
```

### 5. Inicie o servidor

```bash
php artisan serve
```

O backend ficará disponível em:

```txt
http://localhost:8000
```

---

## Setup do Frontend (Vue 3)

### 1. Navegue até a pasta do frontend

```bash
cd frontend
```

### 2. Instale as dependências

```bash
npm install
```

### 3. Inicie o servidor de desenvolvimento

```bash
npm run dev
```

O frontend ficará disponível em:

```txt
http://localhost:5173
```

O Vite já está configurado com proxy para a API Laravel, evitando problemas de CORS.

---

# 🧠 Decisões Técnicas Relevantes

## Optimistic Updates

Quando o usuário altera o status de uma tarefa, a interface é atualizada instantaneamente. A requisição ocorre em background e, em caso de erro, o estado anterior é restaurado automaticamente.

## Gestão de Estado com Pinia

As regras de negócio foram centralizadas em stores (`projectStore` e `taskStore`) em vez de espalhadas nos componentes visuais, facilitando testes e reatividade global.

## API Resources e Form Requests

Validações dedicadas foram aplicadas nos endpoints de escrita utilizando Form Requests. As respostas são padronizadas através de JsonResource.

## Rate Limiting e Soft Deletes

- Proteção contra abusos com `throttle:60,1`
- Exclusão lógica de tarefas utilizando `SoftDeletes`

---

# 🚧 O que ficou por implementar

## Interface de Paginação

### Situação

O backend já responde de forma paginada utilizando `paginate()` do Eloquent.

### Motivo

A interface visual da paginação não foi implementada para priorizar arquitetura, estado global e experiência responsiva.

---

## Drag-and-Drop

### Situação

O requisito permitia drag-and-drop ou dropdown simples.

### Motivo

Foi escolhido o dropdown simples por ser mais acessível, robusto e compatível com mobile-first.
