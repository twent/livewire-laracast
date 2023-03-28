<?php

declare(strict_types=1);

namespace App;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Livewire\Component;
use ReflectionClass;
use ReflectionProperty;

final class Livewire
{
    public function initialRender(string $className): string
    {
        $component = new $className;

        if (method_exists($component, 'mount')) {
            $component->mount();
        }

        [$html, $snapshot] = $this->toSnapshot($component);

        $snapshotAttribute = htmlentities(json_encode($snapshot));

        return <<<HTML
            <div wire:snapshot="{$snapshotAttribute}">
                {$html}
            </div>
        HTML;
    }

    public function toSnapshot($component): array
    {
        $html = Blade::render(
            $component->render(),
            $properties = $this->getProperties($component)
        );

        [$data, $meta] = $this->dehydrateProperties($properties);

        $snapshot = [
            'class' => get_class($component),
            'data' => $data,
            'meta' => $meta,
        ];

        $snapshot['checksum'] = $this->generateChecksum($snapshot);

        return [$html, $snapshot];
    }

    public function fromSnapshot($snapshot): Component
    {
        $this->verifyChecksum($snapshot);

        $class = $snapshot['class'];
        $data = $snapshot['data'];
        $meta = $snapshot['meta'];

        $component = new $class;

        $properties = $this->hydrateProperties($data, $meta);

        $this->setProperties($component, $properties);

        return $component;
    }

    private function hydrateProperties(array $data, array $meta): array
    {
        $properties = [];

        foreach ($data as $name => $value) {
            if (key_exists($name, $meta)) {
                $value = match($meta[$name]) {
                    'collection' => collect($value),
                    'string' => $value ?? '',
                    'default' => $value,
                };
            }

            $properties[$name] = $value;
        }

        return $properties;
    }

    private function dehydrateProperties(array $properties): array
    {
        $data = $meta = [];

        foreach ($properties as $name => $value) {
            if (is_string($value)) {
                $meta[$name] = 'string';
            }

            if ($value instanceof Collection) {
                $value = $value->toArray();
                $meta[$name] = 'collection';
            }

            $data[$name] = $value;
        }

        return [$data, $meta];
    }

    private function getProperties(Component $component): array
    {
        $properties = [];

        $reflectionProperties = (new ReflectionClass($component))->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($reflectionProperties as $property) {
            $properties[$property->getName()] = $property->getValue($component);
        }

        return $properties;
    }

    private function setProperties(Component $component, array $properties): void
    {
        foreach ($properties as $name => $value) {
            $component->{$name} = $value;
        }
    }

    public function updateProperty($component, $property, $value): void
    {
        $component->{$property} = $value;

        $updatedHook = 'updated' . Str::title($property);

        if (method_exists($component, $updatedHook)) {
            $component->{$updatedHook}();
        }
    }

    public function call($component, string $method): void
    {
        $component->{$method}();
    }

    private function generateChecksum(array $snapshot): string
    {
        return md5(json_encode($snapshot));
    }

    /**
     * @throws Exception
     */
    private function verifyChecksum(array $snapshot): void
    {
        $checksum = $snapshot['checksum'];

        unset($snapshot['checksum']);

        if ($checksum !== $this->generateChecksum($snapshot)) {
            //throw new Exception(__('Stop hacking me!'));
        }
    }
}
