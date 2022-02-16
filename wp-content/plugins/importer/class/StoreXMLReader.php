<?php

class StoreXMLReader
{
    private $reader;
    private $tag;

    private function parseBlock($name, $ignoreDepth = 1) {
        if ($this->reader->name == $name && $this->reader->nodeType == XMLReader::ELEMENT) {
            $result = array();
            while (!($this->reader->name == $name && $this->reader->nodeType == XMLReader::END_ELEMENT)) {
                //echo $this->reader->name. ' - '.$this->reader->nodeType." - ".$this->reader->depth."\n";
                switch ($this->reader->nodeType) {
                    case 1:
                        if ($this->reader->depth > 3 && !$ignoreDepth) {
                            $result[$nodeName] = (isset($result[$nodeName]) ? $result[$nodeName] : array());
                            while (!($this->reader->name == $nodeName && $this->reader->nodeType == XMLReader::END_ELEMENT)) {
                                $resultSubBlock = $this->parseBlock($this->reader->name, 1);

                                if (!empty($resultSubBlock))
                                    $result[$nodeName][] = $resultSubBlock;

                                unset($resultSubBlock);
                                $this->reader->read();
                            }
                        }
                        $nodeName = $this->reader->name;
                        if ($this->reader->hasAttributes) {
                            $attributeCount = $this->reader->attributeCount;

                            for ($i = 0; $i < $attributeCount; $i++) {
                                $this->reader->moveToAttributeNo($i);
                                $result['attr'][$this->reader->name] = $this->reader->value;
                            }
                            $this->reader->moveToElement();
                        }
                        break;

                    case 3:
                    case 4:
                        $result[$nodeName] = $this->reader->value;
                        $this->reader->read();
                        break;
                }

                $this->reader->read();
            }
            return $result;
        }
    }

    public function parse($filename) {

        if (!$filename) return array();

        $this->reader = new XMLReader();
        $this->reader->open($filename);

        // begin read XML
        while ($this->reader->read()) {

            if ($this->reader->name == 'store_categories') {
                // while not found end tag read blocks
                while (!($this->reader->name == 'store_categories' && $this->reader->nodeType == XMLReader::END_ELEMENT)) {
                    $store_category = $this->parseBlock('store_category');

                    /*
                        Do some code
                    */

                    $this->reader->read();
                }

                $this->reader->read();
            }

        } // while
    } // func
}