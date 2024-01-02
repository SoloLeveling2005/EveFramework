<?php

namespace Clarity\Validation;

class Validator {
    protected $data;
    protected $errors = [];
    protected static $instance;

    // Защищаем конструктор, чтобы нельзя было создать объект напрямую
    protected function __construct() {}

    // Статический метод для создания экземпляра класса
    public static function make($data, $rules) {
        self::$instance = new self();
        self::$instance->data = $data;

        foreach ($rules as $field => $rule) {
            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $singleRule) {
                self::$instance->applyRule($field, $singleRule);
            }
        }

        return self::$instance;
    }

    public function failed() {
        return !empty($this->errors);
    }

    public function fails() {
        return $this->errors;
    }

    public function validate() {
        if ($this->failed()) {
            // В случае ошибок, вы можете принять меры по обработке или вернуть ошибки клиенту
            return $this->errors;
        }

        // Если валидация прошла успешно, вернуть валидные данные
        return $this->data;
    }

    protected function applyRule($field, $rule) {
        $ruleParts = explode(':', $rule);
        $methodName = 'validate' . ucfirst($ruleParts[0]);

        if (method_exists($this, $methodName)) {
            $this->$methodName($field, $ruleParts[1] ?? null);
        }
    }

    protected function validateRequired($field) {
        if (!isset($this->data[$field]) || empty($this->data[$field])) {
            $this->errors[$field][] = 'The ' . $field . ' field is required.';
        }
    }

    protected function validateMin($field, $min) {
        if (strlen($this->data[$field]) < $min) {
            $this->errors[$field][] = 'The ' . $field . ' field must be at least ' . $min . ' characters.';
        }
    }

    protected function validateMax($field, $max) {
        if (strlen($this->data[$field]) > $max) {
            $this->errors[$field][] = 'The ' . $field . ' field may not be greater than ' . $max . ' characters.';
        }
    }
}