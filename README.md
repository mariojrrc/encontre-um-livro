Encontre Um Livro
=================================================

Esse projeto é um exemplo/protótipo do um sistema de venda e troca de livros didáticos. Possui os arquivos html estáticos para demostração e um `docker-file.yml` exemplificando um possível arquitetura que faria uso de MongoDB, ElasticSearch, Redis e Nginx para balanceamento de carga entre 2 containers de aplicação.

## Executando o projeto
Opção 1:
```
git clone git@github.com:mariojrrc/encontre-um-livro.git
cd encontre-um-livro
composer install
composer serve

Acessar http://localhost:8084
```

Opção 2:
```
git clone git@github.com:mariojrrc/encontre-um-livro.git
cd encontre-um-livro
docker-compose up --build

Acessar http://localhost:8080
```
