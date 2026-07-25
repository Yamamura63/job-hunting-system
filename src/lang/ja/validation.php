<?php

return [

    'required' => ':attributeは必須です。',
    'email' => ':attributeには有効なメールアドレスを入力してください。',
    'confirmed' => ':attributeが一致しません。',
    'min' => [
        'string' => ':attributeは:min文字以上で入力してください。',
    ],
    'max' => [
        'string' => ':attributeは:max文字以内で入力してください。',
    ],
    'unique' => 'この:attributeはすでに登録されています。',
    'exists' => '選択された:attributeは存在しません。',
    'numeric' => ':attributeには数値を入力してください。',
    'integer' => ':attributeには整数を入力してください。',
    'url' => ':attributeには有効なURLを入力してください。',
    'date' => ':attributeには有効な日付を入力してください。',
    'after' => ':attributeには:dateより後の日付を指定してください。',
    'before' => ':attributeには:dateより前の日付を指定してください。',
    'same' => ':attributeが一致しません。',
    'different' => ':attributeは:valueと異なる値を指定してください。',
    'boolean' => ':attributeにはtrueまたはfalseを指定してください。',
    'array' => ':attributeには配列を指定してください。',
    'string' => ':attributeには文字列を指定してください。',
    'regex' => ':attributeの形式が正しくありません。',
    'in' => '選択された:attributeは無効です。',
    'not_in' => '選択された:attributeは無効です。',
    'required_if' => ':otherが:valueの場合、:attributeは必須です。',
    'required_with' => ':valuesが入力されている場合、:attributeは必須です。',
    'required_without' => ':valuesが入力されていない場合、:attributeは必須です。',
    'password' => 'パスワードが正しくありません。',

    'attributes' => [
        'name' => '名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード（確認）',
        'current_password' => '現在のパスワード',
        'new_password' => '新しいパスワード',
        'address' => '住所',
        'phone' => '電話番号',
        'url' => 'URL',
        'title' => 'タイトル',
        'description' => '説明',
        'company_name' => '企業名',
    ],

];
