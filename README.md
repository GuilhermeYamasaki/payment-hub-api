# Payment Hub

## Requisitos

- [Docker](https://docs.docker.com/install/)  
- [Docker compose 2.x](https://docs.docker.com/compose/install/#prerequisites) 
- [Composer](https://getcomposer.org/)  
- [PHP 8.3](https://www.php.net/releases/8.3/en.php)
- [Sentry](https://sentry.io/welcome/) - Não obrigatório

## Iniciando o projeto

Clonar o repositório
```bash
git clone git@github.com:GuilhermeYamasaki/payment-hub-api.git
```

Entrar na pasta
```bash
cd payment-hub-api
```

Baixar dependencias do Composer
```bash
composer install
```

Copiar .env 
```bash
cp .env.example .env
```

Adicionar alias do Sail
```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

Construir container
```bash
sail up -d
```

Baixar dependencias do NPM
```bash
sail npm i
```

Gerar chave criptografada
```bash
sail artisan key:generate
```

Criar banco de dados
```bash
sail artisan migrate
```

Rode os testes
```bash
sail artisan test
```

Configure o MinIO
- Visite a seção **Configurando o MinIO** caso ainda não o tenha feito

Abrir um terminal e deixar executando
```bash
sail artisan horizon
```
## Enviando Arquivo

Para enviar um arquivo e testar o projeto, siga os passos abaixo:

1. **Baixe o arquivo** [Arquivo](https://kanastra.notion.site/signed/https%3A%2F%2Fprod-files-secure.s3.us-west-2.amazonaws.com%2F59520267-1a82-407d-90da-7f3c8d88bf7d%2F782b942b-d6a0-4a54-b6f5-f015c74bb95f%2Finput.csv?table=block&id=a3b4d8af-1895-4767-8a15-2010cbd6d745&spaceId=59520267-1a82-407d-90da-7f3c8d88bf7d&name=input.csv&cache=v2)

2. **Use um cliente HTTP** (como [Postman](https://www.postman.com/) ou `curl`) para enviar o arquivo. 

   ### Exemplo com `curl`:
   Substitua `{path/to/your/file}` pelo caminho do arquivo que você baixou e execute o curl abaixo:

   ```bash
   curl --request POST   --url http://localhost:8000/api/billing/process/csv   --header 'content-type: multipart/form-data'   --form attachment=@{path/to/your/file}
   ```
   
## Observalidade

- [Telescope](http://localhost:8000/telescope) : Acesse o Telescope para monitorar suas requisições e variáveis de ambiente
- [Horizon](http://localhost:8000/horizon) : Use o Horizon para visualizar e gerenciar suas filas de trabalho.
- [Sentry](https://sentry.io/welcome/) - Não obrigatório: Para integrar o Sentry, siga os passos abaixo:

    Abra o arquivo `.env` e preencha o campo `SENTRY_LARAVEL_DSN` com seu DSN do Sentry:
    ```bash
    SENTRY_LARAVEL_DSN=your_sentry_dsn_here
    ```

## Configurando o MinIO

1. **Acesse o painel do MinIO**:
   Abra seu navegador e vá para [Minio](http://localhost:9000). Use as credenciais abaixo para fazer login:

   - **Usuário**: `sail`
   - **Senha**: `password`

2. **Criar um bucket**:
   - Após fazer login, clique em "Buckets" no menu lateral.
   - Clique em "Create Bucket" e escolha um nome para o bucket.
   - Depois de criar o bucket, clique no nome dele para acessar as configurações.

3. **Definir o bucket como público**:
   - Dentro do bucket, clique em "Access Policy" (ícone de editar) e selecione a opção "Public"

4. **Criar Access Key e Secret Key**:
   - No canto superior esquerdo, clique "Access Keys" e após isso em "Create access key".
   - O MinIO irá gerar uma **Access Key** e uma **Secret Key**. Salve essas informações.

5. **Preencher o arquivo .env**:
   No arquivo `.env`, adicione as chaves geradas e o nome do bucket:

   ```bash
   AWS_BUCKET=nome_do_bucket
   AWS_ACCESS_KEY_ID=your_access_key_here
   AWS_SECRET_ACCESS_KEY=your_secret_key_here
