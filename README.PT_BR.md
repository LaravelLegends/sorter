#LaravelLegends\Sorter

É uma biblioteca criada para facilitar a ordenação dos de uma tabela ao clicar no link. Essa biblioteca funciona perfeitamente em Laravel 5.

Essa é uma versão inicial que futuramente será melhorada.


O uso da mesma se dá da seguinte forma:

```json
{
     "laravellegends/sorter" : "5.2.*"
}
```

`composer update`


Após isso, adicione os seguintes Services Provides e Facade:

```php

'providers' => [
     // ....

     LaravelLegends\Sorter\SorterProvider::class,
]



'aliases' = [

     'Sorter'  => LaravelLegends\Sorter\Facade::class,
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

$usuarios = App\Models\Usuario::where(['status' => 1])->orderBySorter()->get();


return view('usuarios.index', compact('usuarios'))

```

