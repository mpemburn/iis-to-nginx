<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Saloon\XmlWrangler\XmlReader;

class ParseWebConfigService
{
    protected ?string $xmlContent = null;
    protected string $destination;
    protected string $outputFile = '';

    public static function isValidXml(string $filename): bool
    {
        $contents = file_get_contents($filename);

        $contents = trim($contents);
        if (empty($contents)) {
            return false;
        }

        libxml_use_internal_errors(true);
        simplexml_load_string($contents);
        $errors = libxml_get_errors();
        libxml_clear_errors();

        return empty($errors);
    }

    public function run(string $filepath, string $destination): self
    {
        $this->destination = $destination;

        // Read the web.config file and remove comments
        if (file_exists($filepath)) {
            $contents = file_get_contents($filepath);
            $this->xmlContent = $this->removeComments($contents);
        }

        return $this;
    }

    public function parse(): bool
    {
        if (! $this->xmlContent) {
            return false;
        }

        $reader = XmlReader::fromString($this->xmlContent);

        try {
            $rules = $reader->element('rules')->lazy();
            $iterator = $rules->current()->getContent();

            foreach ($iterator as $content) {
                $rules = $content->getContent();
                if (is_array($rules)) {
                    foreach ($rules as $rule) {
                        $name = $rule->getAttribute('name');
                        $match = $rule->getContent()['match']->getAttribute('url');
                        $type = $rule->getContent()['action']->getAttribute('type');
                        if ($type !== 'Redirect') {
                            continue;
                        }
                        $action = $rule->getContent()['action']->getAttribute('url');
                        $this->output($name, $match, $action);
                    }
                }
            }
        } catch (\Throwable $e) {
            return false;
        }

        if (! empty($this->outputFile)) {
            return $this->saveResult();
        }
    }

    public function saveResult(): bool
    {
        return Storage::put('output/' . $this->destination, $this->outputFile);
    }

    protected function output(string $name, string $match, string $action): void
    {
        $data = "# " . $name . "\n";
        if ($this->findRegex($match)) {
            $data .=  "location ~ ^" . $match . "$ {\n";
            $data .= "    proxy_pass \"http://localhost/" . $action . "$1\";\n";
        } else {
            $data .= "location " . $match . " {\n";
            $data .= "    proxy_pass \"http://localhost/" . $action . "\";\n";
        }
        $data .= "    proxy_set_header Host \$http_host;\n";
        $data .= "}\n\n";

        $this->outputFile .= $data;
    }

    protected function removeComments(string $content): string
    {
        return preg_replace('/<!--(.|\s)*?-->/', '', $content);
    }

    protected function findRegex(string $str): string
    {
        $regex = ['(.*)', '[0-9]', '*'];
        return (bool)array_intersect($regex, [$str]);
    }
}
