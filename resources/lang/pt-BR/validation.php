<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'O :attribute deve ser aceito.',
    'active_url' => 'O :attribute não é um URL válido.',
    'after' => 'O :attribute deve ser uma data posterior a :date.',
    'after_or_equal' => 'O :attribute deve ser uma data posterior ou igual a :date.',
    'alpha' => 'O atributo :deve conter apenas letras.',
    'alpha_dash' => 'O atributo :deve conter apenas letras, números, traços e sublinhados.',
    'alpha_num' => 'O atributo :deve conter apenas letras e números.',
    'array' => 'O atributo :deve ser uma matriz.',
    'before' => 'O atributo :deve ser uma data antes de :data.',
    'before_or_equal' => 'O atributo :deve ser uma data anterior ou igual a :data.',
    'between' => [
        'numeric' => 'O atributo :deve estar entre :min e :max.',
        'file' => 'O atributo :deve estar entre :min e :max kilobytes.',
        'string' => 'O atributo :deve estar entre os caracteres :min e :max.',
        'array' => 'O atributo :deve ter entre :min e :max itens.',
    ],
    'boolean' => 'O campo :attribute deve ser true ou false.',
    'confirmed' => 'A confirmação :attribute não corresponde.',
    'date' => 'O atributo :não é uma data válida.',
    'date_equals' => 'O atributo :deve ser uma data igual a :data.',
    'date_format' => 'O atributo :não corresponde ao formato :formato.',
    'different' => 'O atributo :e :other devem ser diferentes.',
    'digits' => 'O atributo :deve ser :digits dígitos.',
    'digits_between' => 'O atributo :deve estar entre :min e :max dígitos.',
    'dimensions' => 'O atributo :tem dimensões de imagem inválidas.',
    'distinct' => 'O campo :attribute tem um valor duplicado.',
    'email' => 'O atributo :deve ser um endereço de e-mail válido.',
    'ends_with' => 'O atributo :deve terminar com um dos seguintes: :Valores.',
    'exists' => 'O atributo :selected é inválido.',
    'file' => 'O :attribute deve ser um arquivo.',
    'filled' => 'O campo :attribute deve ter um valor.',
    'gt' => [
        'numeric' => 'O atributo :deve ser maior que :valor.',
        'file' => 'O atributo :deve ser maior que :valor kilobytes.',
        'string' => 'O atributo :deve ser maior que os caracteres :valor.',
        'array' => 'O atributo :deve ter mais de :itens de valor.',
    ],
    'gte' => [
        'numeric' => 'O atributo :deve ser maior ou igual :valor.',
        'file' => 'O atributo :deve ser maior ou igual a :kilobytes de valor.',
        'string' => 'O atributo :deve ser maior ou igual aos caracteres :valor.',
        'array' => 'O atributo :deve ter itens :valor ou mais.',
    ],
    'image' => 'O atributo :deve ser uma imagem.',
    'in' => 'O atributo :selected é inválido.',
    'in_array' => 'O campo :atributo não existe em :outros.',
    'integer' => 'O atributo :deve ser um inteiro.',
    'ip' => 'O atributo :deve ser um endereço IP válido.',
    'ipv4' => 'O atributo :deve ser um endereço IPv4 válido.',
    'ipv6' => 'O atributo :deve ser um endereço IPv6 válido.',
    'json' => 'O atributo :deve ser uma cadeia de caracteres JSON válida.',
    'lt' => [
        'numeric' => 'O atributo :deve ser menor que :valor.',
        'file' => 'O atributo :deve ser menor que :valor kilobytes.',
        'string' => 'O atributo :deve ser menor que os caracteres :valor.',
        'array' => 'O atributo :deve ter menos de :itens de valor.',
    ],
    'lte' => [
        'numeric' => 'O atributo :deve ser menor ou igual :valor.',
        'file' => 'O atributo :deve ser menor ou igual :kilobytes de valor.',
        'string' => 'O atributo :deve ser menor ou igual a caracteres :valor.',
        'array' => 'O atributo :não deve ter mais de :itens de valor.',
    ],
    'max' => [
        'numeric' => 'O atributo :não deve ser maior que :max.',
        'file' => 'O atributo :não deve ser maior que :max kilobytes.',
        'string' => 'O atributo :não deve ser maior que :max caracteres.',
        'array' => 'O atributo :não deve ter mais de :max itens.',
    ],
    'mimes' => 'O atributo :deve ser um arquivo do tipo: :valor.',
    'mimetypes' => 'O atributo :deve ser um arquivo do tipo: :valor.',
    'min' => [
        'numeric' => 'O atributo :deve ser pelo menos :min.',
        'file' => 'O atributo :deve ser pelo menos :min kilobytes.',
        'string' => 'O atributo :deve ter pelo menos :min caracteres.',
        'array' => 'O atributo :deve ter pelo menos :min itens.',
    ],
    'multiple_of' => 'O atributo :deve ser um múltiplo de :valor.',
    'not_in' => 'O atributo :selecionado é inválido.',
    'not_regex' => 'O formato :atributo é inválido.',
    'numeric' => 'O atributo :deve ser um número.',
    'password' => 'A senha está incorreta.',
    'present' => 'O campo :atributo deve estar presente.',
    'regex' => 'O formato :atributo é inválido.',
    'required' => 'O campo :atributo é obrigatório.',
    'required_if' => 'O campo :atributo é obrigatório quando :other é :valor.',
    'required_unless' => 'O campo :atributo é obrigatório, a menos que :other esteja em :valor.',
    'required_with' => 'O campo :atributo é obrigatório quando :valor está presente.',
    'required_with_all' => 'O campo :atributo é obrigatório quando :valor estão presentes.',
    'required_without' => 'O campo :atributo é obrigatório quando :valor não está presente.',
    'required_without_all' => 'O campo :atributo é obrigatório quando nenhum dos :valor está presente.',
    'prohibited' => 'O campo :atributo é proibido.',
    'prohibited_if' => 'O campo :atributo é proibido quando :other é :valor.',
    'prohibited_unless' => 'O campo :atributo é proibido, a menos que :other esteja em :valor.',
    'same' => 'O atributo :e o :other devem corresponder.',
    'size' => [
        'numeric' => 'O atributo :deve ser :tamanho.',
        'file' => 'O atributo :deve ser :Tamanho Kilobytes.',
        'string' => 'O atributo :deve ser :caracteres de tamanho.',
        'array' => 'O atributo :deve conter :itens de tamanho.',
    ],
    'starts_with' => 'O atributo :deve começar com um dos seguintes: :Valores.',
    'string' => 'O atributo :deve ser uma cadeia de caracteres.',
    'timezone' => 'O atributo :deve ser uma zona válida.',
    'unique' => 'O atributo :já foi tomado.',
    'uploaded' => 'O atributo :falhou ao carregar.',
    'url' => 'O formato :attribute é inválido.',
    'uuid' => 'O atributo :deve ser um UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'mensagem personalizada',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
