<?php

namespace Lwd\Eclogue;

/**
 * Data object for log entries.
 *
 * @author Johnathan Louie
 */
class LogEntry {

    /** @var string */
    private $message;

    /** @var string */
    private $level;

    /** @var array Extra log fields. */
    private $context = [];

    /**
     * Constructs the log entry.
     *
     * @param string $message
     * @param string $level
     */
    public function __construct($message, $level) {
        $this->message = $message;
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getLevel() {
        return $this->level;
    }

    /**
     * Get context field by name.
     *
     * @param string|int $name Field name.
     * @return mixed|null Null if field does not exist.
     */
    public function getContext($name) {
        if (array_key_exists($name, $this->context)) {
            return $this->context[$name];
        }
        return null;
    }

    /**
     * Adds or overwrites a context field.
     *
     * @param string|int $name
     * @param mixed $value
     * @return void
     */
    public function setContext($name, $value) {
        $this->context[$name] = $value;
    }

    /**
     * @return string[] List of context keys.
     */
    public function getContextKeys() {
        return array_keys($this->context);
    }

    /**
     * Adds a context array without overwriting existing keys.
     *
     * @param array $context
     * @return void
     */
    public function addContextArray($context) {
        foreach ($context as $name => $value) {
            $this->addContext($name, $value);
        }
    }

    /**
     * Inserts a value at the desired field name. If the name exists already,
     * then it keeps prefixing the name with an underscore until the name is
     * free. Returns the actual name where the insertion happened.
     *
     * @param string|int $name Desired field name.
     * @param mixed $value
     * @return string|int Actual field name where value was inserted.
     */
    public function addContext($name, $value) {
        $newName = $name;
        while (array_key_exists($newName, $this->context)) {
            $newName = "_{$newName}";
        }
        $this->context[$newName] = $value;
        return $newName;
    }

    /**
     * Adds a field to the context only if it does not exist yet.
     *
     * @param string|int $name
     * @param mixed $value
     * @return bool True if value was added.
     */
    public function addContextIfNotExist($name, $value) {
        if (array_key_exists($name, $this->context)) {
            return false;
        }
        $this->context[$name] = $value;
        return true;
    }

}
