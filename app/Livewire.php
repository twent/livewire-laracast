<?php

declare(strict_types=1);

namespace App;

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

    public function fromSnapshot($snapshot): Component
    {
        $class = $snapshot['class'];
        $data = $snapshot['data'];

        $component = new $class;

        $this->setProperties($component, $data);

        return $component;
    }

    public function toSnapshot($component): array
    {
        $html = Blade::render(
            $component->render(),
            $properties = $this->getProperties($component)
        );

        $snapshot = [
            'class' => get_class($component),
            'data' => $properties
        ];

        return [$html, $snapshot];
    }

    public function getProperties(Component $component): array
    {
        $properties = [];

        $reflectionProperties = (new ReflectionClass($component))->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($reflectionProperties as $property) {
            $properties[$property->getName()] = $property->getValue($component);
        }

        return $properties;
    }

    public function setProperties(Component $component, $properties): void
    {
        foreach ($properties as $key => $value) {
            $component->{$key} = $value;
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

    public function call($component, $method): void
    {
        $component->{$method}();
    }
}
