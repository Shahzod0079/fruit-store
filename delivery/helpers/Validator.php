<?php
class Validator {
    
    // Проверка на пустоту
    public static function required($value, $fieldName) {
        if (empty(trim($value))) {
            return "Поле '$fieldName' обязательно для заполнения";
        }
        return null;
    }
    
    // Проверка числа
    public static function numeric($value, $fieldName) {
        if (!is_numeric($value)) {
            return "Поле '$fieldName' должно содержать число";
        }
        if ($value <= 0) {
            return "Поле '$fieldName' должно быть больше 0";
        }
        return null;
    }
    
    // Проверка телефона
    public static function phone($value, $fieldName) {
        // Удаляем все кроме цифр
        $digits = preg_replace('/[^0-9]/', '', $value);
        if (strlen($digits) < 10) {
            return "Поле '$fieldName' должно содержать 10 цифр";
        }
        return null;
    }
    
    // Проверка email
    public static function email($value, $fieldName) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "Поле '$fieldName' должно быть корректным email адресом";
        }
        return null;
    }
    
    // Проверка текста (мин/макс длина)
    public static function text($value, $fieldName, $min = 2, $max = 255) {
        $len = strlen(trim($value));
        if ($len < $min) {
            return "Поле '$fieldName' должно содержать минимум $min символов";
        }
        if ($len > $max) {
            return "Поле '$fieldName' не должно превышать $max символов";
        }
        return null;
    }
    
    // Проверка веса
    public static function weight($value) {
        if (!is_numeric($value)) {
            return "Вес должен быть числом";
        }
        if ($value <= 0) {
            return "Вес должен быть больше 0";
        }
        if ($value > 1000) {
            return "Вес не должен превышать 1000 кг";
        }
        return null;
    }
    
    // Проверка стоимости
    public static function cost($value) {
        if (!is_numeric($value)) {
            return "Стоимость должна быть числом";
        }
        if ($value <= 0) {
            return "Стоимость должна быть больше 0";
        }
        if ($value > 100000) {
            return "Стоимость не должна превышать 100 000 руб";
        }
        return null;
    }
    
    // Комплексная проверка клиента
    public static function validateClient($data) {
        $errors = [];
        
        $errors[] = self::required($data['full_name'], 'ФИО');
        $errors[] = self::text($data['full_name'], 'ФИО', 2, 150);
        $errors[] = self::required($data['phone'], 'Телефон');
        $errors[] = self::phone($data['phone'], 'Телефон');
        $errors[] = self::required($data['email'], 'Email');
        $errors[] = self::email($data['email'], 'Email');
        $errors[] = self::required($data['address'], 'Адрес');
        $errors[] = self::text($data['address'], 'Адрес', 5, 500);
        
        return array_filter($errors);
    }
    
    // Комплексная проверка заказа
    public static function validateOrder($data) {
        $errors = [];
        
        $errors[] = self::required($data['client_id'], 'Клиент');
        $errors[] = self::required($data['from_address'], 'Адрес отправления');
        $errors[] = self::text($data['from_address'], 'Адрес отправления', 5, 500);
        $errors[] = self::required($data['to_address'], 'Адрес доставки');
        $errors[] = self::text($data['to_address'], 'Адрес доставки', 5, 500);
        $errors[] = self::weight($data['weight']);
        $errors[] = self::cost($data['cost']);
        
        return array_filter($errors);
    }
    
    // Комплексная проверка курьера
    public static function validateCourier($data) {
        $errors = [];
        
        $errors[] = self::required($data['full_name'], 'ФИО');
        $errors[] = self::text($data['full_name'], 'ФИО', 2, 150);
        $errors[] = self::required($data['transport'], 'Транспорт');
        $errors[] = self::text($data['transport'], 'Транспорт', 2, 100);
        $errors[] = self::required($data['schedule'], 'График');
        
        return array_filter($errors);
    }
}