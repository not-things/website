<?php

class Entry
{
    private int $reference;
    // The last eight bits are the TTL.
    private static int $TTL_MASK = 0xFF;
    private static int $TTL_SHIFT = 8;

    public static int $MAX_TTL = 60;

    function __construct()
    {
        $this->reference = 0;
        $this->reset_ttl();
    }

    function getRegularValue(): int
    {
        return $this->reference;
    }

    // Returns the new visitor count
    function increment(): int
    {
        $this->reference += (1 << self::$TTL_SHIFT);
        return $this->peek_count();
    }

    function reset_ttl(): void {
        $this->reference &= ~self::$TTL_MASK;
        $this->reference += self::$MAX_TTL;
    }

    function peek_count(): int
    {
        return ($this->reference & ~self::$TTL_MASK) >> self::$TTL_SHIFT;
    }

    // Returns the new decremented ttl unless the TTL reached zero
    function decrement_ttl(): int
    {
        if($this->peek_ttl() === 0) {
            return 0;
        }
        $this->reference-=1;
        return $this->peek_ttl();
    }

    function peek_ttl(): int
    {
        return $this->reference & self::$TTL_MASK;
    }

    function write_value($fd) : false | int {
        return fwrite($fd, $this->reference);
    }

    function copy_from($fd, bool $rewind = true): void
    {
        $val = fread($fd, PHP_INT_SIZE);
        if ($val === false) {
            exit(1);
        }

        if($rewind) {
            fseek($fd, -PHP_INT_SIZE, SEEK_CUR);
        }

        $this->reference = $val;

    }

}