#LaravelLegends\Sorter

É uma biblioteca criada para facilitar a ordenação dos de uma tabela ao clicar no link. Essa biblioteca é para o Laravel 4.2.

O uso da mesma se dá da seguinte forma:

```json
{
     "laravellegends/sorter" : "4.2.*"
}
```

`composer update`


Após isso, adicione os seguintes Services Provides e Facade:

```php

'providers' => [
     // ....

     'LaravelLegends\Sorter\SorterProvider',
]



'aliases' = [

     'Sorter'  => 'LaravelLegends\Sorter\Facade',
]
```


Em seguida, é necessário trocar o alias `Eloquent` para a classe `Model` dessa pacote.

```php
    'aliases' =>  [
        //'Eloquent' => 'Illuminate\Database\Eloquent\Model',
        'Eloquent' => 'LaravelLegends\Sorter\Model'
    ]
```

Para usar essas funcionalidades, você deve agora na sua Tabela HTML inserir o seguinte código para gerar os links


```html

<th>{{ Sorter::link('id') }}</th>

<th>{{ Sorter::link('nome', 'Nome de Usuário') }}</th>


<th>{{ Sorter::link('username', 'Login', ['class' => 'btn btn-default']) }}</th>

```


No local da consulta é necessário adicionar o método `orderBySorter`.

```php

$usuarios = Usuario::where(['status' => 1])->orderBySorter()->get();


return View::make('usuarios.index', compact('usuarios'))

```

