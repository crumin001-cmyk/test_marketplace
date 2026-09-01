<?php

return [

    'required' => ':attributeは必須です。',

    'email' => ':attributeは有効なメールアドレス形式で入力してください。',

    'max' => [
        'string' => ':attributeは:max文字以内で入力してください。',
    ],

    'min' => [
        'numeric' => ':attributeは:min以上で入力してください。',
    ],

    'integer' => ':attributeは数値で入力してください。',

    'regex' => ':attributeの形式が正しくありません。',

    'image' => ':attributeには画像ファイルを指定してください。',

    'mimes' => ':attributeは:values形式でアップロードしてください。',

    'array' => ':attributeを選択してください。',

    'unique' => ':attributeはすでに使用されています。',

    'custom' => [

        'description' => [
            'required' => '商品説明を入力してください。',
            'max' => '商品説明は255文字以内で入力してください。',
        ],

        'image' => [
            'required' => '商品画像を選択してください。',
            'image' => '商品画像を選択してください。',
            'mimes' => '商品画像はjpegまたはpng形式でアップロードしてください。',
        ],

        'condition_id' => [
            'required' => '商品の状態を選択してください。',
        ],

        'categories' => [
            'required' => '商品のカテゴリーを選択してください。',
            'array' => '商品のカテゴリーを選択してください。',
        ],

        'price' => [
            'required' => '商品価格を入力してください。',
            'integer' => '商品価格は数値で入力してください。',
            'min' => '商品価格は0円以上で入力してください。',
        ],

        'content' => [
            'required' => 'コメントを入力してください。',
            'max' => 'コメントは255文字以内で入力してください。',
        ],

        'payment_method' => [
            'required' => '支払い方法を選択してください。',
        ],

        'postal_code' => [
            'required' => '郵便番号を入力してください。',
            'regex' => '郵便番号はハイフンを入れて入力してください。',
        ],

        'address' => [
            'required' => '住所を入力してください。',
        ],
    ],

    'attributes' => [
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'description' => '商品説明',
        'image' => '画像',
        'condition_id' => '商品の状態',
        'categories' => '商品のカテゴリー',
        'price' => '商品価格',
        'content' => 'コメント',
        'payment_method' => '支払い方法',
        'postal_code' => '郵便番号',
        'address' => '住所',
        'building' => '建物名',
    ],

];
