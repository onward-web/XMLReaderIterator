<?php
/*
 * This file is part of the XMLReaderIterator package.
 *
 * Copyright (C) 2012, 2013 hakre <http://hakre.wordpress.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author hakre <http://hakre.wordpress.com>
 * @license AGPL-3.0 <http://spdx.org/licenses/AGPL-3.0>
 */

/**
 * Class XMLAttributeIterator
 *
 * Iterator over all attributes of the current node (if any)
 */
class XMLAttributeIterator implements Iterator, Countable, ArrayAccess, XMLReaderAggregate
{
    private $reader;
    private $valid;
    private $array;

    public function __construct(XMLReader $reader)
    {
        $this->reader = $reader;
    }

    public function count():int
    {
        return $this->reader->attributeCount;
    }

    public function current():mixed
    {
        return $this->reader->value;
    }

    public function key():mixed
    {
        return $this->reader->name;
    }

    public function next():void
    {
        $this->valid = $this->reader->moveToNextAttribute();
        if (!$this->valid) {
            $this->reader->moveToElement();
        }
    }

    public function rewind():void
    {
        $this->valid = $this->reader->moveToFirstAttribute();
    }

    public function valid():bool
    {
        return $this->valid;
    }

    public function getArrayCopy()
    {
        if ($this->array === null) {
            $this->array = iterator_to_array($this);
        }

        return $this->array;
    }

    public function getAttributeNames()
    {
        return array_keys($this->getArrayCopy());
    }

    public function offsetExists($offset):bool
    {
        $attributes = $this->getArrayCopy();

        return isset($attributes[$offset]);
    }

    public function offsetGet($offset):mixed
    {
        $attributes = $this->getArrayCopy();

        return $attributes[$offset];
    }

    public function offsetSet($offset, $value):void
    {
        throw new BadMethodCallException('XMLReader attributes are read-only');
    }

    public function offsetUnset($offset):void
    {
        throw new BadMethodCallException('XMLReader attributes are read-only');
    }

    /**
     * @return XMLReader
     */
    public function getReader()
    {
        return $this->getReader();
    }
}
