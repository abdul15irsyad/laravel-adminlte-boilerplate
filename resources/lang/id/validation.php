<?php

return [
    'accepted' => ':attribute harus diterima.',
    'active_url' => ':attribute bukan url yang valid.',
    'after' => ':attribute harus tanggal setelah :date.',
    'after_or_equal' => ':attribute harus tanggal setelah atau sama dengan :date.',
    'alpha' => ':attribute hanya harus mengandung huruf.',
    'alpha_dash' => ':attribute harus hanya berisi huruf, angka, tanda hubung dan garis bawah.',
    'alpha_num' => ':attribute hanya harus mengandung huruf dan angka.',
    'array' => ':attribute harus berupa array.',
    'before' => ':attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => ':attribute harus antara :min dan :max.',
        'file' => ':attribute harus antara :min dan :max kilobytes.',
        'string' => ':attribute harus antara :min dan :max karakter.',
        'array' => ':attribute harus memiliki antara :min dan :max item.',
    ],
    'boolean' => ':attribute harus bernilai true atau false.',
    'confirmed' => ':attribute konfirmasi tidak cocok.',
    'date' => ':attribute bukan tanggal yang valid.',
    'date_equals' => ':attribute harus tanggal yang sama dengan :date.',
    'date_format' => ':attribute tidak cocok dengan format :format.',
    'different' => ':attribute dan :other harus berbeda.',
    'digits' => ':attribute harus :digits digit.',
    'digits_between' => ':attribute harus antara :min dan :max digit.',
    'dimensions' => ':attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => ':attribute memiliki nilai duplikat.',
    'email' => ':attribute harus alamat email yang valid.',
    'ends_with' => ':attribute harus diakhiri dengan salah satu dari yang berikut :values.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'file' => ':attribute harus berupa file.',
    'filled' => ':attribute harus memiliki nilai.',
    'gt' => [
        'numeric' => ':attribute harus lebih besar dari :value.',
        'file' => ':attribute harus lebih besar dari :value kilobytes.',
        'string' => ':attribute harus lebih besar dari :value karakter.',
        'array' => ':attribute harus memiliki lebih dari :value item.',
    ],
    'gte' => [
        'numeric' => ':attribute harus lebih besar dari atau sama :value.',
        'file' => ':attribute harus lebih besar dari atau sama :value kilobytes.',
        'string' => ':attribute harus lebih besar dari atau sama :value karakter.',
        'array' => ':attribute harus memiliki :value nilai atau lebih.',
    ],
    'image' => ':attribute harus menjadi gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'in_array' => ':attribute tidak ada di :other.',
    'integer' => ':attribute harus menjadi bilangan bulat.',
    'ip' => ':attribute harus alamat IP yang valid.',
    'ipv4' => ':attribute harus menjadi alamat IPv4 yang valid.',
    'ipv6' => ':attribute harus menjadi alamat IPv6 yang valid.',
    'json' => ':attribute harus menjadi string JSON yang valid.',
    'lt' => [
        'numeric' => ':attribute harus kurang dari :value.',
        'file' => ':attribute harus kurang dari :value kilobytes.',
        'string' => ':attribute harus kurang dari :value karakter.',
        'array' => ':attribute harus memiliki kurang dari :value item.',
    ],
    'lte' => [
        'numeric' => ':attribute harus kurang dari atau sama :value.',
        'file' => ':attribute harus kurang dari atau sama :value kilobytes.',
        'string' => ':attribute harus kurang dari atau sama :value karakter.',
        'array' => ':attribute tidak boleh memiliki lebih dari :value item.',
    ],
    'max' => [
        'numeric' => ':attribute tidak boleh lebih besar dari :max.',
        'file' => ':attribute tidak boleh lebih besar dari :max kilobytes.',
        'string' => ':attribute tidak boleh lebih besar dari :max karakter.',
        'array' => ':attribute tidak boleh memiliki lebih dari :max item.',
    ],
    'mimes' => ':attribute harus berupa file: :values.',
    'mimetypes' => ':attribute harus berupa file: :values.',
    'min' => [
        'numeric' => ':attribute setidaknya harus :min.',
        'file' => ':attribute setidaknya harus :min kilobytes.',
        'string' => ':attribute setidaknya harus :min karakter.',
        'array' => ':attribute setidaknya harus memiliki :min item.',
    ],
    'multiple_of' => ':attribute harus menjadi kelipatan :value.',
    'not_in' => ':attribute yang dipilih tidak valid.',
    'not_regex' => ':attribute format tidak valid.',
    'numeric' => ':attribute harus berupa angka.',
    'password' => 'kata sandi salah.',
    'present' => ':attribute harus ada.',
    'regex' => ':attribute format tidak valid.',
    'required' => ':attribute harus diisi.',
    'required_if' => ':attribute harus diisi ketika :other adalah :value.',
    'required_unless' => ':attribute harus diisi kecuali :other ada di :values.',
    'required_with' => ':attribute harus diisi ketika :values ada.',
    'required_with_all' => ':attribute harus diisi ketika :values ada.',
    'required_without' => ':attribute harus diisi ketika :values tidak ada.',
    'required_without_all' => ':attribute harus diisi ketika tidak ada :values.',
    'prohibited' => ':attribute tidak boleh diisi.',
    'prohibited_if' => ':attribute tidak boleh diisi :other adalah :value.',
    'prohibited_unless' => ':attribute tidak boleh diisi kecuali :other ada di :values.',
    'same' => ':attribute dan :other harus sama.',
    'size' => [
        'numeric' => ':attribute harus :size.',
        'file' => ':attribute harus :size kilobytes.',
        'string' => ':attribute harus :size karakter.',
        'array' => ':attribute harus berisi :size item.',
    ],
    'starts_with' => ':attribute harus mulai dengan salah satu dari yang berikut ini: :values.',
    'string' => ':attribute harus berupa string.',
    'timezone' => ':attribute harus menjadi zona yang valid.',
    'unique' => ':attribute sudah diambil.',
    'uploaded' => ':attribute gagal mengunggah.',
    'url' => ':attribute format tidak valid.',
    'uuid' => ':attribute harus berupa UUID yang valid.',

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
        'new_password' => [
            'regex' => ':attribute harus mengandung huruf kecil (a-z), huruf besar (A-Z), dan angka (0-9)',
        ],
        'username' => [
            'regex' => 'username hanya huruf kecil (a-z), angka (0-9), atau garis bawah "_"',
        ],
        'password' => [
            'regex' => 'kata sandi harus mengandung huruf kecil (a-z), huruf besar (A-Z), dan angka (0-9)',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'nama',
        'username' => 'username',
        'email' => 'email',
        'password' => 'kata sandi',
        'new_password' => 'kata sandi baru',
        'confirm_password' => 'konfirmasi kata sandi',
    ],

];
