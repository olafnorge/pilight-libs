<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Volker Machon
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Pilight\Command;


use Pilight\AbstractCommand;

/**
 * Class Registry
 * @package Pilight\Command
 */
class Registry extends AbstractCommand
{
    protected $action = 'registry';
    protected $options = ['core' => 1, 'config' => 1, 'receiver' => 1];

    /**
     * @param string $key
     * @return bool
     */
    public function remove($key) {
        $command = ['key' => $key, 'type' => 'remove'];
        return $this->execute($command, [$this, 'evaluate']) === ['status' => 'success'];
    }

    /**
     * @param string $key
     * @param string|int $value
     * @return bool
     */
    public function set($key, $value) {
        $command = ['key' => $key, 'value' => $value, 'type' => 'set'];
        return $this->execute($command, [$this, 'evaluate']) === ['status' => 'success'];
    }
}