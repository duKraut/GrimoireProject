# Grimório - Gerenciador de Coleção e Deck Builder Inteligente para Magic: The Gathering

Uma aplicação web desenvolvida com Laravel que oferece gerenciamento completo da sua coleção de cartas Magic: The Gathering, com busca inteligente via API Scryfall

## Tecnologias

| Tecnologia      | Versão | Descrição                                |
| --------------- | ------ | ---------------------------------------- |
| PHP             | 8.2+   | Linguagem de programação backend         |
| Laravel         | 12.0   | Framework web PHP                        |
| Laravel Fortify | 1.30   | Autenticação e autorização               |
| Livewire        | 2.1.1  | Componentes reativos do lado do servidor |
| Volt            | 1.7.0  | Stack moderno com Livewire + Laravel     |
| Tailwind CSS    | Latest | Framework CSS utilitário                 |
| Vite            | Latest | Build tool moderno                       |
| MySQL/SQLite    | Latest | Banco de dados                           |
| Composer        | Latest | Gerenciador de dependências PHP          |
| NPM             | Latest | Gerenciador de dependências JavaScript   |


##  Passo a Passo para Instalação e Execução

### Pré-requisitos

Certifique-se de ter instalado:
PHP 8.2+ [Download](https://www.php.net/downloads.php)
Composer [Download](https://getcomposer.org)
Node.js (LTS) [Download](https://nodejs.org/en/download)
NPM (incluído com Node.js)

### 1) Clonar o Repositório

```bash
git clone https://github.com/duKraut/GrimoireProject.git
cd GrimoireProject
```

### 2) Instalar o xampp

Rode a instalação do Xampp e ao final, vá nas configurações do **Apache** e pesquise por ";extension=zip" e remova o ";" entãop salve novamente

### 3) Instalar o PHP

Execute o instalador do PHP

### 4) Instalar Dependências PHP

```bash
composer install
```

### 5) Instalar dependencias JavaScript

```bash
npm install
```
### 6) Configurar Variaveis de Ambiente

Crie um arquivo .env a partir do exemplo:

```bash
cp .env.example .env
```
Edite o arquivo .env e configure:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=grimoire
DB_USERNAME=root
DB_PASSWORD=
```

### 7) Gerar Chave de Aplicação

```bash
php artisan key:generate
```

### 8) Executar as Migrations

```bash
php artisan migrate --seed
```

### 9) Compilar Assets (Sempre que for iniciar)

```bash
npm run build

ou

npm run dev
```



## 🔌 Documentação das APIs Utilizadas

### API Scryfall

O projeto utiliza a API Scryfall (gratuita, sem autenticação) para buscar informações de cartas Magic: The Gathering.

* Serviço: ScryfallApiService
* Arquivo: app/Services/ScryfallApiService.php

### Métodos principais:

```bash
// Buscar cartas
public function searchCards(string $query): array

// Buscar uma carta específica por nome
public function getCardByName(string $name): ?array

// Buscar cartas por tipo (creature, instant, sorcery, etc)
public function getCardsByType(string $type): array

// Buscar comandantes por cores
public function getCommandersByColor(array $colors): array
```

### Exemplos de Consumo

```bash
// Em um Controller
use App\Services\ScryfallApiService;

class CollectionController extends Controller
{
    public function search(Request $request, ScryfallApiService $scryfallApi)
    {
        $query = $request->validate(['query' => 'required|string|min:3']);
        
        // Buscar cartas
        $cards = $scryfallApi->searchCards($query['query']);
        
        return response()->json($cards);
    }
}
```

### Endpoints Scryfall Utilizados

```bash
GET https://api.scryfall.com/cards/search?q={query}
GET https://api.scryfall.com/cards/named?exact={name}
GET https://api.scryfall.com/cards/autocomplete?q={query}
```


### Parâmetros de Busca:

* type:creature - Buscar apenas criaturas
* type:instant - Buscar apenas instantâneos
* color:u - Buscar cartas azuis (u=azul, w=branco, b=preto, r=vermelho, g=verde)
* is:commander - Buscar apenas comandantes
* identity:ub - Buscar cartas com identidade de cor azul/preto
* power>3 - Buscar cartas com poder maior que 3


## 🔐 Autenticação e Autorização

### Autenticação

O projeto usa Laravel Fortify para gerenciamento de autenticação:

* Login com email/senha
